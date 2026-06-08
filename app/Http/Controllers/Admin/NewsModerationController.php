<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsModerationController extends Controller
{
    public function index()
    {
        $pendingNews = News::with('author')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.news.index', compact('pendingNews'));
    }

    public function approve(News $news)
    {
        $news->update(['status' => 'approved']);

        return back()->with('success', 'News approved.');
    }

    public function reject(News $news)
    {
        $news->update(['status' => 'rejected']);

        return back()->with('success', 'News rejected.');
    }
}
