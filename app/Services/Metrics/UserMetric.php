<?php


namespace App\Services\Metrics;


use App\Models\UserMetricCacheEntry;

abstract class UserMetric
{
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