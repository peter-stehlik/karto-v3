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
			'label_date' => '2021-11-01',
			'accounting_date' => '2021-11-01',
			'abbreviation' => 'MK',
			'price' => 1,
			'current_number' => 11,
			'current_volume' => 2021,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 2,
			'name' => 'Kalendár nástenný',
			'label_date' => '2021-11-01',
			'accounting_date' => '2021-11-01',
			'abbreviation' => 'NA',
			'price' => 1.50,
			'current_number' => 11,
			'current_volume' => 2021,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 3,
			'name' => 'Kalendár knižný',
			'label_date' => '2021-11-01',
			'accounting_date' => '2021-11-01',
			'abbreviation' => 'KN',
			'price' => 2.50,
			'current_number' => 11,
			'current_volume' => 2021,
			'note' => '',
		]);

		DB::table('periodical_publications')->insert([
			'id' => 4,
			'name' => 'Hlasy',
			'label_date' => '2021-11-01',
			'accounting_date' => '2021-11-01',
			'abbreviation' => 'HL',
			'price' => 1,
			'current_number' => 11,
			'current_volume' => 2021,
			'note' => '',
		]);
    }
}
