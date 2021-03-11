<?php


namespace App\Services\VerificationAssigners;


use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;

abstract class VerificationAssigner
{
    abstract protected function selectVerifiers($query);

    public function assignVerifiers(Report $report) {
        // create verification batch for this report
        $verificationBatch = VerificationBatch::create([
            'report_id' => $report->id,
        ]);

        // find all eligible users (who have never been assigned to this report
        $eligibleUsersQuery = User::whereDoesntHave('verificationAssignments.verificationBatch.report', function ($query) use ($verificationBatch) {
            $query->where('id', $verificationBatch->report_id);
        // and did not create this report)
        })->whereDoesntHave('reports', function($query) use ($verificationBatch) {
            $query->where('id', $verificationBatch->report_id);
        });

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
}