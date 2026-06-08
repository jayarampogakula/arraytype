<x-public-layout>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Product Leaderboard</h1>
            <p class="text-gray-400 mt-2">Top AI tools ranked by community votes.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('products.leaderboard', 'today') }}"
                class="px-3 py-1.5 rounded-full text-xs font-medium {{ $range === 'today' ? 'bg-ai-primary/20 text-ai-accent' : 'bg-white/5 text-gray-300' }}">
                Top Today
            </a>
            <a href="{{ route('products.leaderboard', 'week') }}"
                class="px-3 py-1.5 rounded-full text-xs font-medium {{ $range === 'week' ? 'bg-ai-primary/20 text-ai-accent' : 'bg-white/5 text-gray-300' }}">
                Top This Week
            </a>
            <a href="{{ route('products.leaderboard', 'month') }}"
                class="px-3 py-1.5 rounded-full text-xs font-medium {{ $range === 'month' ? 'bg-ai-primary/20 text-ai-accent' : 'bg-white/5 text-gray-300' }}">
                Top This Month
            </a>
            <a href="{{ route('products.leaderboard', 'year') }}"
                class="px-3 py-1.5 rounded-full text-xs font-medium {{ $range === 'year' ? 'bg-ai-primary/20 text-ai-accent' : 'bg-white/5 text-gray-300' }}">
                Top This Year
            </a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($products as $index => $product)
            <div class="glass-panel rounded-xl p-5 border border-white/10 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="text-lg font-semibold text-gray-400 w-8">#{{ $index + 1 }}</div>
                    <div class="h-12 w-12 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 font-bold border border-white/10">
                        @if($product->logo)
                            <img src="{{ $product->logo }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            {{ strtoupper(substr($product->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('products.show', $product) }}" class="text-lg font-bold text-gray-200 hover:text-white transition">
                            {{ $product->name }}
                        </a>
                        <div class="text-sm text-gray-400 mt-1">
                            {{ $product->category?->name ?? 'General' }}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-gray-500">Votes</div>
                    <div class="text-lg font-semibold text-white">{{ $product->votes_count }}</div>
                </div>
            </div>
        @empty
            <div class="glass-panel rounded-xl p-8 text-center text-gray-400">
                No products ranked yet.
            </div>
        @endforelse
    </div>
</x-public-layout>
