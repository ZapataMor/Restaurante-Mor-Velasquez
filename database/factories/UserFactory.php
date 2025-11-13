<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['Administrador', 'Recepcionista', 'Mesero', 'Chef']),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // States para roles específicos
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Administrador',
            'name' => $this->faker->name() . ' (Admin)',
        ]);
    }

    public function receptionist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Recepcionista',
            'name' => $this->faker->name() . ' (Recepcionista)',
        ]);
    }

    public function waiter(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Mesero',
            'name' => $this->faker->name() . ' (Mesero)',
        ]);
    }

    public function chef(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Chef',
            'name' => $this->faker->name() . ' (Chef)',
        ]);
    }

    // State para usuario inactivo
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}