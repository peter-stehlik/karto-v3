<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('categories')->insert([
			'id' => 1,
			'name' => 'Nezaradené',
		]);

 		DB::table('categories')->insert([
			'id' => 2,
			'name' => 'Biskupstvá',
		]);

 		DB::table('categories')->insert([
			'id' => 3,
			'name' => 'Diecéza Žilina',
		]);

 		DB::table('categories')->insert([
			'id' => 4,
			'name' => 'Diecéza Bratislava',
		]);	

		DB::table('categories')->insert([
			'id' => 5,
			'name' => 'Diecéza Trnava',
		]);

 		DB::table('categories')->insert([
			'id' => 6,
			'name' => 'Diecéza Spiš',
		]);

 		DB::table('categories')->insert([
			'id' => 7,
			'name' => 'Diecéza Rožňava',
		]);

 		DB::table('categories')->insert([
			'id' => 8,
			'name' => 'Diecéza Prešov',
		]);	

		DB::table('categories')->insert([
			'id' => 9,
			'name' => 'Diecéza Nitra',
		]);

 		DB::table('categories')->insert([
			'id' => 10,
			'name' => 'Diecéza Košice',
		]);

 		DB::table('categories')->insert([
			'id' => 11,
			'name' => 'Diecéza Banská Bystrica',
		]);

 		DB::table('categories')->insert([
			'id' => 12,
			'name' => 'Osobny darca',
		]);

		DB::table('categories')->insert([
			'id' => 13,
			'name' => 'Dobrodinci',
		]);

 		DB::table('categories')->insert([
			'id' => 14,
			'name' => 'Hromnice',
		]);

 		DB::table('categories')->insert([
			'id' => 15,
			'name' => 'Rehole',
		]);

 		DB::table('categories')->insert([
			'id' => 16,
			'name' => 'Rodičia',
		]);	

		DB::table('categories')->insert([
			'id' => 17,
			'name' => 'Pátri',
		]);

 		DB::table('categories')->insert([
			'id' => 18,
			'name' => 'Nemecko',
		]);

 		DB::table('categories')->insert([
			'id' => 19,
			'name' => 'Pošta',
		]);

 		DB::table('categories')->insert([
			'id' => 20,
			'name' => 'Ex-verbisti',
		]);	

		DB::table('categories')->insert([
			'id' => 21,
			'name' => 'Čína',
		]);

 		DB::table('categories')->insert([
			'id' => 22,
			'name' => 'Škola',
		]);

 		DB::table('categories')->insert([
			'id' => 23,
			'name' => 'Sponzor',
		]);

 		DB::table('categories')->insert([
			'id' => 24,
			'name' => 'Obecný úrad',
		]);
		 
		DB::table('categories')->insert([
			'id' => 25,
			'name' => 'Knižnica',
		]);
		 
		DB::table('categories')->insert([
			'id' => 26,
			'name' => 'Farnosť',
		]);
    }
}
