<?php

namespace App\Providers;

use App\Listeners\ActivityScoreEventSubscriber;
use App\Listeners\CompetenceEventSubscriber;
use App\Listeners\HitRateEventSubscriber;
use App\Listeners\MetricsEventSubscriber;
use App\Listeners\TipsEventSubscriber;
use App\Listeners\GiveReporterPointsListener;
use App\Listeners\GiveVerifierPointsListener;
use App\Events\VerificationBatchCompleted;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VerificationBatchCompleted::class => [
            GiveReporterPointsListener::class,
            //GiveVerifierPointsListener::class,
        ],
    ];

    protected $subscribe = [
//        HitRateEventSubscriber::class,
//        ActivityScoreEventSubscriber::class,
//        CompetenceEventSubscriber::class,
        MetricsEventSubscriber::class,
        TipsEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
