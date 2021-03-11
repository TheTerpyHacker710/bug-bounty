<?php


namespace App\Services\VerificationEvaluators;


use App\Jobs\AssignVerifiers;

abstract class VerificationEvaluator
{
    public function process($verificationBatch)
    {
        // calculate voted average for each relevant field
        $this->synthesizeVotes($verificationBatch);
        // get completion time
        $completionTime = now();
        // evaluate the verification submissions
        $accepted = $this->evaluateVerifications($verificationBatch);
        $verificationResult = $accepted ? "accepted" : "reassigned";
        // update verification batch status
        $verificationBatch->update([
            "status" => $verificationResult,
            "completed_at" => $completionTime,
        ]);
        // check if verifications were accepted
        if ($accepted) {
            // determine whether report was successfully verified
            $verified = $this->evaluateReport($verificationBatch);
            $reportResult = $verified ? "verified" : "rejected";
            // update report status
            $report = $verificationBatch->report;
            $report->status = $reportResult;
            $report->completed_at = $completionTime;
            $report->save();
        } else {
            // create another verification batch
            AssignVerifiers::dispatch($verificationBatch->report);
        }
    }

    // determine whether verifications are accepted or whether the batch
    // should be reassigned
    abstract protected function evaluateVerifications($verificationBatch);

    // assuming the verification submissions are trusted,
    // return whether a report is verified or rejected
    abstract protected function evaluateReport($verificationBatch);

    private function synthesizeVotes($verificationBatch) {
        // get verification submissions
        $submissions = $verificationBatch->verificationSubmissions;
        // set average values
        $verificationBatch->voted_quality = $submissions->avg->quality;
        $verificationBatch->voted_detail = $submissions->avg->detail;
        $verificationBatch->voted_severity = $submissions->avg->severity;
        $verificationBatch->voted_complexity = $submissions->avg->complexity;
        $verificationBatch->voted_reliability = $submissions->avg->reliability;
        $verificationBatch->save();
    }
}