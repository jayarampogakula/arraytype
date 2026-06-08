<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\News;
use App\Models\Product;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $todayStart = Carbon::now()->startOfDay();
        $weekStart = Carbon::now()->startOfWeek();

        $trendingToday = Product::with(['category'])
            ->where('status', 'approved')
            ->withCount(['votes as votes_count' => function ($query) use ($todayStart) {
                $query->where('created_at', '>=', $todayStart);
            }])
            ->orderByDesc('votes_count')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $topThisWeek = Product::with(['category'])
            ->where('status', 'approved')
            ->withCount(['votes as votes_count' => function ($query) use ($weekStart) {
                $query->where('created_at', '>=', $weekStart);
            }])
            ->orderByDesc('votes_count')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $latestNews = News::where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        $newestJobs = JobListing::with('company')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('trendingToday', 'topThisWeek', 'latestNews', 'newestJobs'));
    }
}
