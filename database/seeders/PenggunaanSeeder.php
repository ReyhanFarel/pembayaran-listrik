<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penggunaan;
use App\Models\Pelanggan;

class PenggunaanSeeder extends Seeder
{
    public function run()
    {
        // Ambil data pelanggan berdasarkan username
        $lumi = Pelanggan::where('username', 'lumi123')->first();
        $farel = Pelanggan::where('username', 'farel')->first();

        if ($lumi) {
            // Data penggunaan untuk Lumi bulan Januari 2025
            Penggunaan::firstOrCreate(
                [
                    'pelanggan_id' => $lumi->id,
                    'bulan' => 'Januari',
                    'tahun' => 2025,
                ],
                [
                    'meter_awal' => 1000,
                    'meter_akhir' => 1150,
                ]
            );

            // Data penggunaan untuk Lumi bulan Februari 2025
            Penggunaan::firstOrCreate(
                [
                    'pelanggan_id' => $lumi->id,
                    'bulan' => 'Februari',
                    'tahun' => 2025,
                ],
                [
                    'meter_awal' => 1150,
                    'meter_akhir' => 1280,
                ]
            );
        }

        if ($farel) {
            // Data penggunaan untuk Farel bulan Januari 2025
            Penggunaan::firstOrCreate(
                [
                    'pelanggan_id' => $farel->id,
                    'bulan' => 'Januari',
                    'tahun' => 2025,
                ],
                [
                    'meter_awal' => 2000,
                    'meter_akhir' => 2200,
                ]
            );

            // Data penggunaan untuk Farel bulan Februari 2025
            Penggunaan::firstOrCreate(
                [
                    'pelanggan_id' => $farel->id,
                    'bulan' => 'Februari',
                    'tahun' => 2025,
                ],
                [
                    'meter_awal' => 2200,
                    'meter_akhir' => 2350,
                ]
            );
        }
    }
}