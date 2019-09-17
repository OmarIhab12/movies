<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesActorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies_actors', function (Blueprint $table) {
          $table->bigInteger('movie_id')->unsigned();
          $table->foreign('movie_id')
                ->references('id')->on('movies')
                ->onDelete('cascade');

          $table->bigInteger('actor_id')->unsigned();
          $table->foreign('actor_id')
                ->references('id')->on('actors')
                ->onDelete('cascade');

          $table->primary(['movie_id', 'actor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies_actors');
    }
}
