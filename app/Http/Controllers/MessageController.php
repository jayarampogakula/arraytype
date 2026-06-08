<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with([
                'users' => function ($q) {
                    $q->where('users.id', '!=', auth()->id());
                },
                'latestMessage'
            ])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->latestMessage ? $conv->latestMessage->created_at : $conv->created_at;
            });

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Authorize user is in conversation
        if (!$conversation->users->contains(auth()->id())) {
            abort(403);
        }

        $conversations = auth()->user()->conversations()
            ->with([
                'users' => function ($q) {
                    $q->where('users.id', '!=', auth()->id());
                },
                'latestMessage'
            ])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->latestMessage ? $conv->latestMessage->created_at : $conv->created_at;
            });

        $messages = $conversation->messages()->with('sender')->get();

        // If it's an AJAX request (polling), return JSON
        if (request()->wantsJson()) {
            return response()->json([
                'messages' => $messages->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'body' => $msg->body,
                        'is_sender' => $msg->sender_id === auth()->id(),
                        'sender_name' => $msg->sender->name,
                        'time' => $msg->created_at->format('g:i A'),
                        'attachment_path' => $msg->attachment_path ? Storage::url($msg->attachment_path) : null,
                        'attachment_type' => $msg->attachment_type,
                    ];
                })
            ]);
        }

        return view('messages.index', compact('conversations', 'conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        if (!$conversation->users->contains(auth()->id()))
            abort(403);

        $request->validate([
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240' // 10MB limit
        ]);

        if (!$request->body && !$request->hasFile('attachment')) {
            return back();
        }

        $data = [
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
            $data['attachment_path'] = $path;

            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/'))
                $data['attachment_type'] = 'image';
            elseif (str_starts_with($mime, 'video/'))
                $data['attachment_type'] = 'video';
            else
                $data['attachment_type'] = 'file';
        }

        $conversation->messages()->create($data);

        return back();
    }

    public function start(User $user)
    {
        if (auth()->id() === $user->id)
            return back();

        // Find existing conversation between these two
        $conversation = auth()->user()->conversations()->whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([auth()->id(), $user->id]);
        }

        return redirect()->route('messages.show', $conversation);
    }
}
