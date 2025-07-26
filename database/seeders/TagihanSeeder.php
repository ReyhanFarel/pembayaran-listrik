<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Pelanggan;

class TagihanSeeder extends Seeder
{
    public function run()
    {
        // Ambil data pelanggan berdasarkan username
        $lumi = Pelanggan::where('username', 'lumi123')->first();
        $farel = Pelanggan::where('username', 'farel')->first();

        if ($lumi) {
            // Ambil penggunaan untuk Lumi
            $penggunaanLumiJan = Penggunaan::where('pelanggan_id', $lumi->id)
                ->where('bulan', 'Januari')
                ->where('tahun', 2025)
                ->first();

            $penggunaanLumiFeb = Penggunaan::where('pelanggan_id', $lumi->id)
                ->where('bulan', 'Februari')
                ->where('tahun', 2025)
                ->first();

            // Buat tagihan untuk Lumi Januari 2025
            if ($penggunaanLumiJan) {
                $jumlahMeterJan = $penggunaanLumiJan->meter_akhir - $penggunaanLumiJan->meter_awal;
                Tagihan::firstOrCreate(
                    [
                        'penggunaan_id' => $penggunaanLumiJan->id,
                        'pelanggan_id' => $lumi->id,
                        'bulan' => 'Januari',
                        'tahun' => 2025,
                    ],
                    [
                        'jumlah_meter' => $jumlahMeterJan,
                        'status_tagihan' => 'Belum Dibayar',
                    ]
                );
            }

            // Buat tagihan untuk Lumi Februari 2025
            if ($penggunaanLumiFeb) {
                $jumlahMeterFeb = $penggunaanLumiFeb->meter_akhir - $penggunaanLumiFeb->meter_awal;
                Tagihan::firstOrCreate(
                    [
                        'penggunaan_id' => $penggunaanLumiFeb->id,
                        'pelanggan_id' => $lumi->id,
                        'bulan' => 'Februari',
                        'tahun' => 2025,
                    ],
                    [
                        'jumlah_meter' => $jumlahMeterFeb,
                        'status_tagihan' => 'Sudah Dibayar',
                    ]
                );
            }
        }

        if ($farel) {
            // Ambil penggunaan untuk Farel
            $penggunaanFarelJan = Penggunaan::where('pelanggan_id', $farel->id)
                ->where('bulan', 'Januari')
                ->where('tahun', 2025)
                ->first();

            $penggunaanFarelFeb = Penggunaan::where('pelanggan_id', $farel->id)
                ->where('bulan', 'Februari')
                ->where('tahun', 2025)
                ->first();

            // Buat tagihan untuk Farel Januari 2025
            if ($penggunaanFarelJan) {
                $jumlahMeterJan = $penggunaanFarelJan->meter_akhir - $penggunaanFarelJan->meter_awal;
                Tagihan::firstOrCreate(
                    [
                        'penggunaan_id' => $penggunaanFarelJan->id,
                        'pelanggan_id' => $farel->id,
                        'bulan' => 'Januari',
                        'tahun' => 2025,
                    ],
                    [
                        'jumlah_meter' => $jumlahMeterJan,
                        'status_tagihan' => 'Belum Dibayar',
                    ]
                );
            }

            // Buat tagihan untuk Farel Februari 2025
            if ($penggunaanFarelFeb) {
                $jumlahMeterFeb = $penggunaanFarelFeb->meter_akhir - $penggunaanFarelFeb->meter_awal;
                Tagihan::firstOrCreate(
                    [
                        'penggunaan_id' => $penggunaanFarelFeb->id,
                        'pelanggan_id' => $farel->id,
                        'bulan' => 'Februari',
                        'tahun' => 2025,
                    ],
                    [
                        'jumlah_meter' => $jumlahMeterFeb,
                        'status_tagihan' => 'Sudah Dibayar',
                    ]
                );
            }
        }
    }
}