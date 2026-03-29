<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->userName() . '@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'phone'             => '08' . $this->faker->numerify('#########'),
            'role'              => 'user',
            'remember_token'    => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name'     => 'Admin ChipiChapa',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin',
            'admin_id' => 'ADM001',
            'phone'    => '081234567890',
            'password' => Hash::make('admin123'),
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
