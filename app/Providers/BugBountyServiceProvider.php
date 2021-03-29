<?php

namespace App\Providers;

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\VerificationsController;
use App\Listeners\MetricsEventSubscriber;
use App\Listeners\TipsEventSubscriber;
use App\Services\DifficultyCalculators\DifficultyCalculator;
use App\Services\ReportMetrics\ProcedureMetric;
use App\Services\ReportMetrics\ReportMetric;
use App\Services\ReportMetrics\VulnerabilityMetric;
use App\Services\UserMetrics\ActivityScore;
use App\Services\UserMetrics\Competence;
use App\Services\UserMetrics\HitRate;
use App\Services\UserMetrics\UserMetric;
use App\Services\TipGenerators\DummyTipGenerator;
use App\Services\TipGenerators\TipGenerator;
use App\Services\VerificationAssigners\VerificationAssigner;
use App\Services\VerificationEvaluators\VerificationEvaluator;
use Illuminate\Support\ServiceProvider;

class BugBountyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register verification assigner service
        $verificationAssignerClass = config('bugbounty.verificationAssigner');
        $this->app->bind(VerificationAssigner::class, $verificationAssignerClass);
        // register verification evaluator service
        $verificationEvaluatorClass = config('bugbounty.verificationEvaluator');
        $this->app->bind(VerificationEvaluator::class, $verificationEvaluatorClass);
        // register difficulty calculator service
        $difficultyCalculatorClass = config('bugbounty.difficultyCalculator');
        $this->app->bind(DifficultyCalculator::class, $difficultyCalculatorClass);
        // register tips
        $this->app->when(TipsEventSubscriber::class)->needs(TipGenerator::class)->give(config('bugbounty.tips'));
        $this->app->when(MetricsEventSubscriber::class)->needs(UserMetric::class)->give(config('bugbounty.userMetrics'));
        // register report metrics
        $this->app->when(ReportsController::class)->needs(VulnerabilityMetric::class)->give(config('bugbounty.vulnerabilityMetrics'));
        $this->app->when(VerificationsController::class)
            ->needs(ReportMetric::class)
            ->give(
                array_merge(
                    config('bugbounty.vulnerabilityMetrics'),
                    config('bugbounty.procedureMetrics')));
        //$this->app->when(VerificationsController::class)->needs(ProcedureMetric::class)->give(config('bugbounty.procedureMetrics'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
