<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_batch_id')->constrained();
            $table->foreignId('assignee_id')->constrained('users');
            $table->enum('status', array('pending', 'complete'))->default('pending');
            $table->timestamp('actioned_at')->nullable();
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
        Schema::dropIfExists('verification_assignments');
    }
}
