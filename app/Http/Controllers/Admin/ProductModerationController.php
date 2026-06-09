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

    public function togglePin(Product $product)
    {
        $product->update(['is_pinned' => !$product->is_pinned]);

        $status = $product->is_pinned ? 'pinned to the 1st page.' : 'unpinned from the 1st page.';
        return back()->with('success', "Product '{$product->name}' successfully {$status}");
    }
}
