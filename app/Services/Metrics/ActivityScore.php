<?php


namespace App\Services\Metrics;


use App\Events\ReportSubmitted;
use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Models\Report;
use App\Models\VerificationSubmission;

class ActivityScore extends UserMetric
{
    protected $getUserMethods = [
        ReportSubmitted::class => 'getReportSubmittedUsers',
        VerificationSubmitted::class => 'getVerificationSubmittedUsers',
    ];

    protected function compute($users)
    {
        $result = array();
        $windowStart = now()->subDays(30);
        foreach ($users as $user) {
            $numReports = Report::where('creator_id', $user)->whereDate('created_at', '>=', $windowStart)->count();
            $numVerificationSubmissions = VerificationSubmission::whereHas('verificationAssignment', function ($query) use ($user) {
               $query->where('assignee_id', $user);
            })->whereDate('created_at', '>=', $windowStart)->count();
            $activityScore = $numReports / 2 + $numVerificationSubmissions / 4;
            $result[$user] = $activityScore;
        }
        return $result;
    }

    protected function getReportSubmittedUsers(ReportSubmitted $event): array {
        return [$event->report->creator_id];
    }

    protected function getVerificationSubmittedUsers(VerificationSubmitted $event): array {
        return [$event->verificationSubmission->verificationAssignment->assignee_id];
    }
}