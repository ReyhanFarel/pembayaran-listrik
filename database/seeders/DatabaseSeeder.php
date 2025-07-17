<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    $this->call(LevelSeeder::class);
    $this->call(UserSeeder::class);
    $this->call(TarifSeeder::class);
    $this->call(PelangganSeeder::class);
}
}