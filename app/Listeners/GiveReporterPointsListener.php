<?php

namespace App\Listeners;

use App\Events\VerificationBatchCompleted;
use App\Model\Report;
use App\Model\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GiveReporterPointsListener implements ShouldQue
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VerificationBatchCompleted $event)
    {
        $user_id = $event->verificationBatch->report->creator_id;
        $user_id = addPoint($points = 1000);

    }
}
