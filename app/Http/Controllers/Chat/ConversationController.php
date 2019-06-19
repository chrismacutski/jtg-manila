<?php

namespace App\Http\Controllers\Chat;

use App\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    public function show($sessionId)
    {
        $conversation = Conversation::where('session_id', $sessionId)
            ->where('status', Conversation::STATUS_OPEN)
            ->first();

        if (!$conversation) {
            abort(500);
        }

        $conversation->load('messages', 'chatter');

        return $conversation;
    }
}
