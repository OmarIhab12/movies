<?php

use Illuminate\Database\Seeder;

class ActorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $actors = [
            ['name' => 'Robert De Niro,'],
            ['name' => 'Cathy Moriarty'],
            ['name' => 'Joe Pesci'],
            ['name' => 'Frank Vincent'],
            ['name' => 'Liam Neeson'],
            ['name' => 'Ralph Fiennes'],
            ['name' => 'Ben Kingsley'],
            ['name' => 'Caroline Goodall'],
            ['name' => 'Tim Robbins'],
            ['name' => 'Morgan Freeman'],
            ['name' => 'Bob Gunton'],
        ];
      DB::table('actors')->insert($actors);
    }
}
