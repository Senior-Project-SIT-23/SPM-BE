<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriteriaScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_score', function (Blueprint $table) {
            $table->bigIncrements('criteria_score_id')->unsigned();
            $table->integer('criteria_score');
            $table->bigInteger('criteria_detail_id')->unsigned();
            $table->timestamps();

            $table->foreign('criteria_detail_id')->references('criteria_detail_id')->on('criteria_detail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria_score');
    }
}
