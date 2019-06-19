<?php

namespace App\Http\Controllers\Chat;

use App\Chat\PayloadBuilder;
use App\Chatter;
use App\Conversation;
use App\Http\Requests\CreateChatterRequest;
use App\Jobs\ProcessConversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatterController extends Controller
{
    protected $payload_builder;

    public function __construct(PayloadBuilder $payloadBuilder)
    {
        $this->payload_builder = $payloadBuilder;
    }

    public function store(CreateChatterRequest $request, $sessionId)
    {
        $chatter = Chatter::findByFullName(request('first_name'), request('middle_name'), request('last_name'));

        if (!$chatter) {
            $chatter = Chatter::create([
                'first_name' => request('first_name'),
                'middle_name' => request('middle_name'),
                'last_name' => request('last_name'),
                'email_address' => request('email_address'),
                'phone_number' => request('phone_number'),
                'is_new_chatter' => true
            ]);
        } else {
            $chatter->first_name = request('first_name', $chatter->first_name);
            $chatter->middle_name = request('middle_name', $chatter->middle_name);
            $chatter->last_name = request('last_name', $chatter->last_name);
            $chatter->email_address = request('email_address', $chatter->email_address);
            $chatter->phone_number = request('phone_number', $chatter->phone_number);
            $chatter->is_new_chatter = false;

            $chatter->save();
        }

        $has_existing_session = Conversation::where('session_id', $sessionId)
            ->where('status', Conversation::STATUS_OPEN)
            ->where('chatter_id', $chatter->id)
            ->first();

        if (!$has_existing_session) {
            $payload = $this->payload_builder->buildForNewSession($sessionId, $chatter);
            logger($payload);
            dispatch(new ProcessConversation($payload));
        }

        return $chatter;
    }
}
