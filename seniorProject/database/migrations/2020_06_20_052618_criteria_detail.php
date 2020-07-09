<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriteriaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_detail', function (Blueprint $table) {
            $table->bigIncrements('criteria_detail_id');
            $table->string('criteria_detail',50);
            $table->bigInteger('criteria_id')->unsigned();            
            $table->timestamps();

            $table->foreign('criteria_id')->references('criteria_id')->on('criteria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria_detail');
    }
}
