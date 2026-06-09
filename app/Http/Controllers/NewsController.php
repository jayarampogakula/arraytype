<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $newsQuery = News::with('author')->withCount('comments');

        if (!auth()->check() || !auth()->user()->is_admin) {
            $newsQuery->where(function ($query) {
                $query->where('status', 'approved');
                if (auth()->check()) {
                    $query->orWhere('user_id', auth()->id());
                }
            });
        }

        $tab = $request->input('tab', 'latest');
        $range = $request->input('range', 'today');

        if ($tab === 'trending') {
            $dateLimit = match ($range) {
                'today' => now()->subDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                default => now()->subDay(),
            };
            $newsQuery->where('created_at', '>=', $dateLimit)
                ->orderByDesc('views_count')
                ->orderByDesc('comments_count');
        } elseif ($tab === 'hot') {
            $newsQuery->orderByDesc('is_hot')
                ->orderByDesc('comments_count')
                ->orderByDesc('views_count');
        } elseif ($tab === 'views') {
            $newsQuery->orderByDesc('views_count');
        } else {
            $newsQuery->latest();
        }

        $news = $newsQuery->get();
        return view('news.index', compact('news', 'tab', 'range'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'source_url' => 'required|url|max:255',
            'summary' => 'required|string|max:2000',
            'category' => 'required|string|max:100',
        ]);

        News::create([
            'title' => $request->title,
            'source_url' => $request->source_url,
            'summary' => $request->summary,
            'category' => $request->category,
            'status' => 'pending',
            'url' => $request->source_url,
            'user_id' => Auth::id(),
            'is_hot' => false,
        ]);

        return redirect()->route('news.index')->with('success', 'News submitted successfully! Pending review.');
    }

    public function show(News $news)
    {
        if ($news->status !== 'approved' && !(auth()->check() && (auth()->user()->is_admin || $news->user_id === auth()->id()))) {
            abort(404);
        }

        // Increment view count
        $news->increment('views_count');

        $news->load(['author', 'comments.user']);

        return view('news.show', compact('news'));
    }

    public function comment(Request $request, News $news)
    {
        if ($news->status !== 'approved') {
            return back()->with('error', 'Comments are available after approval.');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $news->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Comment added.');
    }
}
