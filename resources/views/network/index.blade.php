<x-app-layout>
    <x-slot name="leftSidebar">
        <!-- Manage my network Sidebar -->
        <div
            class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden sticky top-24">
            <h2
                class="text-base font-semibold text-gray-900 dark:text-gray-100 p-4 border-b border-gray-200 dark:border-white/10">
                Manage my network</h2>
            <div class="py-2">
                <a href="#"
                    class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition group">
                    <div
                        class="flex items-center gap-3 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm font-medium">Connections</span>
                    </div>
                    <span class="text-sm text-gray-500">{{ $connectionsCount }}</span>
                </a>
                <a href="#"
                    class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition group">
                    <div
                        class="flex items-center gap-3 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Following & followers</span>
                    </div>
                </a>
                <a href="{{ route('groups.index') }}"
                    class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition group">
                    <div
                        class="flex items-center gap-3 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-medium">Groups</span>
                    </div>
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div x-data="{ activeTab: 'grow' }" class="space-y-4">

        <!-- Tabs -->
        <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 px-4 pt-2 mb-4">
            <div class="flex gap-6 border-b border-gray-200 dark:border-white/10">
                <button @click="activeTab = 'grow'" 
                    :class="activeTab === 'grow' ? 'pb-2 text-sm font-bold text-ai-primary border-b-2 border-ai-primary' : 'pb-2 text-sm font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition'">Grow</button>
                <button @click="activeTab = 'catch_up'" 
                    :class="activeTab === 'catch_up' ? 'pb-2 text-sm font-bold text-ai-primary border-b-2 border-ai-primary' : 'pb-2 text-sm font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition'">Catch
                    up</button>
            </div>
        </div>

        <!-- Grow Content -->
        <div x-show="activeTab === 'grow'">
            <!-- Invitations -->
            <div
                class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 mb-4">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-white/10">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Invitations
                        ({{ $invitations->count() }})</h2>
                    @if($invitations->count() > 0)
                        <button
                            class="text-sm font-semibold text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 px-2 py-1 rounded transition">Show
                            all</button>
                    @endif
                </div>

                <div class="divide-y divide-gray-200 dark:divide-white/5">
                    @forelse($invitations as $invitation)
                        <div class="p-4 flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('users.show', ['user' => $invitation->user->username ?? $invitation->user->id]) }}">
                                    <div
                                        class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-white/10 overflow-hidden flex items-center justify-center text-xl font-bold text-gray-400">
                                        {{ substr($invitation->user->name, 0, 1) }}
                                    </div>
                                </a>
                                <div>
                                    <a href="{{ route('users.show', ['user' => $invitation->user->username ?? $invitation->user->id]) }}"
                                        class="font-bold text-gray-900 dark:text-gray-100 hover:text-ai-primary hover:underline">{{ $invitation->user->name }}</a>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $invitation->user->profile->bio ?? 'AI Enthusiast' }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $invitation->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('network.ignore', $invitation) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-semibold text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 px-4 py-1.5 rounded-full transition text-sm">Ignore</button>
                                </form>
                                <form action="{{ route('network.accept', $invitation) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="font-semibold text-ai-primary border border-ai-primary hover:bg-blue-50 dark:hover:bg-ai-primary/10 px-4 py-1.5 rounded-full transition text-sm">Accept</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 text-sm">No pending invitations.</div>
                    @endforelse
                </div>
            </div>

            <!-- Sent Requests -->
            @if($sentRequests->count() > 0)
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 mb-4 overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Sent Requests ({{ $sentRequests->count() }})
                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @foreach($sentRequests as $request)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-white/5 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-white/10 group">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500/20 to-ai-primary/20 flex items-center justify-center text-ai-primary font-bold text-sm">
                                    {{ substr($request->connectedUser->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate w-32">{{ $request->connectedUser->name }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-wider font-bold">Pending Approval</div>
                                </div>
                            </div>
                            <form action="{{ route('network.ignore', $request) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-tight text-gray-400 hover:text-red-500 transition px-2 py-1 bg-gray-100 dark:bg-white/10 rounded-lg">Withdraw</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        <div
            class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Suggested Connections</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($suggestions as $suggestedUser)
                    <div class="border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden relative">
                        <!-- Cover Map -->
                        <div class="h-16 bg-gradient-to-r from-ai-primary/50 to-ai-accent/50 w-full absolute top-0 left-0">
                        </div>

                        <button
                            class="absolute top-2 right-2 z-20 p-1 text-white hover:bg-black/20 rounded-full transition bg-black/10 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div
                            class="pt-6 px-4 pb-4 select-none relative z-10 text-center flex flex-col h-full justify-between">
                            <div>
                                <!-- Avatar -->
                                <a href="{{ route('users.show', ['user' => $suggestedUser->username ?? $suggestedUser->id]) }}" class="block mx-auto h-20 w-20 mb-2">
                                    <div
                                        class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 border-4 border-white dark:border-[#1b1f23] overflow-hidden flex items-center justify-center text-3xl font-bold text-gray-400 mx-auto shadow-sm">
                                        {{ substr($suggestedUser->name, 0, 1) }}
                                    </div>
                                </a>

                                <a href="{{ route('users.show', ['user' => $suggestedUser->username ?? $suggestedUser->id]) }}"
                                    class="block font-bold text-gray-900 dark:text-gray-100 hover:underline">
                                    {{ $suggestedUser->name }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                    {{ $suggestedUser->profile->bio ?? 'AI Enthusiast & Developer' }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <form action="{{ route('network.connect', ['user' => $suggestedUser->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full font-semibold text-ai-primary border border-ai-primary hover:bg-blue-50 dark:hover:bg-ai-primary/10 hover:border-blue-600 px-4 py-1.5 rounded-full transition text-sm flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Connect
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-gray-500 text-sm">No new suggestions at this time.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Catch Up Content -->
        <div x-show="activeTab === 'catch_up'" style="display: none;">
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-8 text-center">
                <div class="text-gray-400 dark:text-gray-500 mb-4">
                    <svg class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">You're all caught up!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Check back later for recent updates from your network.</p>
            </div>
        </div>

    </div>
</x-app-layout>