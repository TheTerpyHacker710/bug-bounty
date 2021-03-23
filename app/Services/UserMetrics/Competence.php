<?php


namespace App\Services\UserMetrics;


use App\Events\VerificationBatchCompleted;
use App\Models\Report;
use App\Models\VerificationBatch;

class Competence extends UserMetric
{
    protected $getUserMethods = [
        VerificationBatchCompleted::class => 'getVerificationBatchCompletedUsers',
    ];

    protected function compute($users)
    {
        $result = [];
        foreach ($users as $user) {
            // average voted complexity of verified reports
            $r = VerificationBatch::where('status', 'accepted')->whereHas('report', function ($query) use($user) {
                $query->where('creator_id', $user)->where('status', 'verified');
            })->get()->pluck('voted_vulnerability_metrics.Complexity')->average();
            if ($r == null) {
                $r = 0;
            }
            $result[$user] = $r;
        }
        return $result;
    }

    protected function getVerificationBatchCompletedUsers(VerificationBatchCompleted $event): array {
        return [$event->verificationBatch->report->creator_id];
    }
}