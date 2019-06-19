<?php

namespace App\Chat;

use App\Chatter;
use App\Conversation;
use App\Conversation\Message;
use Carbon\Carbon;

class PayloadBuilder
{
    public function buildForNewSession($sessionId, Chatter $chatter)
    {
        return [
            'session_id' => $sessionId,
            'type' => NULL,
            'content' => NULL,
            'from_admin' => false,
            'sent_at' => Carbon::now(),
            'is_system_message' => false,
            'chatter_id' => $chatter->id,
            'fingerprint' => NULL,
            'is_new_session' => true,
            'idx' => NULL
        ];
    }

    public function buildForConversation(array $request, Conversation $conversation)
    {
        $from_admin = true;
        if ($request['from'] == Message::SENDER_CHATTER) {
            $from_admin = false;
        }

        $type = 'text';
        if (isset($request['type']) && $request['type'] != '') {
            $type = $request['type'];
        }

        $content = NULL;
        if (isset($request['content']) && $request['content'] != '') {
            $content = $request['content'];
        }

        return [
            'session_id' => $conversation->session_id,
            'type' => $type,
            'content' => $content,
            'from_admin' => $from_admin,
            'sent_at' => Carbon::now(),
            'is_system_message' => $request['is_system_message'],
            'chatter_id' => $conversation->chatter_id,
            'fingerprint' => NULL,
            'is_new_session' => false,
            'idx' => $request['idx'],
        ];
    }
}
