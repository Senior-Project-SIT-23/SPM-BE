<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResponsibleAaGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsible_aa_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aa_id',20);
            $table->string('project_id',10);
            $table->timestamps();

            $table->foreign('aa_id')->references('aa_id')->on('aa')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsible_aa_group');
    }
}
