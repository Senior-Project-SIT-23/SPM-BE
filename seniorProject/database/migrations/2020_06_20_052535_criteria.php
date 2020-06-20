<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Criteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->bigIncrements('criteria_id')->unsigned();
            $table->string('criteria_name',50);
            $table->bigInteger('rubric_id')->unsigned();
            $table->timestamps();

            $table->foreign('rubric_id')->references('rubric_id')->on('rubric');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria');
    }
}
