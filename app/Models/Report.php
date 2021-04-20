<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'procedure', 'metrics', 'creator_id', 'title', 'vendorApproved'];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function program() {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function verificationBatches() {
        return $this->hasMany(VerificationBatch::class);
    }

//    public function verificationAssignments() {
//        return $this->hasManyThrough(VerificationAssignment::class, VerificationBatch::class);
//    }
}
