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
			'abbrevation' => 'MK',
			'price' => 1,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 2,
			'name' => 'Kalendár nástenný',
			'abbrevation' => 'NA',
			'price' => 1.50,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 3,
			'name' => 'Kalendár knižný',
			'abbrevation' => 'KN',
			'price' => 2.50,
			'current_number' => 0,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 4,
			'name' => 'Hlasy',
			'abbrevation' => 'HL',
			'price' => 1,
			'current_number' => 0,
			'note' => '',
		]);
    }
}
