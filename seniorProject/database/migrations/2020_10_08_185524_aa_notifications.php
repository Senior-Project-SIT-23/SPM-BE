<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AaNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notification_id_fk')->unsigned();
            $table->string('aa_id', 20);
            $table->timestamps();

            $table->foreign('notification_id_fk')->references('notification_id')->on('notifications');
            $table->foreign('aa_id')->references('aa_id')->on('aa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aa_notifications');
    }
}
