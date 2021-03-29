<?php


namespace App\Services\TipGenerators;


use App\Events\VerificationBatchCompleted;
use App\Models\Tip;

class DummyTipGenerator extends TipGenerator
{
    protected $eventHandlers = [
        VerificationBatchCompleted::class => 'handleBatchCompleted',
    ];

    protected function handleBatchCompleted(VerificationBatchCompleted $event): array
    {
        // create dummy tip
        $user = $event->verificationBatch->report->creator_id;
        $tip = new Tip;
        $tip->user_id = $user;
        $tip->type = get_class($this);
        $tip->location_tag = 'report';
        $tip->content = 'Hello, this is a tip!';
        $tip->save();
        // return tips to base class
        return array($tip);
    }
}