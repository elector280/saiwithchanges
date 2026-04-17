<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
    {
        return view('admin.chat.index');
    }

    /**
     * LEFT LIST: newest first (new message -> top)
     * Show only threads that have at least 1 message
     */
    public function threads()
    {
        $threads = ChatThread::with('latestMessage')
            ->whereHas('latestMessage')                 // ✅ only threads with messages
            ->orderByDesc('last_message_at')            // ✅ uses updated timestamp from send/fetch
            ->limit(200)
            ->get()
            ->map(function ($t) {

                $latest = $t->latestMessage;

                return [
                    'id'              => $t->id,
                    'status'          => $t->status ?? 'open',
                    // ✅ notify detect fields
                    'last_message_id' => $latest?->id ?? 0,
                    'last_sender'     => $latest?->sender ?? null, // guest/admin
                    'last_time'       => $latest ? $latest->created_at->format('H:i, d M') : '',
                    'preview'         => $latest?->message
                        ? mb_strimwidth($latest->message, 0, 60, '...')
                        : '',
                ];
            })
            ->values();

        return response()->json([
            'ok'      => true,
            'threads' => $threads,
        ]);
    }

    /**
     * Fetch messages for a thread after_id
     */
    public function fetch(Request $request, ChatThread $thread)
    {
        ChatMessage::where('thread_id', $thread->id)
            ->where('sender','guest')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $afterId = (int) $request->query('after_id', 0);

        $msgs = ChatMessage::where('thread_id', $thread->id)
          ->where('id', '>', $afterId)
          ->orderBy('id', 'asc')
          ->limit(50)
          ->get();

        return response()->json([
          'ok' => true,
          'thread_id' => $thread->id,
          'messages' => $msgs->map(fn($m) => [
            'id' => $m->id,
            'sender' => $m->sender,
            'message' => $m->message,
            'time' => $m->created_at->format('H:i, d M Y'),
            'read_at' => $m->read_at 
                          ? Carbon::parse($m->read_at)->format('H:i, d M Y') 
                          : null,
          ])->values(),
          'last_id' => $msgs->last()?->id ?? $afterId,
        ]);
    }


    /**
     * Admin send message to thread
     */
    public function send(Request $request, ChatThread $thread)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // ✅ if closed thread, auto open (optional)
        if ($thread->status === 'closed') {
            $thread->status = 'open';
            $thread->save();
        }

        $msg = ChatMessage::create([
            'thread_id' => $thread->id,
            'sender'    => 'admin',
            'message'   => $request->message,
        ]);

        // ✅ IMPORTANT: update last_message_at for ordering + notify logic
        $thread->update([
            'last_message_at' => now(),
            'last_sender'     => 'admin',
            'last_message_id' => auth()->check() ? auth()->id() : null, // guest => null
        ]);

        

        return response()->json([
            'ok'        => true,
            'thread_id' => $thread->id,
            'message'   => [
                'id'      => $msg->id,
                'sender'  => $msg->sender,
                'message' => $msg->message,
                'time'    => Carbon::parse($msg->created_at)->format('H:i, d M Y'),
            ],
        ]);
    }

    public function readThread(ChatThread $thread)
    {
        ChatMessage::where('thread_id', $thread->id)
            ->where('sender','guest')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok'=>true]);
    }
}
