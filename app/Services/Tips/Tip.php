<?php


namespace App\Services\Tips;


use App\Models\User;

abstract class Tip
{
    // associative array of event class => handler function
    protected $eventHandlers;

    // call the correct processing method based on the given event
    public function process($event)
    {
        $class = get_class($event);
        if (array_key_exists($class, $this->eventHandlers)) {
            $method = $this->eventHandlers[$class];
            if (is_callable([$this, $method])) {
                $tips = $this->$method($event);
                foreach ($tips as $userId => $tip) {
                    User::find($userId)->notify(new \App\Notifications\Tip($tip));
                }
            }
        }
    }

    public function getValidEvents(): array
    {
        return array_keys($this->eventHandlers);
    }
}