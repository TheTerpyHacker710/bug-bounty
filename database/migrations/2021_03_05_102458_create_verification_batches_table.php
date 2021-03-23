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
            $table->integer('voted_quality')->nullable();
            $table->integer('voted_detail')->nullable();
            $table->integer('voted_severity')->nullable();
            $table->integer('voted_complexity')->nullable();
            $table->integer('voted_reliability')->nullable();
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
