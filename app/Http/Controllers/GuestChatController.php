<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestChatController extends Controller
{
    /**
     * Guest/browser session identifier (stable)
     */
    private function sessionId(Request $request): string
    {
        // Ensure session started
        $request->session()->start();

        if (!$request->session()->has('chat_session_id')) {
            $request->session()->put('chat_session_id', (string) Str::uuid());
        }

        return (string) $request->session()->get('chat_session_id');
    }

    /**
     * Only FIND (no create)
     */
    private function findThread(Request $request): ?ChatThread
    {
        $sid = $this->sessionId($request);
        return ChatThread::where('session_id', $sid)->first();
    }

    /**
     * Create ONLY when first message is sent
     */
    private function createThread(Request $request): ChatThread
    {
        $sid = $this->sessionId($request);

        return ChatThread::create([
            'session_id'      => $sid,
            'last_sender'     => 'guest',
            'user_id'         => auth()->check() ? auth()->id() : null, // guest => null
            'status'          => 'open',
            'last_message_at' => now(),
        ]);
    }

    /**
     * Helper: first send => create thread, otherwise return existing
     */
    private function threadForSend(Request $request): ChatThread
    {
        return $this->findThread($request) ?? $this->createThread($request);
    }

    /**
     * Guest send message (creates thread if none)
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $thread = $this->threadForSend($request);

        $msg = ChatMessage::create([
            'thread_id' => $thread->id,
            'sender'    => 'guest',
            'message'   => $request->message,
        ]);

        // ✅ Update thread last message timestamp (admin list reorder, notify logic)
        $thread->update([
            'last_message_at' => now(),
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

    /**
     * Guest fetch new messages (after_id)
     */
    public function fetch(Request $request)
    {
        $thread = $this->findThread($request);

        // ✅ no thread yet => empty response
        if (!$thread) {
            $afterId = (int) $request->query('after_id', 0);

            return response()->json([
                'ok'        => true,
                'thread_id' => null,
                'messages'  => [],
                'last_id'   => $afterId,
            ]);
        }

        $afterId = (int) $request->query('after_id', 0);

        $msgs = ChatMessage::where('thread_id', $thread->id)
            ->where('id', '>', $afterId)
            ->orderBy('id', 'asc')
            ->limit(50)
            ->get();

        return response()->json([
            'ok'        => true,
            'thread_id' => $thread->id,
            'messages'  => $msgs->map(fn($m) => [
                'id'      => $m->id,
                'sender'  => $m->sender,
                'message' => $m->message,
                'time'    => Carbon::parse($m->created_at)->format('H:i, d M Y'),
            ])->values(),
            'last_id'   => $msgs->last()?->id ?? $afterId,
        ]);
    }
}
