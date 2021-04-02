<?php


namespace Tests\Feature;


use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;
use Tests\TestCase;

abstract class CoreTest extends TestCase
{
    protected function create_programs()
    {
        Program::factory()->count(5)->create();
        $this->assertDatabaseCount('programs', 5);
    }

    protected function submit_report()
    {
        $this->create_programs();

        $user = User::factory()->create();

        $program = Program::first()->id;

        $metrics = array();
        $metricsClasses = config('bugbounty.vulnerabilityMetrics');
        foreach ($metricsClasses as $c) {
            $m = new $c;
            $metrics[$m->name] = $m->max;
        }

        $response = $this->actingAs($user)->post('/report', [
            'program_id' => $program,
            'procedure' => ['asdf', 'alsdfjdkjasf;ldfjas'],
            'metrics' => $metrics,
            'title' => 'A report',
        ]);

        $response->assertSessionHasNoErrors();
    }

    protected function submit_verification($assignment, $batch)
    {
        $assignee = $assignment->assignee;
        $this->assertNotNull($assignee);

        $this->assertEquals($assignment->verification_batch_id, $batch->id);

        $vulnerabilityMetrics = array();
        $metricsClasses = config('bugbounty.vulnerabilityMetrics');
        foreach ($metricsClasses as $c) {
            $m = new $c;
            $vulnerabilityMetrics[$m->name] = $m->max;
        }
        $procedureMetrics = array();
        $metricsClasses = config('bugbounty.procedureMetrics');
        foreach ($metricsClasses as $c) {
            $m = new $c;
            $procedureMetrics[$m->name] = $m->max;
        }
        $response = $this->actingAs($assignee)->post('/verify', [
            'assignmentId' => $assignment->id,
            'verifiable' => true,
            'vulnerabilityMetrics' => $vulnerabilityMetrics,
            'procedureMetrics' => $procedureMetrics,
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('verification_submissions', [
            'verification_assignment_id' => $assignment->id,
        ]);
    }

    protected function verify_report()
    {
        // create extra users in case verification assignment needs them
        User::factory()->count(20)->create();
        $this->submit_report();
        $assignments = VerificationAssignment::all();
        $this->assertTrue($assignments->count() > 0);
        $vb = VerificationBatch::first();

        foreach ($assignments as $assignment) {
            $this->submit_verification($assignment, $vb);
        }

        $vb->refresh();
        $this->assertNotEquals('pending', $vb->status);

        $report = Report::first();
        $this->assertEquals($vb->report_id, $report->id);
        $this->assertNotEquals('pending', $report->status);
    }
}