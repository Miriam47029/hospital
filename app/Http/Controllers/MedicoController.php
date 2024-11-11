<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Paciente;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    
    public function index()
{
    $medicos = Medico::with('pacientes:id,nombre')->get(); 
    $pacientes = Paciente::select('id', 'nombre')->get(); // Seleccionamos id y nombre

    return Inertia::render('Medicos/Index', [
        'medicos' => $medicos,
        'pacientes' => $pacientes,
    ]);
}

    

    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'especialidad' => 'required|max:80',
            'telefono' => 'required|max:50',
            'email' => 'required|max:80',
            'paciente_id' => 'required|numeric'
        ]);
        $medico = new Medico($request->input());
        $medico->save();
        return redirect('medicos');
    }

    
    public function show(Medico $medico)
    {
        //
    }

    
    public function edit(Medico $medico)
    {
        
    }

    
    public function update(Request $request, Medico $medico)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'especialidad' => 'required|max:80',
            'telefono' => 'required|max:50',
            'email' => 'required|max:80',
            'paciente_id' => 'required|numeric'
        ]);
        $medico->update($request->input());
        return redirect('medicos');
    }

   
    public function destroy(Medico $medico)
    {
        $medico->delete();
        return redirect('medicos');
    }
}
