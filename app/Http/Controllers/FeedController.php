<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes', 'pollVotes'])
            ->whereNull('group_id')
            ->latest()
            ->get();
        return view('feed.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'group_id' => 'nullable|exists:groups,id',
            'type' => 'nullable|in:text,ask,poll',
            'poll_options' => 'nullable|array|min:2|max:5',
            'poll_options.*' => 'required_with:poll_options|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv,quicktime|max:51200'
        ]);

        $type = $request->input('type', 'text');
        $pollOptions = null;

        if ($type === 'poll' && $request->has('poll_options')) {
            // Filter empty values and re-index sequentially
            $pollOptions = json_encode(array_values(array_filter($request->input('poll_options', []))));
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts/images', 'public');
                $imagePaths[] = $path;
            }
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('posts/videos', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'group_id' => $request->input('group_id'),
            'content' => $request->input('content'),
            'type' => $type,
            'poll_options' => $pollOptions,
            'images' => count($imagePaths) > 0 ? json_encode($imagePaths) : null,
            'video_path' => $videoPath,
        ]);

        return back()->with('success', 'Post created successfully!');
    }

    public function like(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => auth()->id()]);
            $liked = true;
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back();
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string|max:500']);
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        return back()->with('success', 'Comment added!');
    }

    public function votePoll(Request $request, Post $post)
    {
        if ($post->type !== 'poll') {
            return back()->with('error', 'This post is not a poll.');
        }

        $request->validate([
            'option_index' => 'required|integer|min:0'
        ]);

        $pollOptions = json_decode($post->poll_options, true) ?? [];
        if (!isset($pollOptions[$request->option_index])) {
            return back()->with('error', 'Invalid poll option.');
        }

        // Prevent users from voting multiple times on the same poll
        $existingVote = \App\Models\PollVote::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingVote) {
            return back()->with('error', 'You have already voted on this poll.');
        }

        \App\Models\PollVote::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'option_index' => $request->option_index,
        ]);

        return back()->with('success', 'Vote recorded!');
    }
}
