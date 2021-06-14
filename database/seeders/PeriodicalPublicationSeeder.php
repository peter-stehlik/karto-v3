<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PeriodicalPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('periodical_publications')->insert([
			'id' => 1,
			'name' => 'Malý kalendár',
			'abbreviation' => 'MK',
			'price' => 1,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 2,
			'name' => 'Kalendár nástenný',
			'abbreviation' => 'NA',
			'price' => 1.50,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 3,
			'name' => 'Kalendár knižný',
			'abbreviation' => 'KN',
			'price' => 2.50,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 4,
			'name' => 'Hlasy',
			'abbreviation' => 'HL',
			'price' => 1,
			'current_number' => 0,
			'note' => '',
		]);
    }
}
