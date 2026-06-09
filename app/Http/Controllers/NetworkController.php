<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Connection;

class NetworkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Incoming connection requests (invitations)
        $invitations = Connection::where('connected_user_id', $user->id)
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        // Outgoing pending requests
        $sentRequests = Connection::where('user_id', $user->id)
            ->where('status', 'pending')
            ->has('connectedUser')
            ->with('connectedUser')
            ->latest()
            ->get();

        // Connections count
        $connectionsCount = Connection::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'accepted')
            ->count();

        // Fetch accepted connections details
        $connectionsList = Connection::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('connected_user_id', $user->id);
        })
            ->where('status', 'accepted')
            ->with(['user.profile', 'connectedUser.profile'])
            ->latest()
            ->get();

        $connections = $connectionsList->map(function ($conn) use ($user) {
            return $conn->user_id === $user->id ? $conn->connectedUser : $conn->user;
        });

        // Fetch following and followers
        $following = $user->following()->with('profile')->get();
        $followers = $user->followers()->with('profile')->get();
        $followingCount = $following->count();
        $followersCount = $followers->count();

        // Suggestions (exclude self, existing connections, and pending requests)
        // Correctly exclude users who have any connection record with current user
        $sentIds = Connection::where('user_id', $user->id)->pluck('connected_user_id')->toArray();
        $receivedIds = Connection::where('connected_user_id', $user->id)->pluck('user_id')->toArray();

        $connectedIds = array_unique(array_merge($sentIds, $receivedIds, [$user->id]));

        $suggestions = User::whereNotIn('id', $connectedIds)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('network.index', compact(
            'invitations', 
            'sentRequests', 
            'connectionsCount', 
            'suggestions', 
            'connections',
            'following',
            'followers',
            'followingCount',
            'followersCount'
        ));
    }

    public function connect(User $user)
    {
        if (auth()->id() === $user->id)
            return back();

        // Check if already connected or pending
        $exists = Connection::where(function ($q) use ($user) {
            $q->where('user_id', auth()->id())->where('connected_user_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('connected_user_id', auth()->id());
        })->exists();

        if (!$exists) {
            Connection::create([
                'user_id' => auth()->id(),
                'connected_user_id' => $user->id,
                'status' => 'pending'
            ]);
        }

        return back()->with('success', 'Connection request sent.');
    }

    public function accept(Connection $connection)
    {
        if ($connection->connected_user_id === auth()->id()) {
            $connection->update(['status' => 'accepted']);
        }
        return back();
    }

    public function ignore(Connection $connection)
    {
        if ($connection->connected_user_id === auth()->id()) {
            $connection->delete();
        }
        return back();
    }
}
