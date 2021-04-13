<?php

namespace Tests\Feature;

use App\Events\ReportSubmitted;
use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipGeneratorsTest extends CoreTest
{
    use RefreshDatabase;

    private function get_relevant_tips($eventClass)
    {
        return collect(config('bugbounty.tips'))->map(function ($item) {
            return new $item;
        })->filter(function ($item) use ($eventClass) {
            return collect($item->getValidEvents())->contains($eventClass);
        });
    }

    private function check_tips_updated($tips)
    {
        foreach ($tips as $tip) {
            $this->assertDatabaseHas('tips', [
                'type' => get_class($tip),
            ]);
        }
    }

    public function test_tips_are_generated_when_report_submitted()
    {
        $tips = $this->get_relevant_tips(ReportSubmitted::class);
        $this->submit_report();
        $this->check_tips_updated($tips);
    }

    public function test_tips_are_generated_when_verification_submitted()
    {
        User::factory()->count(20)->create();
        $userMetrics = $this->get_relevant_tips(VerificationSubmitted::class);
        $this->submit_report();
        $assignment = VerificationAssignment::first();
        $batch = $assignment->verificationBatch;
        $this->submit_verification($assignment, $batch);
        $this->check_tips_updated($userMetrics);
    }

    public function test_tips_are_generated_when_verification_batch_is_completed()
    {
        $userMetrics = $this->get_relevant_tips(VerificationBatchCompleted::class);
        $this->verify_report();
        $this->check_tips_updated($userMetrics);
    }
}
