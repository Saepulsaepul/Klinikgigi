<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabang>
 */
class CabangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'=> fake()->nama(),
            'alamat'=> fake()->address(),
            'telepon'=> fake()->phoneNumber(),
            'email'=> fake()->email(),
            'latitude'=> fake()->latitude(),
            'longitude'=> fake()->longitude(),
            
            
        ];
    }
}
