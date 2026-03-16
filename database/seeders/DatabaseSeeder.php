<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ArrondissementSeeder::class,
            CategorySeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
        ]);
    }
}
