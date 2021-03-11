<?php

namespace App\Listeners;

use App\Events\VerificationBatchCompleted;
use App\Services\Metrics\Competence;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompetenceEventSubscriber implements ShouldQueue
{
    private $competence;

    public function __construct(Competence $competence) {
        $this->competence = $competence;
    }

    public function handleVerificationBatchCompleted($event) {
        // only update when report was verified
        if ($event->verificationBatch->status == 'accepted' && $event->verificationBatch->report->status == "verified") {
            $user_id = $event->verificationBatch->report->creator_id;
            $this->competence->update([$user_id]);
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            VerificationBatchCompleted::class,
            [CompetenceEventSubscriber::class, 'handleVerificationBatchCompleted']
        );
    }
}
