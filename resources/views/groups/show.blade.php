<x-app-layout>
    <div class="space-y-6">
        <!-- Group Header -->
        <div class="glass-panel rounded-xl p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center space-x-4">
                    @php
                        $icon = match($group->slug) {
                            'discussions' => '💬',
                            'showcases' => '🚀',
                            'questions' => '❓',
                            'tutorials' => '📚',
                            default => '👥'
                        };
                        $gradient = match($group->slug) {
                            'discussions' => 'from-blue-600 to-indigo-600 shadow-blue-500/10',
                            'showcases' => 'from-emerald-500 to-teal-500 shadow-emerald-500/10',
                            'questions' => 'from-purple-600 to-pink-600 shadow-purple-500/10',
                            'tutorials' => 'from-amber-500 to-orange-500 shadow-amber-500/10',
                            default => 'from-ai-primary to-ai-accent'
                        };
                    @endphp
                    <div
                        class="h-16 w-16 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white font-bold text-3xl flex-shrink-0 shadow-lg">
                        {{ $icon }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-100 flex items-center gap-2">
                            {{ $group->name }}
                        </h1>
                        <p class="text-gray-400 mt-1">{{ $group->description ?? 'No description.' }}</p>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>{{ $group->members_count }} Members</span>
                            <span>&bull;</span>
                            <span>Created by <span
                                    class="text-gray-300">{{ $group->creator->name ?? 'Unknown' }}</span></span>
                        </div>
                    </div>
                </div>
                <div>
                    @if($isMember)
                        <form method="POST" action="{{ route('groups.leave', $group) }}">
                            @csrf
                            <button
                                class="bg-white/10 hover:bg-red-500/30 text-gray-300 hover:text-red-400 transition px-4 py-2 rounded-lg text-sm font-medium">Leave</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('groups.join', $group) }}">
                            @csrf
                            <button
                                class="bg-ai-primary hover:bg-ai-primary/80 text-white transition px-4 py-2 rounded-lg text-sm font-semibold">Join
                                Community</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Members -->
        <div class="glass-panel rounded-xl p-5">
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Members</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($members as $member)
                    <div class="flex items-center space-x-2">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-tr from-ai-primary to-ai-accent flex items-center justify-center text-xs font-bold text-white">
                            {{ substr($member->user->name ?? '?', 0, 1) }}
                        </div>
                        <span class="text-sm text-gray-300">{{ $member->user->name ?? 'Unknown' }}</span>
                        @if($member->role === 'moderator')
                            <span class="text-xs text-ai-accent">Mod</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($group->is_private == false || $isMember)
        <div class="mt-8">
            <h3 class="text-lg font-bold text-gray-100 mb-4">Community Discussion</h3>
            @if($isMember)
                @include('feed.partials.create-post', ['group' => $group, 'defaultPostType' => ($group->slug === 'questions' ? 'ask' : 'text')])
            @endif
            @include('feed.partials.post-list', ['posts' => $posts])
        </div>
    @else
        <div class="mt-8 glass-panel rounded-xl p-8 text-center text-gray-400">
            This is a private community. Join to see posts and participate in discussions.
        </div>
    @endif
</x-app-layout>