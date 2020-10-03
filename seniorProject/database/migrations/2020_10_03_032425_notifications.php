<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id')->unsigned();
            $table->text('notification_detail');
            $table->bigInteger('assignment_id')->unsigned()->nullable();
            $table->bigInteger('announcement_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments');
            $table->foreign('announcement_id')->references('announcement_id')->on('announcement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
