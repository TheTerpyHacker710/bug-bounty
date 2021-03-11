<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMetricCacheEntry extends Model
{
    use HasFactory;

    protected $table = "user_metric_cache";

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
