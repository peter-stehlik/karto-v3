<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('bank_accounts')->insert([
			'id' => 1,
			'bank_name' => 'Slovenská sporiteľňa',
			'abbreviation' => 'SLSP',
			'number' => 'SK101231231456',
		]);

 		DB::table('bank_accounts')->insert([
			'id' => 2,
			'bank_name' => 'OTP Banka',
			'abbreviation' => 'OTP',
			'number' => 'SK1000009876',
		]);

		DB::table('bank_accounts')->insert([
			'id' => 3,
			'bank_name' => 'Pokladňa',
			'abbreviation' => '',
			'number' => '',
		]);

		DB::table('bank_accounts')->insert([
			'id' => 4,
			'bank_name' => 'Tatra Banka',
			'abbreviation' => 'TB',
			'number' => '2924865513',
		]);

		DB::table('bank_accounts')->insert([
			'id' => 5,
			'bank_name' => 'Dexia',
			'abbreviation' => 'DEX',
			'number' => '805945001',
		]);
    }
}
