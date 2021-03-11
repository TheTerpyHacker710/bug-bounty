<?php


namespace App\Services\DifficultyCalculators;


use App\Models\Report;

abstract class DifficultyCalculator
{
    abstract public function calculateDifficulty(Report $report);
}