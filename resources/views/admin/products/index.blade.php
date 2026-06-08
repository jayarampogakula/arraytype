<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-100">Pending Products</h1>
    </div>

    <div class="space-y-4">
        @forelse($pendingProducts as $product)
            <div class="glass-panel rounded-xl p-5 border border-white/10">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-400 mt-1">{{ $product->tagline }}</p>
                        <div class="text-xs text-gray-500 mt-2">
                            {{ $product->category?->name ?? 'General' }} · Submitted by {{ $product->creator?->name ?? 'Unknown' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                            @csrf
                            <button type="submit"
                                class="bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-200 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                            @csrf
                            <button type="submit"
                                class="bg-red-500/20 hover:bg-red-500/30 text-red-200 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                Reject
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-sm text-gray-300 mt-4">
                    {{ $product->description }}
                </div>
            </div>
        @empty
            <div class="glass-panel rounded-xl p-8 text-center text-gray-400">
                No pending products.
            </div>
        @endforelse
    </div>
</x-app-layout>
