<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">AI Tools Directory</h1>
        <a href="{{ route('tools.create') }}"
            class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg font-medium text-sm">Submit
            Tool</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($tools as $tool)
            <div
                class="glass-panel rounded-xl p-5 border border-gray-200 dark:border-transparent hover:border-ai-primary/50 transition cursor-pointer">
                <div class="flex items-start space-x-4">
                    <div
                        class="h-14 w-14 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold border border-gray-200 dark:border-white/10 shrink-0">
                        @if($tool->logo)
                            <img src="{{ $tool->logo }}" alt="{{ $tool->name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            {{ strtoupper(substr($tool->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">{{ $tool->name }}</h3>
                        <span
                            class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium bg-ai-primary/20 text-ai-accent">{{ $tool->category ?? 'General AI' }}</span>
                        @if($tool->user)
                            <div class="mt-2 text-xs text-gray-500">
                                Submitted by <a href="{{ route('users.show', $tool->user) }}"
                                    class="text-gray-800 dark:text-gray-300 hover:text-ai-primary dark:hover:text-ai-accent transition">{{ $tool->user->name }}</a>
                            </div>
                        @endif
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $tool->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full glass-panel rounded-xl p-8 text-center text-gray-400">
                No tools listed yet. Add the first one!
            </div>
        @endforelse
    </div>
</x-app-layout>