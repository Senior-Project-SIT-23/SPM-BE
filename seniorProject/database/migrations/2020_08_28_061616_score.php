<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Score extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->bigIncrements('individual_score_id');
            $table->integer('score');
            $table->string('student_id',11);
            $table->bigInteger('assignment_id')->unsigned()->nullable();
            $table->bigInteger('appointment_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('assignment_id')->references('assignment_id')->on('assignments');
            $table->foreign('appointment_id')->references('appointment_id')->on('appointment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score');
    }
}
