<?php


namespace App\Services\DifficultyCalculators;


use App\Models\Report;

class BasicDifficultyCalculator extends DifficultyCalculator
{
    public function calculateDifficulty(Report $report)
    {
        $weightings = [
            70 => $report->complexity,
            30 => $report->reliability,
        ];

        $difficulty = 0;

        foreach ($weightings as $weight => $value) {
            $difficulty += ($value * $weight) / 100;
        }

        return $difficulty;
    }
}