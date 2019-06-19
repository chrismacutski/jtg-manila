<?php

namespace App\Jobs;

use App\Distributor;
use App\Events\CheckQueuedConversations;
use App\Events\NewConversationFound;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessConversation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $distributor;
    public $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Distributor $distributor)
    {
        $payload = $this->payload;

        $this->distributor = $distributor;

        $conversation = $this->distributor->process($payload);

        if ($conversation) {
            if ($conversation->messages()->count() == 0) {
                event(new NewConversationFound($conversation));
            }
        }
    }
}
