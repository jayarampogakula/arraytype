<!-- Feed Items -->
<div class="space-y-6">
    @foreach($posts as $post)
        <div class="glass-panel rounded-xl p-5" x-data="{ 
                                        showComments: false, 
                                        showShare: false,
                                        liked: {{ $post->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }},
                                        likesCount: {{ $post->likes->count() }},
                                        toggleLike() {
                                            fetch('{{ route('posts.like', $post) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content'),
                                                    'Accept': 'application/json',
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                this.liked = data.liked;
                                                this.likesCount = data.likes_count;
                                            })
                                            .catch(error => console.error('Error:', error));
                                        }
                                    }">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('users.show', ['user' => $post->user->username ?? $post->user->id]) }}"
                        class="h-10 w-10 rounded-full bg-ai-accent flex items-center justify-center text-gray-900 font-bold hover:opacity-80 transition">
                        {{ substr($post->user->name ?? '?', 0, 1) }}
                    </a>
                    <div>
                        <a href="{{ route('users.show', ['user' => $post->user->username ?? $post->user->id]) }}"
                            class="font-bold text-gray-900 dark:text-gray-100 hover:text-ai-primary transition">{{ $post->user->name ?? 'Deleted User' }}</a>
                        <div class="text-[10px] uppercase font-black text-gray-500 dark:text-gray-400 tracking-wider">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

            @if($post->type === 'ask')
                <div class="mb-4">
                    <span
                        class="inline-block bg-ai-primary/20 text-ai-primary border border-ai-primary/30 text-xs font-bold px-2 py-0.5 rounded-md mb-2">QUESTION</span>
                    <div class="text-gray-900 dark:text-white text-lg font-bold leading-relaxed whitespace-pre-line">
                        {{ $post->content }}
                    </div>
                </div>
            @elseif($post->type === 'poll')
                <div class="mb-4">
                    <span
                        class="inline-block bg-ai-accent/20 text-ai-accent border border-ai-accent/30 text-xs font-bold px-2 py-0.5 rounded-md mb-2">POLL</span>
                    <div class="text-gray-900 dark:text-gray-200 text-base font-bold leading-relaxed whitespace-pre-line mb-3">
                        {{ $post->content }}
                    </div>
                    @if($post->poll_options)
                        <div class="space-y-2 mt-3 bg-black/20 p-4 rounded-xl border border-white/5">
                            @foreach(json_decode($post->poll_options) as $option)
                                <button type="button"
                                    class="w-full text-left relative bg-white/5 border border-white/10 hover:border-ai-primary/50 hover:bg-white/10 transition p-3 rounded-lg flex items-center justify-between group">
                                    <span class="text-gray-800 dark:text-gray-200 text-sm relative z-10 font-bold">{{ $option }}</span>
                                    <div
                                        class="h-4 w-4 rounded-full border border-gray-500 group-hover:border-ai-primary relative z-10">
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-gray-800 dark:text-gray-200 text-base leading-relaxed whitespace-pre-line mb-4">
                    {{ $post->content }}
                </div>
            @endif

            <hr class="border-white/10 my-3">

            <div class="flex items-center space-x-4 sm:space-x-6 text-gray-400 text-sm relative">
                <button type="button" @click="toggleLike()" class="flex items-center space-x-2 transition"
                    :class="liked ? 'text-ai-primary' : 'hover:text-ai-primary'">
                    <svg class="h-5 w-5" :fill="liked ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                    <span x-text="likesCount"></span>
                    <span class="hidden sm:inline">Likes</span>
                </button>

                <button @click="showComments = !showComments"
                    class="flex items-center space-x-2 hover:text-ai-accent transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>{{ $post->comments->count() }}</span>
                    <span class="hidden sm:inline">Comments</span>
                </button>

                <div class="relative">
                    <button @click="showShare = !showShare" @click.away="showShare = false"
                        class="flex items-center space-x-2 hover:text-white transition group">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        <span>Share</span>
                    </button>

                    <div x-show="showShare" style="display: none;"
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-gray-800 ring-1 ring-white/10 ring-opacity-5 focus:outline-none z-50">
                        <div class="py-1">
                            <a href="#"
                                @click.prevent="navigator.clipboard.writeText('{{ url('/dashboard') }}' + '#post-{{ $post->id }}'); showShare = false;"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white">
                                Copy Link
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/dashboard') . '#post-' . $post->id) }}&text=Check+out+this+post+on+ArrayType!"
                                target="_blank"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white">
                                Share to Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url('/dashboard') . '#post-' . $post->id) }}&title=ArrayType%20Post"
                                target="_blank"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white">
                                Share to LinkedIn
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/dashboard') . '#post-' . $post->id) }}"
                                target="_blank"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white">
                                Share to Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section (Alpine Toggle) -->
            <div x-show="showComments" style="display: none;" class="mt-4 pt-4 border-t border-white/5">
                @foreach($post->comments as $comment)
                    <div class="mb-3 p-3 bg-gray-50/50 dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/5">
                        <div class="flex items-start justify-between">
                            <div class="font-bold text-gray-900 dark:text-gray-200 text-xs">{{ $comment->user->name }}</div>
                            <div class="text-gray-500 dark:text-gray-500 text-[10px] font-bold uppercase">
                                {{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-400 mt-1">{{ $comment->content }}</div>
                    </div>
                @endforeach

                <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-3 flex space-x-2">
                    @csrf
                    <input type="text" name="content" required placeholder="Write a comment..."
                        class="flex-grow bg-white/5 border border-white/10 rounded-lg text-gray-200 px-3 py-2 text-sm focus:ring-ai-primary focus:border-ai-primary">
                    <button type="submit"
                        class="bg-ai-primary/20 text-ai-primary hover:bg-ai-primary hover:text-white transition px-4 py-2 rounded-lg text-sm font-medium">Post</button>
                </form>
            </div>
        </div>
    @endforeach

    @if($posts->isEmpty())
        <div class="glass-panel rounded-xl p-8 text-center text-gray-400">
            No posts to display here yet. Be the first one!
        </div>
    @endif
</div>