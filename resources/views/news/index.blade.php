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

    <!-- Tabs -->
    <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 px-4 pt-2 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 dark:border-white/10 pb-2">
            <div class="flex gap-6">
                <a href="{{ route('news.index', ['tab' => 'latest']) }}" 
                    class="text-sm pb-2 {{ $tab === 'latest' ? 'font-bold text-ai-primary border-b-2 border-ai-primary' : 'font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition' }}">Latest</a>
                <a href="{{ route('news.index', ['tab' => 'trending']) }}" 
                    class="text-sm pb-2 {{ $tab === 'trending' ? 'font-bold text-ai-primary border-b-2 border-ai-primary' : 'font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition' }}">Trending</a>
                <a href="{{ route('news.index', ['tab' => 'hot']) }}" 
                    class="text-sm pb-2 {{ $tab === 'hot' ? 'font-bold text-ai-primary border-b-2 border-ai-primary' : 'font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition' }}">🔥 Hot Picks</a>
                <a href="{{ route('news.index', ['tab' => 'views']) }}" 
                    class="text-sm pb-2 {{ $tab === 'views' ? 'font-bold text-ai-primary border-b-2 border-ai-primary' : 'font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition' }}">Most Viewed</a>
            </div>
            
            @if($tab === 'trending')
                <div class="flex items-center gap-2 bg-black/20 p-1 rounded-lg border border-white/5 text-xs text-gray-400">
                    <span class="font-bold pl-1">Range:</span>
                    <a href="{{ route('news.index', ['tab' => 'trending', 'range' => 'today']) }}" 
                        class="px-2.5 py-0.5 rounded transition {{ $range === 'today' ? 'bg-ai-primary text-white font-bold' : 'hover:text-white' }}">Today</a>
                    <a href="{{ route('news.index', ['tab' => 'trending', 'range' => 'week']) }}" 
                        class="px-2.5 py-0.5 rounded transition {{ $range === 'week' ? 'bg-ai-primary text-white font-bold' : 'hover:text-white' }}">Week</a>
                    <a href="{{ route('news.index', ['tab' => 'trending', 'range' => 'month']) }}" 
                        class="px-2.5 py-0.5 rounded transition {{ $range === 'month' ? 'bg-ai-primary text-white font-bold' : 'hover:text-white' }}">Month</a>
                </div>
            @endif
        </div>
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
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 mb-2 line-clamp-3 font-normal leading-relaxed">{{ $item->summary }}</p>
                    @endif
                    <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-gray-500 font-medium border-t border-white/5 pt-3">
                        @if($item->category)
                            <span class="px-2.5 py-0.5 rounded-md bg-ai-primary/10 text-ai-accent font-bold uppercase text-[9px] tracking-wider border border-ai-primary/20">{{ $item->category }}</span>
                        @endif
                        @if($item->is_hot)
                            <span class="px-2.5 py-0.5 rounded-md bg-red-500/10 text-red-400 font-bold uppercase text-[9px] tracking-wider border border-red-500/20">🔥 Hot Pick</span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            {{ $item->views_count }} Views
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            {{ $item->comments_count }} Comments
                        </span>
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