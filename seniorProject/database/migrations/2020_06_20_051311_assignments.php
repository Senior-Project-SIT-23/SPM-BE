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
            $table->string('assignment_detail',500);
            $table->date('publish_date');
            $table->date('due_date');
            $table->string('status',10);
            $table->string('teacher_id',20);
            $table->string('aa_id',20);           
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
        Schema::dropIfExists('assignments');
    }
}
