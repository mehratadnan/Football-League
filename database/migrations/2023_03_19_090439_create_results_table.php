<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id');
            $table->unsignedBigInteger('home_team_score');
            $table->unsignedBigInteger('away_team_score');
            $table->unsignedBigInteger('winner')->nullable();
            $table->timestamps();

            $table->foreign('fixture_id')->references('id')->on('fixtures');
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}

