<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeamController extends Controller
{
    private function checkSuperAdmin()
    {
        if (!auth()->check() || auth()->user()->admin_role !== 'super_admin') {
            abort(403, 'Access denied. Only Super Administrators can manage team members.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();

        $teamMembers = User::where('is_admin', true)
            ->whereNotNull('admin_role')
            ->orderByRaw("CASE admin_role 
                WHEN 'super_admin' THEN 1 
                WHEN 'moderator' THEN 2 
                WHEN 'editor' THEN 3 
                ELSE 4 END")
            ->get();

        return view('admin.team.index', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'admin_role' => ['required', 'in:super_admin,moderator,editor'],
        ]);

        // Clean name/username slug
        $username = 'admin_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->name));
        $baseUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'admin_role' => $request->admin_role,
            'email_verified_at' => now(),
        ]);

        // Initialize bio profile
        $user->profile()->create([
            'bio' => ucfirst($request->admin_role) . ' team member on ArrayType.',
            'skills' => 'Administration',
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', "Team member '{$user->name}' successfully added as " . ucfirst($request->admin_role) . "!");
    }

    public function update(Request $request, User $team)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'admin_role' => ['required', 'in:super_admin,moderator,editor'],
        ]);

        // Prevent self-demotion or self-change of role to ensure there is always at least one super_admin
        if (auth()->id() === $team->id && $request->admin_role !== 'super_admin') {
            return back()->with('error', 'You cannot change your own super_admin role.');
        }

        $team->update([
            'admin_role' => $request->admin_role,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', "Role for '{$team->name}' updated to " . ucfirst($request->admin_role) . ".");
    }

    public function destroy(User $team)
    {
        $this->checkSuperAdmin();

        // Prevent deleting oneself
        if (auth()->id() === $team->id) {
            return back()->with('error', 'You cannot remove yourself from the admin team.');
        }

        // Revoke admin access rather than deleting user record
        $team->update([
            'is_admin' => false,
            'admin_role' => null,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', "Team privileges revoked for '{$team->name}'. They are now a standard platform user.");
    }
}
