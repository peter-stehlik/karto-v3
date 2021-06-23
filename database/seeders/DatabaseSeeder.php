<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Person::factory(1000)->create();

        $this->call([
            UserSeeder::class,
            BankAccountSeeder::class,
            CategorySeeder::class,
            PeriodicalPublicationSeeder::class,
            NonperiodicalPublicationSeeder::class,
        ]);
    }
}
