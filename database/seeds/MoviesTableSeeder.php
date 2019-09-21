<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Movie;
use App\Genre;
use App\Actor;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
        $faker = Faker::create();
        foreach (range(1,50) as $index) {
            DB::table('movies')->insert([
                'title' => $faker->name,
                'description' => $faker->email,
                'image_url' => $faker->name,
                // 'image_url' =>$faker->image('public/storage/images',400,300, null, false),
                'rating' => rand(0, 10),
                'release_year' => 2018,
                'gross_profit' => '50M',
                'director' => $faker->name,
            ]);
        }

        $genres = Genre::all();
        Movie::all()->each(function ($movies) use ($genres) {
            $movies->genres()->attach(
              $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $actors = Actor::all();
        Movie::all()->each(function ($movies) use ($actors) {
            $movies->actors()->attach(
              $actors->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
     }
}
