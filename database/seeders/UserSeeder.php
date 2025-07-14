<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminLevel = Level::where('nama_level', 'administrator')->first();
        $pelangganLevel = Level::where('nama_level', 'pelanggan')->first();

        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama_user' => 'Administrator Utama',
                'password' => Hash::make('password'), // Ganti dengan password yang kuat!
                'level_id' => $adminLevel->id,
            ]
        );

        User::firstOrCreate(
            ['username' => 'pelanggan1'],
            [
                'nama_user' => 'Udin Sedunia',
                'password' => Hash::make('password'),
                'level_id' => $pelangganLevel->id,
            ]
        );
    }
}