<?php

namespace App\Events;

use App\Models\VerificationSubmission;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $verificationSubmission;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VerificationSubmission $verificationSubmission)
    {
        $this->verificationSubmission = $verificationSubmission;
    }
}
