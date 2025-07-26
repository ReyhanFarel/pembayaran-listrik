<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        Pelanggan::firstOrCreate(
            ['username' => 'lumi123'],
            [
                'nama_pelanggan' => 'Lumi123',
                'password' => Hash::make('secret'),
                'alamat' => 'Jl. Sudirman',
                'nomor_kwh' => '12345214126',
                'tarif_id' => 1
            ]
        );

        Pelanggan::firstOrCreate(
            ['username' => 'farel'],
            [
                'nama_pelanggan' => 'Farel',
                'password' => Hash::make('secret'),
                'alamat' => 'Jl. Merdeka No. 45',
                'nomor_kwh' => '98765432109',
                'tarif_id' => 2
            ]
        );


    }
}