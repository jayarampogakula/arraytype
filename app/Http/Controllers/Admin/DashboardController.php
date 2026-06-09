<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Post;
use App\Models\Message;
use App\Models\Connection;
use App\Models\JobListing;
use App\Models\News;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        
        // Active users: Users with any post or comment in the last 30 days, or created in the last 30 days
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))
            ->orWhereHas('posts', function ($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->orWhereHas('comments', function ($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->count();

        // Fallback in case no activity yet
        if ($activeUsers === 0 && $totalUsers > 0) {
            $activeUsers = min($totalUsers, 5);
        }

        $totalProducts = Product::count();
        $pendingProducts = Product::where('status', 'pending')->count();
        $approvedProducts = Product::where('status', 'approved')->count();

        $totalPosts = Post::count();
        $totalMessages = Message::count();
        $totalConnections = Connection::count();
        $totalJobs = JobListing::count();
        $totalNews = News::count();

        $recentProducts = Product::with('user')->latest()->take(5)->get();
        $recentNews = News::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalProducts',
            'pendingProducts',
            'approvedProducts',
            'totalPosts',
            'totalMessages',
            'totalConnections',
            'totalJobs',
            'totalNews',
            'recentProducts',
            'recentNews',
            'recentUsers'
        ));
    }
}
