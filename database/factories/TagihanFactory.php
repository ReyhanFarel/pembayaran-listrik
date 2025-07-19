<?php

namespace Database\Factories;

use App\Models\Tagihan;
use App\Models\Pelanggan; // Pastikan Pelanggan diimport
use App\Models\Penggunaan; // Pastikan Penggunaan diimport
use Illuminate\Database\Eloquent\Factories\Factory;

class TagihanFactory extends Factory
{
    protected $model = Tagihan::class;

    public function definition(): array
    {
        // Pastikan ada pelanggan dan penggunaan di DB atau buat jika tidak ada
        $pelanggan = Pelanggan::first() ?: Pelanggan::factory()->create();
        $penggunaan = Penggunaan::where('pelanggan_id', $pelanggan->id)->first() ?: Penggunaan::factory()->create(['pelanggan_id' => $pelanggan->id]);

        return [
            'pelanggan_id' => $pelanggan->id,
            'penggunaan_id' => $penggunaan->id,
            'bulan' => $this->faker->monthName(),
            'tahun' => $this->faker->year(),
            'jumlah_meter' => $this->faker->numberBetween(50, 500), // <-- TAMBAHKAN BARIS INI
            'status_tagihan' => $this->faker->randomElement(['Belum Dibayar', 'Sudah Dibayar']), // <-- Pastikan ini konsisten dengan ENUM Anda
        ];
    }
}