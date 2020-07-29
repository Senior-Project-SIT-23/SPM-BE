<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Appointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->bigIncrements('appointment_id')->unsigned();
            $table->string('appointment_detail');
            $table->bigInteger('rubric_id')->unsigned(); 
            $table->string('teacher_id',20);
            $table->timestamps();

            $table->foreign('rubric_id')->references('rubric_id')->on('rubric');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
