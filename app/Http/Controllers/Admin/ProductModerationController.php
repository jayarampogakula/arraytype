<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductModerationController extends Controller
{
    public function index()
    {
        $pendingProducts = Product::with(['category', 'creator'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $approvedProducts = Product::with(['category', 'creator'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.products.index', compact('pendingProducts', 'approvedProducts'));
    }

    public function approve(Product $product)
    {
        $product->update(['status' => 'approved']);

        return back()->with('success', 'Product approved.');
    }

    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);

        return back()->with('success', 'Product rejected.');
    }

    public function togglePin(Request $request, Product $product)
    {
        $request->validate([
            'pin_type' => 'required|in:none,homepage,category',
            'duration' => 'nullable|in:1_day,7_days,30_days,indefinite',
        ]);

        $pinType = $request->input('pin_type');
        $duration = $request->input('duration');

        if ($pinType === 'none') {
            $product->update([
                'is_pinned' => false,
                'pin_type' => 'none',
                'pinned_until' => null,
            ]);
            return back()->with('success', "Product '{$product->name}' successfully unpinned.");
        }

        $pinnedUntil = null;
        switch ($duration) {
            case '1_day':
                $pinnedUntil = now()->addDay();
                break;
            case '7_days':
                $pinnedUntil = now()->addDays(7);
                break;
            case '30_days':
                $pinnedUntil = now()->addDays(30);
                break;
            case 'indefinite':
                $pinnedUntil = null;
                break;
        }

        $product->update([
            'is_pinned' => ($pinType === 'homepage' && !$pinnedUntil),
            'pin_type' => $pinType,
            'pinned_until' => $pinnedUntil,
        ]);

        $durationLabel = $duration === 'indefinite' ? 'indefinitely' : "for " . str_replace('_', ' ', $duration);
        $typeLabel = $pinType === 'homepage' ? 'Homepage' : 'Category page';

        return back()->with('success', "Product '{$product->name}' successfully pinned to {$typeLabel} {$durationLabel}.");
    }
}
