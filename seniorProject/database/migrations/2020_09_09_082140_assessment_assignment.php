<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssessmentAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_assignment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('score');
            $table->bigInteger('criteria_id')->unsigned();
            $table->bigInteger('assignment_id')->unsigned();
            $table->bigInteger('responsible_assignment_id')->unsigned();
            $table->string('project_id', 10);
            $table->timestamps();

            $table->foreign('criteria_id')->references('criteria_id')->on('criteria')->onDelete('cascade');
            $table->foreign('assignment_id')->references('assignment_id')->on('assignments')->onDelete('cascade');
            $table->foreign('responsible_assignment_id')->references('id')->on('responsible_assignment')->onDelete('cascade');
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
        Schema::dropIfExists('assessment_assignment');
    }
}
