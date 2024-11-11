<?php

namespace Database\Seeders;

use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear primero los pacientes para evitar errores de integridad referencial
        Paciente::factory(10)->create();
        Medico::factory(10)->create();
        
        // Asignar médicos a pacientes
        for ($i = 1; $i <= 10; $i++) { 
            $paciente = Paciente::find($i);
            $paciente->medicos()->attach(random_int(1, 10));
        }
    }
}
