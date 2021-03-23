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
        // calculate average votes
        $procedureMetrics = $this->synthesizeMetrics('procedure_metrics', $submissions);
        $vulnerabilityMetrics = $this->synthesizeMetrics('vulnerability_metrics', $submissions);
        // save average votes
        $verificationBatch->voted_procedure_metrics = $procedureMetrics;
        $verificationBatch->voted_vulnerability_metrics = $vulnerabilityMetrics;
        $verificationBatch->save();
    }

    private function synthesizeMetrics($colName, $submissions) {
        $len = count($submissions);
        return $submissions
            // get all procedure metric arrays in one array
            ->pluck($colName)
            ->reduce(function($carry, $item) {
                $result = $carry;
                foreach ($item as $metric => $value) {
                    if (isset($result[$metric])) {
                        $result[$metric] += $value;
                    } else {
                        $result[$metric] = $value;
                    }
                }
                return $result;
            }, collect(array()))
            ->map(function($item) use ($len) {
                return $item / $len;
            });
    }
}