<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Announcement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->bigIncrements('announcement_id')->unsigned();
            $table->string('announcement_title',200);
            $table->string('announcement_detail',5000);
            $table->date('announcement_date');
            $table->string('teacher_id',20)->nullable();
            $table->string('aa_id',20)->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');
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
        Schema::dropIfExists('announcement');
    }
}
