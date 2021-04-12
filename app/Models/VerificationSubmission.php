<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationSubmission extends Model
{
    use HasFactory;

    //protected $guarded = [];

    protected $casts = [
        'procedure_metrics' => AsArrayObject::class,
        'vulnerability_metrics' => AsArrayObject::class,
    ];

    public function verificationAssignment() {
        return $this->belongsTo(VerificationAssignment::class);
    }
}
