<?php


namespace App\Services\ReportMetrics;


class Severity extends VulnerabilityMetric
{
    public $name = "Severity";

    public $title = "How severe is this vulnerability, on a scale of 1 to 5?";

    public $extra = "";

    public $min = 1;

    public $max = 5;
}