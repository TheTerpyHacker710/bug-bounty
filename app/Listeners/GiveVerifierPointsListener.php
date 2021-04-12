<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VerificationBatchCompleted;
use App\Model\User;

class GiveVerifierPointsListener
{


    /**
     * Handle the event.
     *
     * @param  VerficationBatchCompleted  $event
     * @return void
     */
    public function handle(VerficationBatchCompleted $event)
    {
        $event->verificationBatch->verificationAssignments->each(fn($a) => $a->assignee->addPoint($points = 100));
    }
}
