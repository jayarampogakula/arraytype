<x-app-layout :hideLeftSidebar="true" :hideRightSidebar="true">
    <style>
        body { background-color: #ffffff !important; }
        .dark body { background-color: #0f172a !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Secondary Category Menu -->
    <div class="bg-white dark:bg-ai-bg border-b border-gray-100 dark:border-white/5 shadow-sm relative z-20">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar pt-4 pb-0">
                <a href="{{ route('products.index') }}" class="text-[14px] font-bold text-ai-primary whitespace-nowrap pb-3 border-b-2 border-ai-primary">All Categories</a>
                @foreach([
                    'Writing & Content', 
                    'Image & Design', 
                    'Video & Audio', 
                    'Coding & Developer Tools', 
                    'Automation & Agents', 
                    'Productivity & Business', 
                    'Research & Data'
                ] as $cat)
                    <a href="#" class="text-[14px] font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white transition whitespace-nowrap pb-3 border-b-2 border-transparent hover:border-gray-200 dark:hover:border-gray-700">{{ $cat }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-12 text-sm">
            <!-- Left Side: Main Content (3/4) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-2">
                    <div class="h-8 w-8 bg-ai-primary rounded-full flex items-center justify-center text-white font-black text-lg shadow-sm">P</div>
                    <h1 class="text-[22px] font-bold text-gray-900 dark:text-white tracking-tight">Best of AIans <span class="text-gray-400 font-normal ml-1">| {{ $currentDate->format('F d, Y') }}</span></h1>
                </div>

                <!-- Tabs -->
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-0">
                    <div class="flex gap-6">
                        @foreach(['Daily', 'Weekly', 'Monthly', 'Yearly'] as $tab)
                            <a href="#" class="text-[13px] font-bold pb-3 {{ $loop->first ? 'text-ai-primary border-b-[3px] border-ai-primary' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white' }} transition-all">
                                {{ $tab }}
                            </a>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-4 pb-3">
                        <span class="text-[13px] text-ai-primary cursor-pointer hover:underline">Featured</span>
                        <span class="text-[13px] text-gray-500 cursor-pointer hover:underline">All</span>
                    </div>
                </div>

                <!-- Date Picker Strip -->
                <div class="flex items-center gap-1 mt-6 border border-gray-200 dark:border-white/10 rounded-md overflow-hidden bg-white dark:bg-ai-bg p-1 px-2">
                    <button class="px-2 text-gray-400 hover:text-gray-900 transition font-bold py-1">←</button>
                    <div class="flex items-center gap-0.5 overflow-x-auto no-scrollbar flex-grow">
                        @foreach($days as $day)
                            <div class="flex-shrink-0 flex flex-col items-center justify-center h-8 w-8 rounded transition-all cursor-pointer {{ $day['isCurrent'] ? 'bg-ai-primary/10 text-ai-primary font-bold' : 'text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 text-[13px]' }}">
                                <span>{{ $day['day'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <button class="px-2 text-gray-400 hover:text-gray-900 transition font-bold py-1">→</button>
                </div>

                <!-- Product List -->
                <div class="space-y-0 pt-2">
                    @forelse($products as $product)
                        <div class="group relative bg-white dark:bg-ai-bg hover:bg-gray-50 dark:hover:bg-white/[0.02] p-4 rounded-xl transition-all duration-200 cursor-pointer border border-transparent hover:border-gray-100 dark:hover:border-white/5">
                            <div class="flex items-start gap-4">
                                <!-- Product Logo -->
                                <a href="{{ route('products.show', $product) }}" class="h-[60px] w-[60px] rounded-xl bg-white border border-gray-100 dark:border-white/5 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($product->logo)
                                        <img src="{{ $product->logo }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xl font-black text-gray-500">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                    @endif
                                </a>

                                <!-- Product Info -->
                                <div class="flex-grow min-w-0 pt-0.5">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="text-[15px] font-bold text-gray-900 dark:text-white hover:text-ai-primary transition-colors truncate mb-0.5">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                    <p class="text-[13px] text-gray-600 dark:text-gray-400 line-clamp-1 mb-1">{{ $product->tagline }}</p>
                                    
                                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                        <span class="text-[11px] text-gray-500 flex items-center gap-1 hover:underline cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                            {{ $product->category?->name ?? 'Free' }}
                                        </span>
                                        <span class="text-gray-300 dark:text-gray-600 text-[10px]">•</span>
                                        <span class="text-[11px] text-gray-500 hover:underline cursor-pointer">Artificial Intelligence</span>
                                        <span class="text-gray-300 dark:text-gray-600 text-[10px]">•</span>
                                        <span class="text-[11px] text-gray-500 hover:underline cursor-pointer">Developer Tools</span>
                                    </div>
                                </div>

                                <!-- Engagement Actions -->
                                <div class="flex items-center gap-3 flex-shrink-0 pt-1 pl-4">
                                    <!-- Comments -->
                                    <a href="{{ route('products.show', $product) }}#discussion" class="flex flex-col items-center justify-center p-2 rounded-xl border border-transparent hover:border-gray-200 dark:hover:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5 transition group/action min-w-[3.5rem]">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-1 group-hover/action:text-ai-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                        <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 group-hover/action:text-ai-primary">{{ $product->comments_count }}</span>
                                    </a>

                                    <!-- Upvote Button -->
                                    @auth
                                        <form method="POST" action="{{ route('products.vote', $product) }}">
                                            @csrf
                                            <button type="submit" class="flex flex-col items-center justify-center p-2 rounded-xl border border-gray-200 dark:border-white/10 hover:border-ai-primary hover:bg-ai-primary/5 transition-all group/vote min-w-[3.5rem]">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover/vote:text-ai-primary transition mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                                <span class="text-[11px] font-bold text-gray-700 dark:text-gray-300 group-hover/vote:text-ai-primary">{{ $product->votes_count }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="flex flex-col items-center justify-center p-2 rounded-xl border border-gray-200 dark:border-white/10 hover:bg-gray-50 transition min-w-[3.5rem]">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                            <span class="text-[11px] font-bold text-gray-700 dark:text-gray-300">{{ $product->votes_count }}</span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-gray-50 rounded border border-dashed border-gray-200 dark:border-white/10">
                            <p class="text-gray-500 font-bold">No products found for this period.</p>
                            <a href="{{ route('products.create') }}" class="mt-4 inline-block text-ai-primary font-bold hover:underline underline-offset-4">Be the first to launch today!</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Side: Sidebar (1/4) -->
            <div class="lg:col-span-1 space-y-10 pt-2 lg:pl-4">
                <!-- Launch Archive -->
                <div class="space-y-4">
                    <h3 class="text-[13px] text-gray-800 dark:text-gray-200 font-normal">Launch Archive</h3>
                    <div class="space-y-3">
                        @php $years = range(2026, 2020); @endphp
                        @foreach($years as $year)
                            <div class="space-y-1 text-[13px]">
                                <div class="font-normal text-gray-700 dark:text-gray-300 cursor-pointer hover:underline">{{ $year }}</div>
                                @if($year == 2026)
                                    <div class="pl-2 space-y-1 border-l-2 border-ai-primary ml-1 mt-1">
                                        <a href="#" class="block text-ai-primary bg-ai-primary/10 p-1.5 px-3 rounded-md">March</a>
                                        <a href="#" class="block text-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 p-1.5 px-3 rounded-md transition relative"><span class="absolute left-[-15px] top-[14px] w-[3px] h-[3px] bg-gray-400 rounded-full"></span>February</a>
                                        <a href="#" class="block text-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 p-1.5 px-3 rounded-md transition relative"><span class="absolute left-[-15px] top-[14px] w-[3px] h-[3px] bg-gray-400 rounded-full"></span>January</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>