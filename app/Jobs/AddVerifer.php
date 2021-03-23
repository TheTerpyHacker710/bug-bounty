<?php

namespace App\Jobs;

use App\Models\VerificationBatch;
use App\Services\VerificationAssigners\VerificationAssigner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddVerifer implements ShouldQueue
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
        //
        $this->verificationBatch = $verificationBatch;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VerificationAssigner $verificationAssigner)
    {
        $verificationAssigner->addVerifier($this->verificationBatch);
    }
}
