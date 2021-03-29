<?php


namespace App\Services\ReportMetrics;


class Complexity extends VulnerabilityMetric
{
    public $name = "Complexity";

    public $title = "How complex is this vulnerability to exploit, on a scale of 1 to 5?";

    public $extra = "";

    public $min = 1;

    public $max = 5;
}