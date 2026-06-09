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

        if ($request->filled('category')) {
            $activeCategory = ProductCategory::where('slug', $request->input('category'))->first();
        }

        $now = now();
        $activeCategoryId = $activeCategory ? $activeCategory->id : 0;

        $query = Product::with(['category', 'creator'])
            ->withCount(['votes', 'comments'])
            ->where('status', 'approved')
            ->selectRaw('products.*, (
                (select count(*) from product_votes where product_votes.product_id = products.id) * 10 
                + (select count(*) from product_comments where product_comments.product_id = products.id) * 5 
                + (case 
                    when (is_pinned = 1 or (pin_type = "homepage" and pinned_until >= ?)) then 100000 
                    when (pin_type = "category" and pinned_until >= ? and ? > 0 and category_id = ?) then 100000 
                    else 0 
                  end)
                + (case when featured_until >= ? then 50000 else 0 end)
                - (timestampdiff(HOUR, created_at, ?) * 2)
            ) as ranking_score', [
                $now, 
                $now, 
                $activeCategoryId, 
                $activeCategoryId, 
                $now, 
                $now
            ]);

        if ($activeCategory) {
            $query->where('category_id', $activeCategory->id);
        }

        $products = $query
            ->orderByDesc('ranking_score')
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
        $validated['status'] = auth()->user()->isPremium() ? 'approved' : 'pending';
        $validated['launch_date'] = $validated['launch_date'] ?? now()->toDateString();

        $product = Product::create($validated);

        $message = auth()->user()->isPremium() 
            ? 'Product submitted and auto-approved because you are a Premium user! 🚀' 
            : 'Product submitted! An admin will review it shortly.';

        return redirect()->route('products.index')->with('success', $message);
    }

    public function show(Product $product)
    {
        if ($product->status !== 'approved' && !($this->canViewPending($product))) {
            abort(404);
        }

        // Increment view count
        $product->increment('views_count');

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

    public function recordClick(Product $product)
    {
        // Increment click count
        $product->increment('clicks_count');

        return redirect($product->website_url);
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
