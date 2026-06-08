<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('members')->latest()->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_private' => 'boolean',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_private' => $request->is_private ?? false,
            'created_by' => auth()->id(),
        ]);

        // Auto-join as moderator
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'role' => 'moderator',
        ]);

        return redirect()->route('groups.show', $group)->with('success', 'Community created successfully!');
    }

    public function show(Group $group)
    {
        $group->loadCount('members');
        $members = $group->members()->with('user')->latest()->take(10)->get();
        $isMember = $group->members()->where('user_id', auth()->id())->exists();
        $posts = collect();
        if ($group->is_private == false || $isMember) {
            $posts = $group->posts()->with(['user', 'comments.user', 'likes', 'pollVotes'])->latest()->get();
        }

        return view('groups.show', compact('group', 'members', 'isMember', 'posts'));
    }

    public function join(Group $group)
    {
        if (!$group->members()->where('user_id', auth()->id())->exists()) {
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => auth()->id(),
                'role' => 'member',
            ]);
        }
        return back()->with('success', 'You joined the community!');
    }

    public function leave(Group $group)
    {
        $group->members()->where('user_id', auth()->id())->delete();
        return back()->with('success', 'You left the community.');
    }
}
