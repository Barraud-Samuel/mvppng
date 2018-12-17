<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->nullable();
            $table->integer( 'matchday')->nullable();
            $table->string( 'homeTeamName')->nullable();
            $table->string( 'awayTeamName')->nullable();
            $table->integer( 'result_goalsHomeTeam')->nullable();
            $table->integer( 'result_goalsAwayTeam')->nullable();
            $table->integer( 'halfTime_result_goalsHomeTeam')->nullable();
            $table->integer( 'halfTime_result_goalsAwayTeam')->nullable();
            $table->integer( 'extraTime_result_goalsHomeTeam')->nullable();
            $table->integer( 'extraTime_result_goalsAwayTeam')->nullable();
            $table->integer( 'penaltyShootout_result_goalsHomeTeam')->nullable();
            $table->integer( 'penaltyShootout_result_goalsAwayTeam')->nullable();
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
        Schema::dropIfExists('matchs');
    }
}
