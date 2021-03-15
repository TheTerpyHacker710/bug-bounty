<?php

namespace App\Providers;

use App\Listeners\TipEventSubscriber;
use App\Services\DifficultyCalculators\DifficultyCalculator;
use App\Services\Tips\DummyTip;
use App\Services\Tips\Tip;
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
        $this->app->when(TipEventSubscriber::class)->needs(Tip::class)->give([
            DummyTip::class,
        ]);
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
