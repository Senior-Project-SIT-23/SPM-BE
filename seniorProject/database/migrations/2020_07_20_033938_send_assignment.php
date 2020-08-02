<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SendAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_assignment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('send_assignment_name',100);
            $table->string('send_assignment',200);
            $table->bigInteger('assignment_id')->unsigned();
            $table->string('project_id',10);
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_assignment');
    }
}
