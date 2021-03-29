<?php

namespace Tests\Feature;

use App\Events\ReportSubmitted;
use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\UserMetricCacheEntry;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;
use App\Services\UserMetrics\UserMetric;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserMetricsTest extends CoreTest
{
    use RefreshDatabase;

    private function get_relevant_metrics($eventClass)
    {
        return collect(config('bugbounty.userMetrics'))->map(function ($item) {
            return new $item;
        })->filter(function ($item) use ($eventClass) {
            return collect($item->getUpdateEvents())->contains($eventClass);
        });
    }

    private function check_metrics_updated($metrics)
    {
        foreach ($metrics as $metric) {
            $this->assertDatabaseHas('user_metric_cache', [
                'metric' => get_class($metric),
            ]);
        }
    }

    public function test_metrics_are_updated_when_report_submitted()
    {
        $userMetrics = $this->get_relevant_metrics(ReportSubmitted::class);
        $this->submit_report();
        $this->check_metrics_updated($userMetrics);
    }

    public function test_metrics_are_updated_when_verification_submitted()
    {
        User::factory()->count(20)->create();
        $userMetrics = $this->get_relevant_metrics(VerificationSubmitted::class);
        $this->submit_report();
        $assignment = VerificationAssignment::first();
        $batch = $assignment->verificationBatch;
        $this->submit_verification($assignment, $batch);
        $this->check_metrics_updated($userMetrics);
    }

    public function test_metrics_are_updated_when_verification_batch_is_completed()
    {
        $userMetrics = $this->get_relevant_metrics(VerificationBatchCompleted::class);
        $this->verify_report();
        $this->check_metrics_updated($userMetrics);
    }
}
