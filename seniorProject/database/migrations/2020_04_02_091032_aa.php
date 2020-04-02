<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Aa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa', function (Blueprint $table) {
            $table->string('aa_id',20)->primary();
            $table->string('aa_name',100);
            $table->string('aa_email',500);
            $table->string('department',3)->nullable();
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
        Schema::dropIfExists('aa');
        Schema::enableForeignKeyConstraints();
    }
}
