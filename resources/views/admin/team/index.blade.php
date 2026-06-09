<x-app-layout :hideRightSidebar="true">
    <div class="py-6">
        <!-- Premium Header Area -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-indigo-900 mb-8 shadow-2xl border border-white/5">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="relative flex flex-col items-start justify-center p-8 md:p-10 z-10">
                <div class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-wider text-indigo-300 uppercase bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-4">
                    🛡️ Roster Management
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white md:text-4xl text-shadow-sm mb-2">
                    Admin Team Center
                </h1>
                <p class="max-w-2xl text-base text-gray-300 font-medium">
                    Assign administrative roles, audit permissions, and invite new members to help moderate ArrayType.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Invite Member (1/3) -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden relative">
                    <div class="h-2 w-full bg-gradient-to-r from-indigo-500 to-ai-primary"></div>
                    <div class="p-6 border-b border-gray-100 dark:border-white/5">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Add Team Member</h2>
                        <p class="text-xs text-gray-500 mt-1">Register a new user directly into the administrative roster.</p>
                    </div>

                    <form action="{{ route('admin.team.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5 ml-1">Full Name</label>
                            <input type="text" name="name" required placeholder="e.g. John Doe"
                                class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5 ml-1">Email Address</label>
                            <input type="email" name="email" required placeholder="e.g. john@arraytype.com"
                                class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5 ml-1">Temporary Password</label>
                            <input type="password" name="password" required placeholder="Minimum 8 characters"
                                class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5 ml-1">Assign System Role</label>
                            <select name="admin_role" required class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm font-medium cursor-pointer">
                                <option value="editor" class="bg-white dark:bg-gray-800">Editor (Content & Bots)</option>
                                <option value="moderator" class="bg-white dark:bg-gray-800">Moderator (Approvals & Reviews)</option>
                                <option value="super_admin" class="bg-white dark:bg-gray-800">Super Administrator (Full Access)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/20 text-sm flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Add Administrator
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Operational Roster (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-black/20 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Active Team Members</h2>
                                <p class="text-xs text-gray-500">Currently managing {{ $teamMembers->count() }} administrator accounts.</p>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach($teamMembers as $member)
                            <div class="p-5 flex items-start justify-between gap-6 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-all group" x-data="{ editing: false }">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar placeholder -->
                                    <div class="h-10 w-10 rounded-full bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center font-black text-indigo-400">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    
                                    <div class="min-w-0 pt-0.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900 dark:text-white text-[15px]">{{ $member->name }}</span>
                                            
                                            <!-- Role Badges -->
                                            @switch($member->admin_role)
                                                @case('super_admin')
                                                    <span class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Super Admin</span>
                                                    @break
                                                @case('moderator')
                                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Moderator</span>
                                                    @break
                                                @case('editor')
                                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Editor</span>
                                                    @break
                                            @endswitch

                                            @if(auth()->id() === $member->id)
                                                <span class="bg-white/10 text-white text-[9px] font-medium px-2 py-0.5 rounded-full">You</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $member->email }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Role Editing -->
                                    <div x-show="!editing" class="flex items-center gap-2">
                                        <button @click="editing = true" class="text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 p-1.5 rounded-lg bg-gray-50 dark:bg-white/5 border border-transparent hover:border-gray-200 dark:hover:border-white/10 transition opacity-0 group-hover:opacity-100 flex items-center gap-1 text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            Edit Role
                                        </button>

                                        @if(auth()->id() !== $member->id)
                                            <form action="{{ route('admin.team.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure you want to revoke admin privileges for this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 p-1.5 rounded-lg bg-red-500/5 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition opacity-0 group-hover:opacity-100 flex items-center gap-1 text-xs font-semibold">
                                                    Revoke Access
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Edit Inline Form -->
                                    <div x-show="editing" class="flex items-center gap-2" x-cloak>
                                        <form action="{{ route('admin.team.update', $member) }}" method="POST" class="flex items-center gap-1.5">
                                            @csrf
                                            @method('PUT')
                                            <select name="admin_role" class="bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-lg text-gray-900 dark:text-white text-xs p-1.5 outline-none transition font-medium cursor-pointer">
                                                <option value="editor" @selected($member->admin_role === 'editor')>Editor</option>
                                                <option value="moderator" @selected($member->admin_role === 'moderator')>Moderator</option>
                                                <option value="super_admin" @selected($member->admin_role === 'super_admin')>Super Admin</option>
                                            </select>
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm transition">
                                                Save
                                            </button>
                                            <button type="button" @click="editing = false" class="bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 text-xs font-bold px-3 py-1.5 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-white/10 transition">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
