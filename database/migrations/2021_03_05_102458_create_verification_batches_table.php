<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained();
            $table->enum('status', array('pending', 'accepted', 'reassigned'))->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->json('voted_procedure_metrics')->nullable();
            $table->json('voted_vulnerability_metrics')->nullable();
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
        Schema::dropIfExists('verification_batches');
    }
}
