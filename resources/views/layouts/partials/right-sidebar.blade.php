<div class="space-y-4">
    <!-- Top AI News -->
    <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">ArrayType News</h2>
            <svg class="h-4 w-4 text-gray-500 cursor-pointer" fill="currentColor" viewBox="0 0 20 20" title="These are the top trending news stories on the platform">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1">Top stories</h3>
            
            @php
                $topNews = \App\Models\News::latest()->take(3)->get();
            @endphp
            
            @forelse($topNews as $news)
                <a href="{{ route('news.index') }}#news-{{ $news->id }}" class="block group">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200 group-hover:text-ai-primary group-hover:underline line-clamp-2">
                        {{ $news->title }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $news->created_at->diffForHumans() }} &bull; {{ rand(500, 5000) }} readers
                    </div>
                </a>
            @empty
                <p class="text-xs text-gray-500">No news available.</p>
            @endforelse
            
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition mt-2 px-1 py-0.5 rounded hover:bg-gray-100 dark:hover:bg-white/5">
                Show more
                <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Suggested Tools -->
    <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4">
        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-3">Today's top tools</h3>
        <div class="space-y-3">
            @php
                $topTools = \App\Models\Tool::inRandomOrder()->take(3)->get();
            @endphp
            
            @forelse($topTools as $tool)
                <a href="{{ route('tools.show', $tool) }}" class="flex items-center justify-between group">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-8 h-8 rounded bg-gray-100 dark:bg-gray-800 flex-shrink-0 flex items-center justify-center font-bold text-gray-500 text-xs border border-gray-200 dark:border-white/10 overflow-hidden">
                            @if($tool->logo)
                                <img src="{{ $tool->logo }}" alt="{{ $tool->name }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($tool->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="truncate">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200 group-hover:text-ai-primary group-hover:underline truncate">{{ $tool->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $tool->category ?? 'Tool' }}</div>
                        </div>
                    </div>
                    <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @empty
                <p class="text-xs text-gray-500">No tools available.</p>
            @endforelse
            
            <a href="{{ route('tools.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition mt-2 px-1 py-0.5 rounded hover:bg-gray-100 dark:hover:bg-white/5">
                Show more
                <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    </div>
</div>