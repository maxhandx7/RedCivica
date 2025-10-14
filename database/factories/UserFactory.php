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
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'tipo_documento' => $this->faker->randomElement(['cc', 'ce', 'rut', 'ppt']),
            'cedula' => $this->faker->unique()->numerify('##########'), // 10 dígitos para cédula
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'fecha_expedicion' => function (array $attributes) {
                $fechaNacimiento = new DateTime($attributes['fecha_nacimiento']);
                $fechaMinimaExpedicion = (clone $fechaNacimiento)->modify('+18 years');
                return $this->faker->dateTimeBetween($fechaMinimaExpedicion, 'now')->format('Y-m-d');
            },
            'telefono' => $this->faker->optional()->phoneNumber(),
            'direccion' => $this->faker->optional()->streetAddress(),
            'departamento' => $this->faker->optional()->state(),
            'ciudad' => $this->faker->optional()->city(),
            'barrio' => $this->faker->optional()->citySuffix(),
            'mesa' => $this->faker->optional()->bothify('?##'), // Ejemplo: A12, B05, etc.
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'parent_id' => null, // Por defecto sin padre/referidor
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withReferrer()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => \App\Models\User::factory(),
            ];
        });
    }
}
