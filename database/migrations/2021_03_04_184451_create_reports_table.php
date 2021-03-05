<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Reporter User ID')->constrained('users');
            $table->foreignId('program_id')->constrained('programs');
            $table->timestamps();
            $table->text('Description');
            $table->integer('Severity Score');
            $table->integer('Number of Steps');
            $table->integer('Reliability');
            $table->string('Verification Approved')->nullable();
            $table->string('Status')->default('Pending...');
            $table->timestamp('Actioned At')->nullable();
            $table->integer('NumOfCancelledVerifications')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
