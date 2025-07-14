<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Level;
use App\Models\User;
use App\Models\Tarif;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // Level
        $adminLevel = Level::firstOrCreate(['nama_level' => 'Administrator']);
        $petugasLevel = Level::firstOrCreate(['nama_level' => 'Petugas']);

        // User (Admin & Petugas)
        User::firstOrCreate(
            ['username' => 'admin1'],
            [
                'nama_user' => 'Administrator Utama',
                'password' => Hash::make('password'), // Ganti dengan password yang kuat di produksi
                'level_id' => $adminLevel->id,
            ]
        );

        User::firstOrCreate(
            ['username' => 'petugas'],
            [
                'nama_user' => 'Petugas Loket',
                'password' => Hash::make('password'),
                'level_id' => $petugasLevel->id,
            ]
        );

        // Tarif
        $tarif900 = Tarif::firstOrCreate(
            ['daya' => 900],
            ['tarif_perkwh' => 1352.00]
        );
        $tarif1300 = Tarif::firstOrCreate(
            ['daya' => 1300],
            ['tarif_perkwh' => 1444.70]
        );

        // Pelanggan
        $pelanggan1 = Pelanggan::firstOrCreate(
            ['username' => 'pelanggan1'],
            [
                'tarif_id' => $tarif900->id,
                'nama_pelanggan' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
             
            ]
        );

        $pelanggan2 = Pelanggan::firstOrCreate(
            ['username' => 'pelanggan2'],
            [
                'tarif_id' => $tarif1300->id,
                'nama_pelanggan' => 'Citra Dewi',
                'password' => Hash::make('password'),
                'alamat' => 'Perumahan Indah Blok C, Bogor',
              
            ]
        );

        // Penggunaan (Contoh)
        $penggunaan1 = Penggunaan::firstOrCreate(
            [
                'pelanggan_id' => $pelanggan1->id,
                'bulan' => 'Juni',
                'tahun' => 2025,
            ],
            [
                'meter_awal' => 100,
                'meter_akhir' => 250,
            ]
        );

        $penggunaan2 = Penggunaan::firstOrCreate(
            [
                'pelanggan_id' => $pelanggan2->id,
                'bulan' => 'Juni',
                'tahun' => 2025,
            ],
            [
                'meter_awal' => 50,
                'meter_akhir' => 200,
            ]
        );

        // Tagihan (Otomatis dibuat saat penggunaan disimpan, tetapi bisa disisipkan untuk data awal)
        Tagihan::firstOrCreate(
            [
                'id_penggunaan' => $penggunaan1->id,
                'pelanggan_id' => $pelangaan1->id,
                'bulan' => $penggunaan1->bulan,
                'tahun' => $penggunaan1->tahun,
            ],
            [
                'jumlah_meter' => $penggunaan1->meter_akhir - $penggunaan1->meter_awal,
                'status_tagihan' => 'Belum Lunas',
            ]
        );

        Tagihan::firstOrCreate(
            [
                'id_penggunaan' => $penggunaan2->id,
                'pelanggan_id' => $pelanggan2->id,
                'bulan' => $penggunaan2->bulan,
                'tahun' => $penggunaan2->tahun,
            ],
            [
                'jumlah_meter' => $penggunaan2->meter_akhir - $penggunaan2->meter_awal,
                'status_tagihan' => 'Belum Lunas',
            ]
        );
    }
}