<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpmConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spm_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('year_of_study',4);
            $table->string('number_of_member_min',2);
            $table->string('number_of_member_max',1);
            $table->boolean('student_one_more_group');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('spm_config');
        Schema::enableForeignKeyConstraints();
    }
}
