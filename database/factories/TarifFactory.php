<?php
namespace Database\Factories;
use App\Models\Tarif;
use Illuminate\Database\Eloquent\Factories\Factory;
class TarifFactory extends Factory
{
    protected $model = Tarif::class;
    public function definition(): array
    {
        return [
            'daya' => $this->faker->unique()->numberBetween(450, 5000), // Angka unik
            'tarif_perkwh' => $this->faker->randomFloat(2, 500, 2000),
        ];
    }
}