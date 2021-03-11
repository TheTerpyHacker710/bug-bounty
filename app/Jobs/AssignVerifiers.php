<?php

namespace App\Jobs;

use App\Models\Report;
use App\Services\VerificationAssigners\VerificationAssigner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignVerifiers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $report;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        //
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VerificationAssigner $verificationAssigner)
    {
        //
        echo $verificationAssigner->assignVerifiers($this->report) . "\n";
    }
}
