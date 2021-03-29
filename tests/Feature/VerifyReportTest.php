<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifyReportTest extends CoreTest
{
    use RefreshDatabase;

    public function test_users_can_verify_a_report()
    {
        $this->verify_report();
    }
}
