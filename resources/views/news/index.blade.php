<x-app-layout>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">AI News</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Stay up to date with the latest AI headlines.</p>
        </div>
        @auth
            <a href="{{ route('news.create') }}"
                class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg font-medium text-sm">Submit
                News</a>
        @endauth
    </div>

    <div class="space-y-4">
        @forelse($news as $item)
            <a href="{{ route('news.show', $item) }}"
                class="glass-panel rounded-xl p-5 border border-white/5 hover:border-ai-primary/50 transition block">
                <div>
                    <h3
                        class="text-lg font-bold text-gray-900 dark:text-gray-200 hover:text-ai-primary dark:hover:text-ai-accent transition">
                        {{ $item->title }}
                    </h3>
                    @if($item->summary)
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 mb-2 line-clamp-3">{{ $item->summary }}</p>
                    @endif
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                        @if($item->category)
                            <span class="px-2 py-0.5 rounded-full bg-ai-primary/10 text-ai-accent">{{ $item->category }}</span>
                        @endif
                        <span>Submitted by {{ $item->author->name ?? 'Unknown' }}</span>
                        <span>&bull;</span>
                        <span>{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="glass-panel rounded-xl p-8 text-center text-gray-400">
                No news submitted yet.
            </div>
        @endforelse
    </div>
</x-app-layout>