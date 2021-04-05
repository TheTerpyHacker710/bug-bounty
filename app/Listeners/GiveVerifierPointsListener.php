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
     * @param  object  $event
     * @return void
     */
    public function handle(VerficationBatchComplete $event)
    {
        foreach ($event->VerificationBatch->VerficationAssignment->assignee_id as $user_id)
        {
            $user_id->addPoint($point = 100);
        }
    }
}