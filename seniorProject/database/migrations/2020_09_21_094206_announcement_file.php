<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnouncementFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_file', function (Blueprint $table) {
            $table->bigIncrements('announcement_file_id')->unsigned();
            $table->string('announcement_file_name',100)->nullable();
            $table->string('announcement_file',200)->nullable();
            $table->string('keep_file_name',100)->nullable();
            $table->bigInteger('announcement_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('announcement_id')->references('announcement_id')->on('announcement')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_file');
    }
}
