<?php

namespace App\Listeners;

use App\Services\TipGenerators\TipGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TipsEventSubscriber implements ShouldQueue
{
    private $tips;

    public function __construct(TipGenerator... $tips)
    {
        $this->tips = $tips;
    }

    public function handle($event)
    {
        foreach ($this->tips as $tip) {
            $tip->process($event);
        }
    }

    public function subscribe($events)
    {
        foreach ($this->getEvents() as $event) {
            $events->listen($event, [get_class(), 'handle']);
        }
    }

    private function getEvents(): array
    {
        $events = array();
        foreach ($this->tips as $tip) {
            $events += $tip->getValidEvents();
        }
        return array_unique($events);
    }
}
