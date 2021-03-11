<?php

namespace App\Listeners;

use App\Events\VerificationBatchCompleted;
use App\Services\Metrics\HitRate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HitRateEventSubscriber implements ShouldQueue
{
    private $hitRate;

    public function __construct(HitRate $hitRate) {
        $this->hitRate = $hitRate;
    }

    public function handleVerificationBatchCompleted($event) {
        $user_id = $event->verificationBatch->report->creator_id;
        $this->hitRate->update([$user_id]);
    }

    public function subscribe($events)
    {
        $events->listen(
            VerificationBatchCompleted::class,
            [HitRateEventSubscriber::class, 'handleVerificationBatchCompleted']
        );
    }
}
