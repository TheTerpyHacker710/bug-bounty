<?php


namespace App\Services\VerificationAssigners;


use App\Models\User;

class AnotherVerificationAssigner extends VerificationAssigner
{

    protected function selectVerifiers($query)
    {
        // ignore eligibility and assign to user with lowest ID
        return array(User::orderBy('id')->first());
    }
}