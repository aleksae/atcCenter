<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('cid');
            $table->string('full_name');
            $table->string('type');
            $table->string('letter')->nullable;
            $table->string('status')->default('Waiting for review');
            $table->string('reviewee')->nullable();
            $table->timestamps();
            $table->string('notes')->nullable();
            $table->string('FIR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_applications');
    }
}
