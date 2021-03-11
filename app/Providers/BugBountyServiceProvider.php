<?php

namespace App\Providers;

use App\Services\DifficultyCalculators\DifficultyCalculator;
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
