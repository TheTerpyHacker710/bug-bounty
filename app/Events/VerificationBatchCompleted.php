<?php

namespace App\Events;

use App\Models\VerificationBatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationBatchCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $verificationBatch;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VerificationBatch $verificationBatch)
    {
        $this->verificationBatch = $verificationBatch;
    }
}
