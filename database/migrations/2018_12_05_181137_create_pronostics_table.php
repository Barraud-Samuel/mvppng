<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePronosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pronostics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->nullable();
            $table->integer('pronogoalUser_id')->nullable();
            $table->integer('homeTeam_prono')->nullable();
            $table->integer('awayTeam_prono')->nullable();
            $table->boolean('correct_result')->nullable();
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
        Schema::dropIfExists('pronostics');
    }
}
