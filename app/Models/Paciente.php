<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Paciente extends Model
{
    use HasFactory;
    
    protected $fillable = ['nombre', 'apellidos', 'fecha_nacimiento', 'image', 'direccion', 'telefono', 'correo'];
    
    public function medicos(): BelongsToMany
    {
        return $this->belongsToMany(Medico::class, 'paciente_medico'); // Especifica la tabla pivote aquí
    }
}
