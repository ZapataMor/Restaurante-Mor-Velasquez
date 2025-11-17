<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['admin', 'mesero', 'recepcionista', 'chef']),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            // 'email_verified_at' => now(), // ❌ quitar porque NO existe en la tabla
            'password' => static::$password ??= Hash::make('password'),
            'active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            // 'email_verified_at' => null, // ❌ también sin usar
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'name' => $this->faker->name() . ' (admin)',
        ]);
    }

    public function receptionist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'recepcionista',
            'name' => $this->faker->name() . ' (recepcionista)',
        ]);
    }

    public function waiter(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'mesero',
            'name' => $this->faker->name() . ' (mesero)',
        ]);
    }

    public function chef(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'chef',
            'name' => $this->faker->name() . ' (chef)',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}
