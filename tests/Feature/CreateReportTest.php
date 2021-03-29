<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateReportTest extends CoreTest
{
    use RefreshDatabase;

    public function test_report_can_be_created()
    {
        $this->submit_report();
        $this->assertDatabaseCount('reports', 1);
    }

    public function test_report_is_assigned_to_verifiers()
    {
        // create extra users in case verification assignment needs them
        User::factory()->count(20)->create();
        $this->submit_report();
        $this->assertDatabaseCount('reports', 1);
        $this->assertDatabaseCount('verification_batches', 1);
        $report = Report::first();
        $vb = VerificationBatch::first();
        $this->assertEquals($report->id, $vb->report_id);
        $this->assertEquals('pending', $vb->status);
        $this->assertDatabaseHas('verification_assignments', [
            'verification_batch_id' => $vb->id,
        ]);
        $assignmentsNotPending = VerificationAssignment::all()->pluck('status')->map(function($item) {
            return $item == 'pending';
        })->contains(false);
        $this->assertNotTrue($assignmentsNotPending);
    }
}
