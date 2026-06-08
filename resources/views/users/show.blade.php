<x-app-layout>
    <div class="mb-6 flex items-start space-x-6">
        <div
            class="h-24 w-24 rounded-full bg-ai-accent flex items-center justify-center text-gray-900 text-3xl font-bold flex-shrink-0">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div class="flex-grow pt-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h1>
            <p class="text-ai-primary dark:text-ai-accent font-medium mt-1">
                {{ $user->profile->bio ?? 'AI Enthusiast & Developer' }}</p>

            <div class="flex items-center mt-4 space-x-4">
                <div class="flex flex-col">
                    <span
                        class="text-gray-900 dark:text-gray-100 font-bold text-lg">{{ $user->followers->count() }}</span>
                    <span class="text-gray-600 dark:text-gray-500 text-xs uppercase tracking-wider">Followers</span>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-gray-900 dark:text-gray-100 font-bold text-lg">{{ $user->following->count() }}</span>
                    <span class="text-gray-600 dark:text-gray-500 text-xs uppercase tracking-wider">Following</span>
                </div>

                @if(auth()->id() !== $user->id)
                    @php
                        $connection = \App\Models\Connection::where(function ($q) use ($user) {
                            $q->where('user_id', auth()->id())->where('connected_user_id', $user->id);
                        })->orWhere(function ($q) use ($user) {
                            $q->where('user_id', $user->id)->where('connected_user_id', auth()->id());
                        })->first();
                    @endphp

                    @if($connection && $connection->status === 'accepted')
                        <button
                            class="ml-4 bg-gray-100 dark:bg-[#1b1f23] text-gray-500 px-6 py-2 rounded-full font-medium border border-gray-300 dark:border-white/10"
                            disabled>Connected</button>
                    @elseif($connection && $connection->status === 'pending')
                        <button
                            class="ml-4 bg-gray-100 dark:bg-[#1b1f23] text-gray-500 px-6 py-2 rounded-full font-medium border border-gray-300 dark:border-white/10"
                            disabled>Pending</button>
                    @else
                        <form action="{{ route('network.connect', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="ml-4 bg-ai-primary hover:bg-blue-600 transition text-white px-6 py-2 rounded-full font-medium cursor-pointer shadow flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Connect
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @if($user->profile && $user->profile->skills && is_array(json_decode($user->profile->skills)))
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach(json_decode($user->profile->skills) as $skill)
                <span
                    class="px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 text-xs">{{ $skill }}</span>
            @endforeach
        </div>
    @endif

    <div x-data="{ activeTab: 'posts' }" class="mt-8">
        <!-- Tabs Header -->
        <div class="flex border-b border-white/10 mb-6 overflow-x-auto">
            <button @click="activeTab = 'posts'"
                :class="activeTab === 'posts' ? 'border-ai-primary text-ai-primary' : 'border-transparent text-gray-500 hover:text-gray-300'"
                class="px-6 py-3 border-b-2 font-medium transition whitespace-nowrap">
                Posts ({{ $posts->count() }})
            </button>
            <button @click="activeTab = 'tools'"
                :class="activeTab === 'tools' ? 'border-ai-primary text-ai-primary' : 'border-transparent text-gray-500 hover:text-gray-300'"
                class="px-6 py-3 border-b-2 font-medium transition whitespace-nowrap">
                Tools ({{ $tools->count() }})
            </button>
            <button @click="activeTab = 'news'"
                :class="activeTab === 'news' ? 'border-ai-primary text-ai-primary' : 'border-transparent text-gray-500 hover:text-gray-300'"
                class="px-6 py-3 border-b-2 font-medium transition whitespace-nowrap">
                News ({{ $news->count() }})
            </button>
            <button @click="activeTab = 'jobs'"
                :class="activeTab === 'jobs' ? 'border-ai-primary text-ai-primary' : 'border-transparent text-gray-500 hover:text-gray-300'"
                class="px-6 py-3 border-b-2 font-medium transition whitespace-nowrap">
                Jobs ({{ $jobs->count() }})
            </button>
        </div>

        <!-- Tab Content -->
        <div x-show="activeTab === 'posts'">
            @include('feed.partials.post-list', ['posts' => $posts])
        </div>

        <div x-show="activeTab === 'tools'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($tools as $tool)
                    <div class="glass-panel rounded-xl p-5 border border-white/5">
                        <div class="flex items-start space-x-4">
                            <div
                                class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold border border-gray-200 dark:border-white/10">
                                @if($tool->logo)
                                    <img src="{{ $tool->logo }}" alt="{{ $tool->name }}"
                                        class="w-full h-full object-cover rounded-lg">
                                @else
                                    {{ substr($tool->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">{{ $tool->name }}</h3>
                                <span
                                    class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium bg-ai-primary/20 text-ai-accent">{{ $tool->category ?? 'General AI' }}</span>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                    {{ $tool->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-gray-500">No tools listed by this user.</div>
                @endforelse
            </div>
        </div>

        <div x-show="activeTab === 'news'" style="display: none;">
            <div class="space-y-4">
                @forelse($news as $item)
                    <div class="glass-panel rounded-xl p-5 border border-gray-200 dark:border-white/5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                            @if($item->url)
                                <a href="{{ $item->url }}" target="_blank"
                                    class="hover:text-ai-primary dark:hover:text-ai-accent">{{ $item->title }}</a>
                            @else
                                {{ $item->title }}
                            @endif
                        </h3>
                        @if($item->content)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 line-clamp-2">{{ $item->content }}</p>
                        @endif
                        <div class="mt-2 text-xs text-gray-500 flex items-center space-x-2">
                            <span>{{ $item->source }}</span>
                            <span>&bull;</span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-500">No news shared by this user.</div>
                @endforelse
            </div>
        </div>

        <div x-show="activeTab === 'jobs'" style="display: none;">
            <div class="space-y-4">
                @forelse($jobs as $job)
                    <div class="glass-panel rounded-xl p-5 border border-white/5 flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div
                                class="h-12 w-12 rounded bg-white p-1 flex items-center justify-center border border-gray-200">
                                @if($user->company && $user->company->logo)
                                    <img src="{{ $user->company->logo }}" alt="{{ $user->company->name }}"
                                        class="max-w-full max-h-full">
                                @elseif($user->company)
                                    <span class="text-gray-900 font-bold">{{ substr($user->company->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $job->title }}</h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $job->location }} &bull; {{ $job->type }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-500">No jobs posted by this user.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>