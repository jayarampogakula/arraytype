<x-public-layout>
    <div class="glass-panel rounded-2xl p-6 border border-white/10">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $news->title }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-400">
                    @if($news->category)
                        <span class="px-2 py-0.5 rounded-full bg-ai-primary/10 text-ai-accent">{{ $news->category }}</span>
                    @endif
                    <span>Submitted by {{ $news->author->name ?? 'Unknown' }}</span>
                    <span>&bull;</span>
                    <span>{{ $news->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @if($news->source_url || $news->url)
                <a href="{{ $news->source_url ?? $news->url }}" target="_blank" rel="noopener"
                    class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Read Source
                </a>
            @endif
        </div>

        @if($news->summary)
            <div class="mt-6 text-gray-300 leading-relaxed">
                {{ $news->summary }}
            </div>
        @endif
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold text-white">Comments</h2>
        <div class="mt-4 space-y-4">
            @forelse($news->comments as $comment)
                <div class="glass-panel rounded-xl p-4 border border-white/10">
                    <div class="text-sm text-gray-400">
                        {{ $comment->user?->name ?? 'Anonymous' }} · {{ $comment->created_at->diffForHumans() }}
                    </div>
                    <div class="text-gray-200 mt-2">{{ $comment->content }}</div>
                </div>
            @empty
                <div class="glass-panel rounded-xl p-6 text-center text-gray-400">
                    No comments yet.
                </div>
            @endforelse
        </div>

        @auth
            <form method="POST" action="{{ route('news.comment', $news) }}" class="mt-6">
                @csrf
                <textarea name="content" rows="4"
                    class="w-full rounded-xl bg-gray-900/60 border border-white/10 text-gray-100 focus:border-ai-primary focus:ring-ai-primary"
                    placeholder="Share your thoughts..."></textarea>
                <div class="flex justify-end mt-3">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Add Comment
                    </button>
                </div>
            </form>
        @else
            <div class="mt-6 text-sm text-gray-400">
                <a href="{{ route('login') }}" class="text-ai-accent hover:text-white transition">Log in</a>
                to comment.
            </div>
        @endauth
    </div>
</x-public-layout>
