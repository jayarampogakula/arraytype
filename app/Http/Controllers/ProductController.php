<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::orderBy('name')->get();
        $activeCategory = null;

        $query = Product::with(['category', 'creator'])
            ->withCount(['votes', 'comments'])
            ->where('status', 'approved');

        if ($request->filled('category')) {
            $activeCategory = ProductCategory::where('slug', $request->input('category'))->firstOrFail();
            $query->where('category_id', $activeCategory->id);
        }

        $products = $query
            ->orderByDesc('featured_until')
            ->orderByDesc('launch_date')
            ->latest()
            ->paginate(18);

        $currentDate = Carbon::now();
        $days = [];
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $days[] = [
                'day' => $date->day,
                'isCurrent' => $date->isToday(),
                'date' => $date->toDateString(),
            ];
        }

        return view('products.index', compact('products', 'categories', 'activeCategory', 'currentDate', 'days'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|url|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'website_url' => 'required|url|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'launch_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['launch_date'] = $validated['launch_date'] ?? now()->toDateString();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product submitted! An admin will review it shortly.');
    }

    public function show(Product $product)
    {
        if ($product->status !== 'approved' && !($this->canViewPending($product))) {
            abort(404);
        }

        $product->load(['category', 'creator', 'comments.user'])
            ->loadCount(['votes', 'comments']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'approved')
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function vote(Product $product)
    {
        if ($product->status !== 'approved') {
            return back()->with('error', 'Voting is only available for approved products.');
        }

        if ($product->user_id === auth()->id()) {
            return back()->with('error', 'You cannot vote for your own product.');
        }

        ProductVote::firstOrCreate([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
        ], [
            'created_at' => now(),
        ]);

        return back()->with('success', 'Vote recorded.');
    }

    public function comment(Request $request, Product $product)
    {
        if ($product->status !== 'approved' && !($this->canViewPending($product))) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function leaderboard(string $range)
    {
        $start = match ($range) {
            'today' => Carbon::now()->startOfDay(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfDay(),
        };

        $products = Product::with(['category', 'creator'])
            ->where('status', 'approved')
            ->withCount(['votes as votes_count' => function ($query) use ($start) {
                $query->where('created_at', '>=', $start);
            }])
            ->orderByDesc('votes_count')
            ->orderByDesc('launch_date')
            ->take(30)
            ->get();

        return view('products.leaderboard', [
            'products' => $products,
            'range' => $range,
        ]);
    }

    private function canViewPending(Product $product): bool
    {
        return auth()->check()
            && (auth()->user()->is_admin || $product->user_id === auth()->id());
    }
}
