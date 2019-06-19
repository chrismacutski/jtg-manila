<?php

namespace App\Listeners;

use App\Events\ConversationAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateQueuePosition
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
     * @param  ConversationAssigned  $event
     * @return void
     */
    public function handle(ConversationAssigned $event)
    {
        //
    }
}
