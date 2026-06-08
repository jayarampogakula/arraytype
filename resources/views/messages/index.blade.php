<x-app-layout>
    <x-slot name="leftSidebar">
        <!-- Optional empty sidebar for full width feel -->
        <div class="hidden"></div>
    </x-slot>

    <!-- Full width container override for messaging -->
    <style>
        .max-w-7xl {
            max-width: 90rem !important;
        }

        .lg\:grid-cols-4 {
            display: block !important;
        }

        .lg\:col-span-2 {
            max-width: 100% !important;
            margin: 0 auto;
        }
    </style>

    <div class="glass-panel bg-white dark:bg-[#1b1f23] rounded-xl shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden flex"
        style="height: calc(100vh - 120px);">
        <!-- Conversations List (Left Pane) -->
        <div class="w-1/3 border-r border-gray-200 dark:border-white/10 flex flex-col bg-gray-50 dark:bg-black/10">
            <div
                class="p-4 border-b border-gray-200 dark:border-white/10 flex justify-between items-center bg-white dark:bg-[#1b1f23]">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Messaging</h2>
            </div>

            <div class="overflow-y-auto flex-grow divide-y divide-gray-200 dark:divide-white/5">
                @forelse($conversations as $conv)
                    @php
                        $otherUser = $conv->users->first();
                        $isActive = isset($conversation) && $conversation->id === $conv->id;
                    @endphp
                    @if($otherUser)
                        <a href="{{ route('messages.show', $conv) }}"
                            class="block p-4 hover:bg-gray-100 dark:hover:bg-white/5 transition {{ $isActive ? 'bg-blue-50 dark:bg-white/5 border-l-4 border-ai-primary' : 'border-l-4 border-transparent' }}">
                            <div class="flex items-start gap-3">
                                <div
                                    class="h-12 w-12 rounded-full border border-gray-300 dark:border-white/10 bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center text-gray-500 font-bold">
                                    {{ substr($otherUser->name, 0, 1) }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <div class="flex justify-between items-baseline mb-0.5">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-200 truncate">
                                            {{ $otherUser->name }}</h3>
                                        @if($conv->latestMessage)
                                            <span
                                                class="text-xs text-gray-500 flex-shrink-0 ml-2 whitespace-nowrap">{{ $conv->latestMessage->created_at->format('M j') }}</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        @if($conv->latestMessage)
                                            @if($conv->latestMessage->sender_id === auth()->id())
                                                You:
                                            @endif
                                            @if($conv->latestMessage->attachment_path)
                                                [Attachment]
                                            @else
                                                {{ $conv->latestMessage->body }}
                                            @endif
                                        @else
                                            Start a conversation
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="p-8 text-center text-sm text-gray-500 pt-16">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        No messages yet
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Active View (Right Pane) -->
        <div class="w-2/3 flex flex-col bg-white dark:bg-[#1b1f23]">
            @if(isset($conversation))
                @php
                    $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                @endphp

                <!-- Chat Header -->
                <div
                    class="p-4 border-b border-gray-200 dark:border-white/10 flex items-center justify-between bg-white dark:bg-[#1b1f23]">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('users.show', $otherUser) }}">
                            <div
                                class="h-10 w-10 rounded-full border border-gray-300 dark:border-white/10 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 font-bold hover:bg-gray-300 transition">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                        </a>
                        <div>
                            <a href="{{ route('users.show', $otherUser) }}"
                                class="text-sm font-bold text-gray-900 dark:text-gray-100 hover:text-ai-primary hover:underline">{{ $otherUser->name }}</a>
                            <div class="text-xs text-gray-500">{{ $otherUser->profile->bio ?? 'AI Enthusiast' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div id="messages-container" class="flex-grow p-4 overflow-y-auto space-y-4 bg-gray-50 dark:bg-transparent"
                    data-conversation-id="{{ $conversation->id }}">
                    @foreach($messages as $msg)
                        @php
                            $isSender = $msg->sender_id === auth()->id();
                        @endphp
                        <div class="flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                            <div
                                class="max-w-[75%] rounded-2xl px-4 py-2 {{ $isSender ? 'bg-ai-primary text-white rounded-br-none' : 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-bl-none' }}">
                                @if($msg->attachment_path)
                                    @if($msg->attachment_type === 'image')
                                        <a href="{{ Storage::url($msg->attachment_path) }}" target="_blank">
                                            <img src="{{ Storage::url($msg->attachment_path) }}"
                                                class="rounded-lg max-h-64 object-cover mb-2 border border-white/20">
                                        </a>
                                    @elseif($msg->attachment_type === 'video')
                                        <video controls class="rounded-lg max-h-64 mb-2">
                                            <source src="{{ Storage::url($msg->attachment_path) }}">
                                        </video>
                                    @else
                                        <a href="{{ Storage::url($msg->attachment_path) }}" target="_blank"
                                            class="flex items-center gap-2 bg-black/10 p-2 rounded mb-2 hover:bg-black/20 transition text-sm">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            View attached file
                                        </a>
                                    @endif
                                @endif

                                @if($msg->body)
                                    <p class="text-sm whitespace-pre-wrap">{{ $msg->body }}</p>
                                @endif

                                <div class="text-[10px] text-right mt-1 opacity-70">
                                    {{ $msg->created_at->format('g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Message Form -->
                <div class="p-4 border-t border-gray-200 dark:border-white/10 bg-white dark:bg-[#1b1f23] rounded-br-xl">
                    <form action="{{ route('messages.store', $conversation) }}" method="POST" enctype="multipart/form-data"
                        class="flex items-end gap-2" id="message-form">
                        @csrf
                        <label
                            class="p-2 text-gray-400 hover:text-ai-primary transition cursor-pointer flex-shrink-0 bg-gray-100 dark:bg-white/5 rounded-full mb-1">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <input type="file" name="attachment" class="hidden" id="attachment-input"
                                onchange="previewAttachment(this)">
                        </label>

                        <div
                            class="flex-grow bg-gray-100 dark:bg-white/5 rounded-2xl border border-transparent focus-within:border-ai-primary focus-within:bg-white dark:focus-within:bg-[#1b1f23] transition pb-1">
                            <div id="attachment-preview"
                                class="hidden px-4 pt-3 pb-1 text-sm text-gray-500 font-medium flex items-center justify-between border-b border-gray-200 dark:border-white/10 mb-1">
                                <span class="truncate flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span id="preview-filename">File selected</span>
                                </span>
                                <button type="button" onclick="clearAttachment()"
                                    class="text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 p-1 rounded-full">&times;</button>
                            </div>
                            <textarea name="body" rows="1" placeholder="Write a message..."
                                class="w-full bg-transparent border-none text-gray-900 dark:text-gray-100 p-3 focus:ring-0 resize-none text-sm"
                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                onkeydown="if(event.keyCode == 13 && !event.shiftKey) { event.preventDefault(); document.getElementById('message-form').submit(); }"></textarea>
                        </div>

                        <button type="submit"
                            class="p-3 bg-ai-primary text-white rounded-full hover:bg-ai-primary/90 transition flex-shrink-0 shadow shadow-ai-primary/30 mb-1">
                            <svg class="h-5 w-5 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex-grow flex flex-col items-center justify-center p-8 bg-white dark:bg-[#1b1f23]">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-inbox-8228518-6577322.png"
                        alt="Empty Inbox" class="w-48 opacity-70 mb-4 dark:brightness-200 dark:grayscale">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Your Messages</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm">Select a conversation from the left, or
                        connect with someone new to start chatting.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Script for attachment preview and auto-scrolling -->
    <script>
        function previewAttachment(input) {
            const preview = document.getElementById('attachment-preview');
            const filename = document.getElementById('preview-filename');
            if (input.files && input.files[0]) {
                filename.textContent = input.files[0].name;
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            } else {
                clearAttachment();
            }
        }

        function clearAttachment() {
            document.getElementById('attachment-input').value = '';
            document.getElementById('attachment-preview').classList.add('hidden');
            document.getElementById('attachment-preview').classList.remove('flex');
        }

        @if(isset($conversation))
            // Auto scroll to bottom of messages
            document.addEventListener("DOMContentLoaded", function () {
                const container = document.getElementById('messages-container');
                container.scrollTop = container.scrollHeight;
            });

            // Basic Polling Script for Real-Time feel
            setInterval(() => {
                fetch('{{ route('messages.show', $conversation) }}', {
                    headers: { 'Accept': 'application/json' }
                })
                    .then(res => res.json())
                    .then(data => {
                        // Intentionally simple naive replacement, ideally uses diffing
                        const container = document.getElementById('messages-container');
                        const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;

                        let html = '';
                        const myId = {{ auth()->id() }};

                        data.messages.forEach(msg => {
                            const isSender = msg.is_sender;
                            const alignClass = isSender ? 'justify-end' : 'justify-start';
                            const bubbleClass = isSender ? 'bg-ai-primary text-white rounded-br-none' : 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-bl-none';

                            let attachmentHtml = '';
                            if (msg.attachment_path) {
                                if (msg.attachment_type === 'image') {
                                    attachmentHtml = `<a href="${msg.attachment_path}" target="_blank"><img src="${msg.attachment_path}" class="rounded-lg max-h-64 object-cover mb-2 border border-white/20"></a>`;
                                } else if (msg.attachment_type === 'video') {
                                    attachmentHtml = `<video controls class="rounded-lg max-h-64 mb-2"><source src="${msg.attachment_path}"></video>`;
                                } else {
                                    attachmentHtml = `<a href="${msg.attachment_path}" target="_blank" class="flex items-center gap-2 bg-black/10 p-2 rounded mb-2 hover:bg-black/20 transition text-sm"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>View attached file</a>`;
                                }
                            }

                            html += `
                            <div class="flex ${alignClass}">
                                <div class="max-w-[75%] rounded-2xl px-4 py-2 ${bubbleClass}">
                                    ${attachmentHtml}
                                    ${msg.body ? `<p class="text-sm whitespace-pre-wrap">${msg.body}</p>` : ''}
                                    <div class="text-[10px] text-right mt-1 opacity-70">${msg.time}</div>
                                </div>
                            </div>`;
                        });

                        if (container.innerHTML !== html) {
                            container.innerHTML = html;
                            if (isAtBottom) {
                                container.scrollTop = container.scrollHeight;
                            }
                        }
                    });
            }, 3000); // 3 seconds
        @endif
    </script>
</x-app-layout>