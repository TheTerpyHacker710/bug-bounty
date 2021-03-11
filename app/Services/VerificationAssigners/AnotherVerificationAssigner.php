<?php


namespace App\Services\VerificationAssigners;


use App\Models\User;

class AnotherVerificationAssigner extends VerificationAssigner
{

    protected function selectVerifiers($query)
    {
        // ignore eligibility and assign to user 1
        return User::whereId(1)->get();
    }
}