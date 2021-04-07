<?php

namespace App\Listeners;

use App\Events\VerificationBatchCompleted;
use App\Model\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GiveReporterPointsListener 
{

    /**
     * Handle the event.
     *
     * @param  VerificationBatchCompleted  $event
     * @return void
     */
    public function handle(VerificationBatchCompleted $event)
    {
        
        $user_id = $event->VerificationBatch->report->creator_id;
        $user_id->addPoint($points = 1000);

    }
}
