<?php


namespace App\Services\Metrics;


use App\Models\Report;
use App\Models\VerificationBatch;

class Competence extends UserMetric
{

    protected function compute($users)
    {
        $result = [];
        foreach ($users as $user) {
            // average voted complexity of verified reports
            $result[$user] = VerificationBatch::where('status', 'accepted')->whereHas('report', function ($query) use($user) {
                $query->where('creator_id', $user)->where('status', 'verified');
            })->get()->pluck('voted_complexity')->average();
        }
        return $result;
    }
}