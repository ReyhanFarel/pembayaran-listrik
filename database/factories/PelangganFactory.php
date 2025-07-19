<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\Tarif; // Pastikan ini diimport
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition(): array
    {
        // Pastikan ada tarif di DB saat factory ini dijalankan, atau buat jika tidak ada
        $tarif = Tarif::first() ?: Tarif::factory()->create();

        return [
            'tarif_id' => $tarif->id,
            'nama_pelanggan' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password123'), // Default password untuk test
            'alamat' => $this->faker->address,
            // KOREKSI DI SINI: Gunakan randomNumber() dan cast ke string
            'nomor_kwh' => (string) $this->faker->unique()->randomNumber(8, true), // Menghasilkan 8 digit angka sebagai string
            'remember_token' => Str::random(10),
        ];
    }
}