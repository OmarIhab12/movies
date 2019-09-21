<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies_descriptions', function (Blueprint $table) {
            $table->bigInteger('movie_id')->unsigned();
            $table->foreign('movie_id')
                  ->references('id')->on('movies')
                  ->onDelete('cascade');
            $table->text('description');
            $table->string('locale')->index();
            // $table->enum('locale', ['en', 'de'])->index();

            $table->primary(['movie_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies_descriptions');
    }
}
