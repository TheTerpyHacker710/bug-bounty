<?php

namespace App\Listeners;

use App\Events\ReportSubmitted;
use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Services\Metrics\ActivityScore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivityScoreEventSubscriber implements ShouldQueue
{
    private $activityScore;

    public function __construct(ActivityScore $activityScore) {
        $this->activityScore = $activityScore;
    }

    public function handleReportSubmitted($event) {
        $user_id = $event->report->creator_id;
        $this->activityScore->update([$user_id]);
    }

    public function handleVerificationSubmitted($event) {
        $user_id = $event->verificationSubmission->verificationAssignment->assignee_id;
        $this->activityScore->update([$user_id]);
    }

    public function subscribe($events)
    {
        $events->listen(
            ReportSubmitted::class,
            [ActivityScoreEventSubscriber::class, 'handleReportSubmitted']
        );
        $events->listen(
            VerificationSubmitted::class,
            [ActivityScoreEventSubscriber::class, 'handleVerificationSubmitted']
        );
    }
}
