<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">AI Communities</h1>
        <a href="{{ route('groups.create') }}"
            class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg font-medium text-sm">Create
            Group</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($groups as $group)
            @php
                $icon = match($group->slug) {
                    'discussions' => '💬',
                    'showcases' => '🚀',
                    'questions' => '❓',
                    'tutorials' => '📚',
                    default => '👥'
                };
                $gradient = match($group->slug) {
                    'discussions' => 'from-blue-650 to-indigo-600 shadow-blue-500/10',
                    'showcases' => 'from-emerald-500 to-teal-550 shadow-emerald-500/10',
                    'questions' => 'from-purple-600 to-pink-600 shadow-purple-500/10',
                    'tutorials' => 'from-amber-500 to-orange-500 shadow-amber-500/10',
                    default => 'from-ai-primary to-ai-accent'
                };
            @endphp
            <a href="{{ route('groups.show', $group) }}" class="block">
                <div
                    class="glass-panel rounded-xl p-5 border border-white/5 hover:border-ai-primary/50 transition cursor-pointer">
                    <div class="flex items-start space-x-4">
                        <div
                            class="h-12 w-12 rounded-lg bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white font-bold text-xl shadow-md">
                            {{ $icon }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                {{ $group->description ?? 'No description provided.' }}
                            </p>
                            <div
                                class="mt-3 flex items-center space-x-4 text-xs font-medium text-gray-600 dark:text-gray-500">
                                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg> {{ $group->members_count }} Members</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full glass-panel rounded-xl p-8 text-center text-gray-400">
                No communities found. Be the first to start an AI group!
            </div>
        @endforelse
    </div>
</x-app-layout>