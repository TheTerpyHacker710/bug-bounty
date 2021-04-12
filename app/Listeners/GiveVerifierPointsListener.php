<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VerificationBatchCompleted;
use App\Models\User;

class GiveVerifierPointsListener
{

    /**
     * Handle the event.
     *
     * @param  VerificationBatchCompleted  $event
     * @return void
     */
    public function handle(VerificationBatchCompleted $event)
    {
        $event->verificationBatch->verificationAssignments->each(fn($a) => $a->assignee->addPoint($points = 1000));
    }
   
}