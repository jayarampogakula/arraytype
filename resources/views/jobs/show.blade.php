<x-public-layout>
    <div class="glass-panel rounded-2xl p-6 border border-white/10">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $job->title }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-400">
                    <span class="font-medium text-gray-300">{{ $job->company?->name ?? 'Unknown Company' }}</span>
                    <span>&bull;</span>
                    <span>{{ $job->remote ? 'Remote' : ($job->location ?? 'Location TBD') }}</span>
                    <span>&bull;</span>
                    <span class="px-2 py-0.5 rounded-full bg-ai-primary/10 text-ai-accent text-xs">{{ $job->type }}</span>
                    @if($job->salary_range)
                        <span>{{ $job->salary_range }}</span>
                    @endif
                </div>
            </div>
            @if($job->apply_url || $job->url)
                <a href="{{ $job->apply_url ?? $job->url }}" target="_blank" rel="noopener"
                    class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Apply
                </a>
            @endif
        </div>

        <div class="mt-6 text-gray-300 leading-relaxed">
            {!! nl2br(e($job->description)) !!}
        </div>
    </div>
</x-public-layout>
