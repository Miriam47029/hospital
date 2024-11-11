<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date(),
            'image' => 'img/example.jpg', // Ruta de imagen de ejemplo
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->numerify('##########'),
            'correo' => $this->faker->unique()->safeEmail()
        ];
    }
}
