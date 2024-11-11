<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'especialidad', 'telefono', 'email', 'paciente_id'];


    public function pacientes(): BelongsToMany
    {
        return $this->belongsToMany(Paciente::class, 'paciente_medico'); // Tabla pivote
    }
    
}
