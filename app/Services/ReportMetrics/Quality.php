<?php


namespace App\Services\ReportMetrics;


class Quality extends ProcedureMetric
{
    public $name = "Quality";

    public $title = "On a scale of 1 to 5, how would you rate the overall quality of this report?";

    public $extra = "";

    public $min = 1;

    public $max = 5;
}