<x-public-layout>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center mb-12">
        <div>
            <p class="text-ai-accent text-sm font-semibold uppercase tracking-widest">ArrayType</p>
            <h1 class="text-4xl md:text-5xl font-bold text-white mt-3">Discover the best AI tools, news, and jobs.</h1>
            <p class="text-gray-400 mt-4 text-lg">ArrayType is a Product Hunt–style discovery hub for AI builders, with curated news and top roles in AI.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}"
                    class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-5 py-3 rounded-lg text-sm font-medium">Explore Products</a>
                <a href="{{ route('products.leaderboard', 'today') }}"
                    class="px-5 py-3 rounded-lg border border-white/10 text-sm text-gray-200 hover:text-white hover:border-white/30 transition">View Leaderboards</a>
            </div>
        </div>
        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <h2 class="text-lg font-semibold text-white mb-4">Trending Today</h2>
            <div class="space-y-3">
                @forelse($trendingToday as $product)
                    <a href="{{ route('products.show', $product) }}" class="flex items-center justify-between text-sm">
                        <span class="text-gray-200">{{ $product->name }}</span>
                        <span class="text-gray-500">{{ $product->votes_count }} votes</span>
                    </a>
                @empty
                    <div class="text-gray-400 text-sm">No products yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-white">Top AI Tools This Week</h2>
                <a href="{{ route('products.leaderboard', 'week') }}" class="text-xs text-ai-accent hover:text-white transition">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($topThisWeek as $product)
                    <a href="{{ route('products.show', $product) }}" class="flex items-center justify-between text-sm">
                        <span class="text-gray-200">{{ $product->name }}</span>
                        <span class="text-gray-500">{{ $product->votes_count }} votes</span>
                    </a>
                @empty
                    <div class="text-gray-400 text-sm">No rankings yet.</div>
                @endforelse
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-white">Latest AI News</h2>
                <a href="{{ route('news.index') }}" class="text-xs text-ai-accent hover:text-white transition">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($latestNews as $item)
                    <a href="{{ route('news.show', $item) }}" class="text-sm text-gray-200 hover:text-white transition">
                        {{ $item->title }}
                    </a>
                @empty
                    <div class="text-gray-400 text-sm">No news yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 glass-panel rounded-2xl p-6 border border-white/10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-white">Newest AI Jobs</h2>
            <a href="{{ route('jobs.index') }}" class="text-xs text-ai-accent hover:text-white transition">View all</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($newestJobs as $job)
                <a href="{{ route('jobs.show', $job) }}" class="glass-panel rounded-xl p-4 border border-white/10 hover:border-ai-primary/50 transition">
                    <div class="text-sm text-gray-200 font-semibold">{{ $job->title }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $job->company?->name ?? 'Unknown Company' }} · {{ $job->remote ? 'Remote' : ($job->location ?? 'Location TBD') }}</div>
                </a>
            @empty
                <div class="text-gray-400 text-sm">No jobs yet.</div>
            @endforelse
        </div>
    </div>
</x-public-layout>
