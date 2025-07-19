<?php
namespace Database\Factories;
use App\Models\User;
use App\Models\Level; // Import Level
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    public function definition(): array
    {
        // Pastikan ada level di DB, atau buat jika tidak ada
        $level = Level::first() ?: Level::factory()->create();
        return [
            'nama_user' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // Default password untuk test
            'level_id' => $level->id,
            'remember_token' => Str::random(10),
        ];
    }
}