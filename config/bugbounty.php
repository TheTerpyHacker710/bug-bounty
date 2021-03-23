<?php

use App\Services\DifficultyCalculators\BasicDifficultyCalculator;
use App\Services\ReportMetrics\Complexity;
use App\Services\ReportMetrics\Detail;
use App\Services\ReportMetrics\Quality;
use App\Services\ReportMetrics\Reliability;
use App\Services\ReportMetrics\Severity;
use App\Services\Tips\DummyTip;
use App\Services\UserMetrics\ActivityScore;
use App\Services\UserMetrics\Competence;
use App\Services\UserMetrics\HitRate;
use App\Services\VerificationAssigners\AnotherVerificationAssigner;
use App\Services\VerificationEvaluators\BasicVerificationEvaluator;

return [
    'verificationAssigner' => AnotherVerificationAssigner::class,
    'verificationEvaluator' => BasicVerificationEvaluator::class,
    'difficultyCalculator' => BasicDifficultyCalculator::class,
    'userMetrics' => [
        ActivityScore::class,
        Competence::class,
        HitRate::class,
    ],
    'tips' => [
        DummyTip::class,
    ],
    // Vulnerability metrics which the reporter will indicate and which will also be assessed by verifiers
    'vulnerabilityMetrics' => [
        Severity::class,
        Complexity::class,
        Reliability::class,
    ],
    // Procedure metrics which should only be assessed by verifiers
    'procedureMetrics' => [
        Quality::class,
        Detail::class,
    ],
];