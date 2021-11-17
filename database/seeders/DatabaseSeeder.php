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
        \App\Models\Person::factory(500)->create();
        \App\Models\Income::factory(1000)->create();
        \App\Models\Transfer::factory(2000)->create();
        \App\Models\PeriodicalOrder::factory(1000)->create();
        \App\Models\NonperiodicalCredit::factory(1000)->create();

        $this->call([
            UserSeeder::class,
            BankAccountSeeder::class,
            CategorySeeder::class,
            PeriodicalPublicationSeeder::class,
            NonperiodicalPublicationSeeder::class,
        ]);
    }
}
