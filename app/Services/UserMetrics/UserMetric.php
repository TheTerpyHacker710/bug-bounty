<?php


namespace App\Services\UserMetrics;


use App\Models\User;
use App\Models\UserMetricCacheEntry;

abstract class UserMetric
{
    // an associative array
    // the keys are the events at which this metric should be updated
    // the values are the methods to calculate which users to update at that event
    protected $getUserMethods;

    // get the users for whom this metric should be updated
    protected function getUsers($event): array {
        $users = array();
        $eventClass = get_class($event);
        if (array_key_exists($eventClass, $this->getUserMethods)) {
            $method = $this->getUserMethods[$eventClass];
            if (is_callable([$this, $method])) {
               $users = $this->$method($event);
            }
        }
        return $users;
    }

    public function updateEvent($event) {
        $users = $this->getUsers($event);
        $this->update($users);
    }

    // updates the cached metric value for the given users
    public function update($users)
    {
        $values = $this->compute($users);
        foreach ($values as $user => $value) {
            UserMetricCacheEntry::updateOrCreate(
                ['user_id' => $user, 'metric' => get_class($this)],
                ['value' => $value]
            );
        }
    }

    // gets the metric values for the given users, updating the cache if necessary
    public function get($users)
    {
        $this->fillCache($users);
        return UserMetricCacheEntry::whereIn('user_id', $users)
            ->where('metric', get_class($this))
            ->get(['user_id', 'value'])
            ->pluck('value', 'user_id')
            ->all();
    }

    // computes and returns the metric value for the given users
    abstract protected function compute($users);

    // returns a list of events at which this metric should be updated
    public function getUpdateEvents(): array {
        return array_keys($this->getUserMethods);
    }

    // ensures cached values are present for all given users
    private function fillCache($users)
    {
        $cachedUsers = UserMetricCacheEntry::whereIn('user_id', $users)
            ->where('metric', get_class($this))
            ->get(['user_id'])
            ->pluck('user_id')
            ->all();
        $nonCachedUsers = array_diff($users, $cachedUsers);
        $this->update($nonCachedUsers);
    }
}