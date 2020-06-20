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
            $table->integer('assignment_id');
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
        Schema::dropIfExists('responsible_assignment');
    }
}
