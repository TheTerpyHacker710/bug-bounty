<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationBatch extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'voted_procedure_metrics' => AsArrayObject::class,
        'voted_vulnerability_metrics' => AsArrayObject::class,
    ];

    public function report() {
        return $this->belongsTo(Report::class);
    }

    public function verificationAssignments() {
        return $this->hasMany(VerificationAssignment::class);
    }

    public function verificationSubmissions() {
        return $this->hasManyThrough(VerificationSubmission::class, VerificationAssignment::class);
    }

    public function isReady() {
        return $this->verificationAssignments->map(function($item, $key) {
            return $item->status == "pending";
        })->filter()->isEmpty();
    }
}
