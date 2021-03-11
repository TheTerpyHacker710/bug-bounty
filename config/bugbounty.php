<?php

use App\Services\DifficultyCalculators\BasicDifficultyCalculator;
use App\Services\VerificationAssigners\AnotherVerificationAssigner;
use App\Services\VerificationEvaluators\BasicVerificationEvaluator;

return [
    'verificationAssigner' => AnotherVerificationAssigner::class,
    'verificationEvaluator' => BasicVerificationEvaluator::class,
    'difficultyCalculator' => BasicDifficultyCalculator::class
];