<?php


namespace App\Services\ReportMetrics;


class Detail extends ProcedureMetric
{
    public $name = "Detail";

    public $title = "On a scale of 1 to 5, how would you rate the level of detail included in this report?";

    public $extra = "";

    public $min = 1;

    public $max = 5;
}