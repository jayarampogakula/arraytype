<x-app-layout>
    <div class="mb-8" x-data="{ tab: 'pending' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-white/10 pb-5 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Products Moderator</h1>
                <p class="text-sm text-gray-400 mt-1">Manage product launches and toggle premium homepage feature overrides.</p>
            </div>
            
            <!-- Tab Buttons -->
            <div class="flex bg-[#1b1f23] p-1.5 rounded-xl border border-white/5 self-start md:self-center">
                <button @click="tab = 'pending'" :class="tab === 'pending' ? 'bg-indigo-600 text-white font-bold' : 'text-gray-400 hover:text-white font-medium'" class="px-4 py-2 rounded-lg text-xs transition-all flex items-center gap-1.5">
                    📥 Pending Moderation
                    <span class="bg-black/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingProducts->count() }}</span>
                </button>
                <button @click="tab = 'approved'" :class="tab === 'approved' ? 'bg-indigo-600 text-white font-bold' : 'text-gray-400 hover:text-white font-medium'" class="px-4 py-2 rounded-lg text-xs transition-all flex items-center gap-1.5">
                    🟢 Approved Products
                    <span class="bg-black/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $approvedProducts->count() }}</span>
                </button>
            </div>
        </div>

        <!-- Pending Tab -->
        <div x-show="tab === 'pending'" class="space-y-4">
            @forelse($pendingProducts as $product)
                <div class="glass-panel rounded-xl p-5 border border-white/10 bg-[#1b1f23]/60 hover:bg-[#1b1f23]/80 transition">
                    <div class="flex items-start justify-between gap-6 flex-wrap md:flex-nowrap">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                {{ $product->name }}
                                <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Pending</span>
                            </h3>
                            <p class="text-sm text-gray-400 mt-1 font-medium">{{ $product->tagline }}</p>
                            <div class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                <span class="font-bold text-gray-400">{{ $product->category?->name ?? 'General' }}</span>
                                <span>·</span>
                                <span>Submitted by {{ $product->creator?->name ?? 'Unknown' }}</span>
                                <span>·</span>
                                <span>{{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/30 px-4 py-2 rounded-xl text-xs font-bold transition">
                                    Approve Launch
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 px-4 py-2 rounded-xl text-xs font-bold transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-gray-300 mt-4 bg-black/15 p-4 rounded-xl border border-white/[0.02] font-normal leading-relaxed">
                        {{ $product->description }}
                    </div>
                </div>
            @empty
                <div class="glass-panel rounded-xl p-12 text-center text-gray-400 border border-dashed border-white/10">
                    <div class="text-4xl mb-3">📥</div>
                    <p class="font-bold text-white">No products pending moderation</p>
                    <p class="text-xs text-gray-500 mt-1">All submissions have been reviewed.</p>
                </div>
            @endforelse
        </div>

        <!-- Approved Tab -->
        <div x-show="tab === 'approved'" class="space-y-4" x-cloak>
            @forelse($approvedProducts as $product)
                <div class="glass-panel rounded-xl p-5 border border-white/10 bg-[#1b1f23]/60 hover:bg-[#1b1f23]/80 transition">
                    <div class="flex items-start justify-between gap-6 flex-wrap md:flex-nowrap">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-lg font-bold text-white">{{ $product->name }}</h3>
                                @if($product->is_pinned)
                                    <span class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase flex items-center gap-1">
                                        📌 Pinned
                                    </span>
                                @endif
                                @if($product->featured_until && $product->featured_until->isFuture())
                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">
                                        ⭐ Featured
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-400 mt-1 font-medium">{{ $product->tagline }}</p>
                            <div class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                <span class="font-bold text-gray-400">{{ $product->category?->name ?? 'General' }}</span>
                                <span>·</span>
                                <span>Submitted by {{ $product->creator?->name ?? 'Unknown' }}</span>
                                <span>·</span>
                                <span>Launched {{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <form method="POST" action="{{ route('admin.products.toggle-pin', $product) }}">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $product->is_pinned ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-white/5 text-gray-300 hover:bg-white/10 border border-white/10' }}">
                                    {{ $product->is_pinned ? '📌 Unpin from 1st Page' : '📌 Pin to 1st Page (Premium)' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 px-4 py-2 rounded-xl text-xs font-bold transition">
                                    Revoke Launch
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-panel rounded-xl p-12 text-center text-gray-400 border border-dashed border-white/10">
                    <div class="text-4xl mb-3">🟢</div>
                    <p class="font-bold text-white">No approved products listed</p>
                    <p class="text-xs text-gray-500 mt-1">Once products are approved, they will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
