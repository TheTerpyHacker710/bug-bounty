<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activeReports extends Model
{
    use HasFactory;

    public function complete() {
        $this->completed_at = now();
        $this->save();
    }
}
