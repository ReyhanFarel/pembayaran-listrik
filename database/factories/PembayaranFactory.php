<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::factory(), // INI YANG BELUM ADA
            'tagihan_id' => Tagihan::factory(),
            'tanggal_pembayaran' => $this->faker->date(),
            'biaya_admin' => $this->faker->randomElement([2500, 3000, 3500]),
            'total_bayar' => $this->faker->numberBetween(100000, 500000),
        ];
    }
}
