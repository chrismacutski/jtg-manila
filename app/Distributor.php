<?php

namespace App;

use App\Conversation\Message;
use App\Events\CheckQueuedConversations;
use App\Events\ReplySent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Distributor
{
    public function process($payload)
    {
        $conversation = $this->findOrCreateConversation($payload);

        $message = $conversation->addMessage($payload);

        if ($message) {
            event(new ReplySent($conversation, $message));
        }

        return $conversation;
    }

    public function findOrCreateConversation($payload)
    {
        logger()->info('Searching for existing open conversation with session_id of ' . $payload['session_id']);

        $conversation = Conversation::withSessionId($payload['session_id'])
            ->where('status', '!=', Conversation::STATUS_CLOSED)
            ->first();

        if (!$conversation) {
            logger()->info('There are no existing open conversation, Creating new conversation with session_id of ' . $payload['session_id']);

            $conversation = Conversation::create([
                'session_id' => $payload['session_id'],
                'status' => Conversation::STATUS_OPEN,
                'received_at' => $payload['sent_at'],
                'chatter_id' => $payload['chatter_id']
            ]);
        } else {
            logger()->info('Found an existing open conversation with session_id of ' . $payload['session_id']);
        }

        return $conversation;
    }
}
