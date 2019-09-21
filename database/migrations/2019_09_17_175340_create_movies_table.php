<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('movies', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('title');
          $table->text('description');
          $table->string('image_url');
          $table->decimal('rating', 3, 1);
          $table->year('release_year');
          $table->string('gross_profit');
          $table->string('director');
      });
      DB::statement('ALTER TABLE movies ADD CONSTRAINT chk_rating_min CHECK (rating >= 0);');
      DB::statement('ALTER TABLE movies ADD CONSTRAINT chk_rating_max CHECK (rating <= 10);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
