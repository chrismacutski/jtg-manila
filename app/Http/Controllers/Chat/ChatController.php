<?php

namespace App\Http\Controllers\Chat;

use App\Chat\PayloadBuilder;
use App\Conversation;
use App\Jobs\ProcessConversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    protected $payload_builder;

    public function __construct(PayloadBuilder $payloadBuilder)
    {
        $this->payload_builder = $payloadBuilder;
    }

    public function index()
    {
        $session_id = session()->getId();

        $conversation = Conversation::where('session_id', $session_id)
            ->where('status', Conversation::STATUS_OPEN)
            ->first();

        $with_conversation = false;
        if ($conversation) {
            $with_conversation = true;
        }

        return [
            'session_id' => $session_id,
            'with_conversation' => $with_conversation
        ];
    }

    public function store($sessionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);

        $chatter_id = request('chatter_id', null);

        $query = Conversation::where('session_id', $sessionId);

        if ($chatter_id) {
            $query->where('chatter_id', $chatter_id);
        } else {
            $query->orderBy('id', 'DESC');
        }

        $conversation = $query->first();

        if (!$conversation) {
            return [
                'success' => false,
                'data' => request()->all()
            ];
        }

        $is_websocket_connected = request('is_connected', true);

        if (!$is_websocket_connected) {
            logger("Sending Failed, websocket connection is not established");
            return [
                'success' => false,
                'data' => request()->all()
            ];
        }

        $payload = $this->payload_builder->buildForConversation(request()->all(), $conversation);
        dispatch(new ProcessConversation($payload));

        return [
            'success' => true,
        ];
    }

}
