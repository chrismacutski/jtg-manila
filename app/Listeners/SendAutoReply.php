<?php

namespace App\Listeners;

use App\Events\NewConversationFound;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAutoReply
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewConversationFound  $event
     * @return void
     */
    public function handle(NewConversationFound $event)
    {
        //
    }
}
