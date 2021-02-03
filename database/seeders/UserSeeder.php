<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Peter Stehlík',
            'email' => 'peter@inovative.sk',
            'email_verified_at' => now(),
            'password' => Hash::make('.KartotekA1510/'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Katarína Vallová',
            'email' => 'katarina.vallova@svd.sk',
            'email_verified_at' => now(),
            'password' => Hash::make('kalvaria1'),
            'remember_token' => Str::random(10),
        ]);
        
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Katarína Mancírová',
            'email' => 'katarina.mancirova@svd.sk',
            'email_verified_at' => now(),
            'password' => Hash::make('kalvaria2'),
            'remember_token' => Str::random(10),
        ]);
    }
}
