<?php


namespace App\Services\Metrics;


use App\Models\Report;
use App\Models\VerificationSubmission;

class ActivityScore extends UserMetric
{

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
}