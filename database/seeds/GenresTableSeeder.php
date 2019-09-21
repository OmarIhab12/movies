<?php

use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $genres = [
            ['name' => 'action'],
            ['name' => 'comedy'],
            ['name' => 'horror'],
            ['name' => 'light'],
            ['name' => 'romance'],
            ['name' => 'cartoon'],
            ['name' => 'drama'],
            ['name' => 'musical'],
            ['name' => 'crime'],
            ['name' => 'history'],
            ['name' => 'sport'],
        ];
      DB::table('genres')->insert($genres);
    }
}
