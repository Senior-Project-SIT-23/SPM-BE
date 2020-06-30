<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResponsibleAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsible_assignment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('assignment_id')->unsigned();
            $table->string('teacher_id',20);
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments');
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
        Schema::dropIfExists('responsible_assignment');
    }
}
