<?php


namespace App\Services\UserMetrics;


use App\Events\VerificationBatchCompleted;
use App\Models\Report;

class HitRate extends UserMetric
{
    protected $getUserMethods = [
        VerificationBatchCompleted::class => 'getVerificationBatchCompletedUsers',
    ];

    protected function compute($users)
    {
        $result = array();
        foreach ($users as $user) {
            $hitRate = Report::where('creator_id', $user)->where('status', '!=', 'pending')->get(['status'])
                ->map(function ($report) {
                    return $report->status == "verified" ? 1 : 0;
                })->avg();
            $result[$user] = $hitRate;
        }
        return $result;
    }

    protected function getVerificationBatchCompletedUsers(VerificationBatchCompleted $event): array {
        return [$event->verificationBatch->report->creator_id];
    }
}