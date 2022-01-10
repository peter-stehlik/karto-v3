<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tags')->insert([
        'id' => 1,
        'name' => 'Netlačiť adresku',
      ]);

      DB::table('tags')->insert([
        'id' => 2,
        'name' => 'p. Kruták',
      ]);
    }
}
