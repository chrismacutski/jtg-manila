<?php

namespace App\Http\Controllers\Admin;

use App\Conversation;
use App\Jobs\ProcessConversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with('admin', 'chatter', 'messages')
            ->withStatus(Conversation::STATUS_OPEN)
            ->orderBy('received_at')
            ->get();

        if (request()->expectsJson()) {
            return $conversations;
        }

        return view('admin.chat.index')
            ->with('conversations', $conversations);
    }
}
