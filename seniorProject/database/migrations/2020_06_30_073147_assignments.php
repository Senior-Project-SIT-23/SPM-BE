<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Assignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('assignment_id')->unsigned();
            $table->string('assignment_title', 200);
            $table->string('assignment_detail', 500)->nullable();
            $table->date('due_date');
            $table->time('due_time');
            $table->string('date_time');
            $table->string('teacher_id', 20)->nullable();
            $table->string('aa_id', 20)->nullable();
            $table->bigInteger('rubric_id')->unsigned();
            $table->string('create_time')->nullable();
            $table->timestamps();


            $table->foreign('rubric_id')->references('rubric_id')->on('rubric');
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
        Schema::dropIfExists('assignments');
    }
}
