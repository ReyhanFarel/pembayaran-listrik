<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition()
    {
        return [
            'nama_pelanggan' => $this->faker->name,
            'username'       => $this->faker->unique()->userName,
            'password'       => Hash::make('password'),
            'alamat'         => $this->faker->address,
            'nomor_kwh'         => $this->faker->numerify('######'),
            'tarif_id'       => 1, // Sesuaikan jika ada relasi tarif!
        ];
    }
}