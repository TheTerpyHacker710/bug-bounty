<?php

namespace App\Listeners;

use App\Events\VerificationBatchCompleted;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GiveReporterPointsListener 
{
    private $user_id;
    private $user;
    /**
     * Handle the event.
     *
     * @param  VerificationBatchCompleted  $event
     * @return void
     */
    public function handle(VerificationBatchCompleted $event)
    {  
        $user_id = $event->verificationBatch->report->creator_id;
        $user = User::find($user_id);
        $user->addPoint($points = 1000);
    }
}
