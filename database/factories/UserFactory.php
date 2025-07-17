<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        // Pastikan level administrator ada
        $level = Level::where('nama_level', 'administrator')->first();
        $level_id = $level ? $level->id : 1;

        return [
            'username'   => $this->faker->unique()->userName,
            'nama_user'  => $this->faker->name,
            'password'   => Hash::make('password'),
            'level_id'   => $level_id,
        ];
    }
}