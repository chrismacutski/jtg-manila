<?php

namespace App\Http\Controllers;

use App\Conversation;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    public function show($conversationId, $sessionId)
    {
        $conversation = Conversation::where('id', $conversationId)
            ->where('session_id', $sessionId)
            ->first();

        $conversation->load('messages', 'chatter');

        if (request()->expectsJson()) {
            return $conversation;
        }

        return view('conversations.show')
            ->with('conversation', $conversation);
    }
}
