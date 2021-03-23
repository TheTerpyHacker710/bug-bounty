<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    public function activeReports() {
        return $this->hasMany(activeReports::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}
