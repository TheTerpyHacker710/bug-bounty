<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['verification_batch_id', 'assignee_id', 'status', 'actioned_at'];

    public function verificationBatch() {
        return $this->belongsTo(VerificationBatch::class);
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function verificationSubmission() {
        return $this->hasOne(VerificationSubmission::class);
    }

    public function complete() {
        $this->update([
            "status" => "complete",
            "actioned_at" => now(),
        ]);
    }
}
