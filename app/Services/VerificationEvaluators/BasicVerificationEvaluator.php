<?php


namespace App\Services\VerificationEvaluators;


class BasicVerificationEvaluator extends VerificationEvaluator
{
    // return whether a batch is verified or rejected
    public function evaluateReport($verificationBatch)
    {
        // verified if at least 80% were able to verify
        return $verificationBatch->verificationSubmissions->avg->verifiable > 0.8;
    }

    protected function evaluateVerifications($verificationBatch)
    {
        return true;
    }
}