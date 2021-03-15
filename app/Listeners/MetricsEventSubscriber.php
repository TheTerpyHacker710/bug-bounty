<?php


namespace App\Listeners;


use App\Services\Metrics\UserMetric;

class MetricsEventSubscriber
{
    private $metrics;

    private $metricEvents;

    private $metricEventsMap;

    public function __construct(UserMetric... $metrics)
    {
        foreach ($metrics as $metric) {
            $this->metrics[get_class($metric)] = $metric;
        }
        $this->setMetricEvents();
    }

    public function handle($event) {
        $eventClass = get_class($event);
        $metrics = $this->metricEventsMap[$eventClass];
        foreach ($metrics as $metricClass) {
            $metric = $this->metrics[$metricClass];
            $metric->updateEvent($event);
        }
    }

    public function subscribe($events)
    {
        foreach ($this->metricEvents as $event) {
            $events->listen($event, [get_class(), 'handle']);
        }
    }

    private function setMetricEvents() {
        $metricEventsMap = array();
        foreach (array_values($this->metrics) as $metric) {
            $metricClass = get_class($metric);
            $updateEvents = $metric->getUpdateEvents();
            foreach ($updateEvents as $event) {
                if (!isset($metricEventsMap[$event])) {
                    $metricEventsMap[$event] = [$metricClass];
                } else {
                    $flipped = array_flip($metricEventsMap[$event]);
                    if (!isset($flipped[$metricClass])) {
                        array_push($metricEventsMap[$event], $metricClass);
                    }
                }
            }
        }
        $this->metricEventsMap = $metricEventsMap;
        $this->metricEvents = array_keys($metricEventsMap);
    }
}