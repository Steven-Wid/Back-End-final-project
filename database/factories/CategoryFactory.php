<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Makanan', 'Minuman', 'Elektronik', 'Pakaian', 'Peralatan Rumah', 'Kesehatan', 'Olahraga', 'Buku'];
        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
