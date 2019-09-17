<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies_genres', function (Blueprint $table) {
            $table->bigInteger('movie_id')->unsigned();
            $table->foreign('movie_id')
                  ->references('id')->on('movies')
                  ->onDelete('cascade');

            $table->bigInteger('genre_id')->unsigned();
            $table->foreign('genre_id')
                  ->references('id')->on('genres')
                  ->onDelete('cascade');

            $table->primary(['movie_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies_genres');
    }
}
