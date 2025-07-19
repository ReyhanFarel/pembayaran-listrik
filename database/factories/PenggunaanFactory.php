<?php

namespace Database\Factories;

use App\Models\Penggunaan;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenggunaanFactory extends Factory
{
    protected $model = Penggunaan::class;

    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::factory(), // Buat pelanggan otomatis jika belum ada
            'bulan' => $this->faker->monthName(),
            'tahun' => $this->faker->year(),
            'meter_awal' => $this->faker->numberBetween(1000, 3000),
            'meter_akhir' => $this->faker->numberBetween(3001, 6000),
        ];
    }
}
