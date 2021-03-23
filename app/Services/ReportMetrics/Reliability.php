<?php


namespace App\Services\ReportMetrics;


class Reliability extends VulnerabilityMetric
{
    public $name = "Reliability";

    public $title = "How reliable is the procedure for exploiting this vulnerability, on a scale of 1 to 5?";

    public $extra = "";

    public $min = 1;

    public $max = 5;
}