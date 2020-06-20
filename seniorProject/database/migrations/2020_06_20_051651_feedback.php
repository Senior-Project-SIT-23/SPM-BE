<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Feedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('feedback_id');
            $table->string('feedback_detail',500);
            $table->bigInteger('assignment_id')->unsigned();
            // $table->bigInteger('appointment_id');
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments');
            // $table->foreign('appointment_id')->references('appointment_id')->on('appointment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
