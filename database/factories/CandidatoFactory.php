<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatoFactory extends Factory
{
    public function definition()
    {
        $cargos = ['senador', 'representante', 'gobernador', 'alcalde'];
        $partidos = ['Partido Liberal', 'Partido Conservador', 'Cambio Radical', 'Polo Democrático', 'Centro Democrático'];
        
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'alias' => $this->faker->userName(),
            'cargo' => $this->faker->randomElement($cargos),
            'circunscripcion' => $this->faker->state(),
            'partido' => $this->faker->randomElement($partidos),
            'lema' => $this->faker->sentence(),
            'color_principal' => $this->faker->hexColor(),
            'biografia' => $this->faker->paragraphs(3, true),
            'fecha_eleccion' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'activo' => $this->faker->boolean(80),
            'orden' => $this->faker->numberBetween(1, 100),
        ];
    }
}