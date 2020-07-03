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
            $table->string('assignment_title',200);
            $table->string('assignment_detail',500)->nullable();
            $table->date('publish_date');
            $table->date('due_date');
            $table->string('status',10);
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
        Schema::dropIfExists('assignments');
    }
}
