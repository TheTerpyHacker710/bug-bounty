<?php


namespace App\Services\Tips;


use App\Events\VerificationBatchCompleted;

class DummyTip extends Tip
{
    protected $eventHandlers = [
        VerificationBatchCompleted::class => 'handleBatchCompleted',
    ];

    protected function handleBatchCompleted(VerificationBatchCompleted $event): array
    {
        // TODO: create tip notification with dummy message
        $user = $event->verificationBatch->report->creator_id;
        return [
            $user => "Hello, this is a tip"
        ];
    }
}