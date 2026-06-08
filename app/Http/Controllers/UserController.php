<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load(['profile', 'posts.comments', 'posts.likes', 'tools', 'news', 'company.jobListings']);

        $posts = $user->posts()->latest()->get();
        $tools = $user->tools()->latest()->get();
        $news = $user->news()->latest()->get();
        $jobs = $user->company ? $user->company->jobListings()->latest()->get() : collect();

        return view('users.show', compact('user', 'posts', 'tools', 'news', 'jobs'));
    }
}
