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

        return view('admin.products.index', compact('pendingProducts'));
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
}
