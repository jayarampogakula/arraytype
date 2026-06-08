<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function store(\App\Models\User $user)
    {
        if (auth()->id() !== $user->id) {
            auth()->user()->following()->syncWithoutDetaching([$user->id]);
        }
        return back()->with('success', 'You are now following ' . $user->name);
    }

    public function destroy(\App\Models\User $user)
    {
        auth()->user()->following()->detach($user->id);
    }
}
