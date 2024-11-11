<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'especialidad' => $this->faker->randomElement(['Cardiología', 'Neurología', 'Pediatría', 'Dermatología', 'Oncología']),
            'telefono' => $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'paciente_id' => $this->faker->numberBetween(1, 10),
        ];
        
    }
}
