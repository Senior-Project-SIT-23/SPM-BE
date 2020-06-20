<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rubric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubric', function (Blueprint $table) {
            $table->bigIncrements('rubric_id')->unsigned();
            $table->string('rubric_name',50);
            $table->bigInteger('assignment_id')->unsigned();
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubric');
    }
}
