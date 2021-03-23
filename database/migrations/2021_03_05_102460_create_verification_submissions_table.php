<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_assignment_id')->constrained();
            $table->boolean('verifiable');
            $table->json('vulnerability_metrics');
            $table->json('procedure_metrics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_submissions');
    }
}
