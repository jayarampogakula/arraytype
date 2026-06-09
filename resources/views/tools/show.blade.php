<x-app-layout>
    <div class="glass-panel rounded-2xl p-6 border border-white/10">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div class="flex items-start space-x-4">
                <div
                    class="h-16 w-16 rounded-xl bg-gray-800 flex items-center justify-center text-gray-400 font-bold border border-white/10 overflow-hidden">
                    @if($tool->logo)
                        <img src="{{ $tool->logo }}" alt="{{ $tool->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($tool->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $tool->name }}</h1>
                    @if($tool->user)
                        <p class="text-gray-400 mt-1">Submitted by <a href="{{ route('users.show', ['user' => $tool->user->username ?? $tool->user->id]) }}"
                                class="text-ai-accent hover:underline">{{ $tool->user->name }}</a></p>
                    @endif
                    <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-400">
                        <span
                            class="px-2 py-0.5 rounded-full bg-ai-primary/10 text-ai-accent">{{ $tool->category ?? 'General' }}</span>
                        <span>Added {{ $tool->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ $tool->url }}" target="_blank" rel="noopener"
                    class="px-4 py-2 bg-ai-primary hover:bg-ai-primary/80 rounded-lg text-sm text-white transition">Visit
                    Tool</a>
            </div>
        </div>

        <div class="mt-6 text-gray-300 leading-relaxed bg-gray-900/40 p-4 rounded-xl border border-white/5">
            {{ $tool->description }}
        </div>
    </div>
</x-app-layout>