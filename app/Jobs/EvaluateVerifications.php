<?php

namespace App\Jobs;

use App\Events\VerificationBatchCompleted;
use App\Models\VerificationBatch;
use App\Services\VerificationEvaluators\VerificationEvaluator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EvaluateVerifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $verificationBatch;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(VerificationBatch $verificationBatch)
    {
        $this->verificationBatch = $verificationBatch;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VerificationEvaluator $verificationEvaluator)
    {
        // calculate whether report is accepted, rejected, or reassigned to new batch
        $verificationEvaluator->process($this->verificationBatch);
        // dispatch verification batch complete event
        VerificationBatchCompleted::dispatch($this->verificationBatch);
    }
}
