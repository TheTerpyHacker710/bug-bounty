<?php


namespace App\Services\VerificationAssigners;


use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;

abstract class VerificationAssigner
{
    abstract protected function selectVerifiers($query);

    public function assignVerifiers(Report $report)
    {
        // create verification batch for this report
        $verificationBatch = VerificationBatch::create([
            'report_id' => $report->id,
        ]);

        // find all eligible users (who have never been assigned to this report
        $eligibleUsersQuery = $this->getEligibleUsersQuery($verificationBatch);

        // select verifiers
        $assignees = $this->selectVerifiers($eligibleUsersQuery);

        // create verification assignment for each user
        foreach ($assignees as $assignee) {
            VerificationAssignment::create([
                'verification_batch_id' => $verificationBatch->id,
                'assignee_id' => $assignee->id,
            ]);
        }
    }

    public function addVerifier(VerificationBatch $verificationBatch)
    {
        $eligibleUsersQuery = $this->getEligibleUsersQuery($verificationBatch);
        $assignees = $this->selectVerifiers($eligibleUsersQuery);
        if (count($assignees) > 0) {
            $assignee = $assignees[0];
            VerificationAssignment::create([
                'verification_batch_id' => $verificationBatch->id,
                'assignee_id' => $assignee->id,
            ]);
        }
    }

    private function getEligibleUsersQuery($verificationBatch)
    {
        return User::whereDoesntHave('verificationAssignments.verificationBatch.report', function ($query) use ($verificationBatch) {
            $query->where('id', $verificationBatch->report_id);
            // and did not create this report)
        })->whereDoesntHave('reports', function ($query) use ($verificationBatch) {
            $query->where('id', $verificationBatch->report_id);
        });
    }
}