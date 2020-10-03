<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notification_id')->unsigned();
            $table->string('student_id');
            $table->timestamps();

            $table->foreign('notification_id')->references('notification_id')->on('notifications');
            $table->foreign('student_id')->references('student_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_notifications');
    }
}
