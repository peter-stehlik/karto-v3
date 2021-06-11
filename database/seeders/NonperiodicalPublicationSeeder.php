<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class NonperiodicalPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('nonperiodical_publications')->insert([
			'id' => 1,
			'name' => 'Knihy',
		]);

		DB::table('nonperiodical_publications')->insert([
			'id' => 2,
			'name' => 'Intencie',
		]);

		DB::table('nonperiodical_publications')->insert([
			'id' => 3,
			'name' => 'Dary',
		]);
    }
}
