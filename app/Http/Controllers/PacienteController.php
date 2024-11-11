<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Medico;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    public function index()
    {
        return Inertia::render('Pacientes/Index', [
            'pacientes' => Paciente::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Pacientes/Create',[
            'pacientes' => Medico::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'apellidos' => 'required|max:80',
            'nombre' => 'required|max:80',
            'fecha_nacimiento' => 'required|max:80',
            'image' => 'required|file|mimes:png,jpg,gif',
            'direccion' => 'required|max:80',
            'telefono' => 'required|max:50',
            'correo' => 'required|max:80',
        ]);
        $paciente = Paciente::create($request->all());
        if ($request -> hasFile('image')) {
            $imgName = microtime(true).'.'.$request->file('image')
            ->getClienteOriginalExtension();
            $request->file('image')->storeAs('public/img',$imgName);
            $paciente->image = '/img/'.$imgName;
            $paciente->save();
        }
        return redirect('pacientes/Create')->with('success','Paciente creado');
    }

    public function show(Paciente $paciente)
    {
        return Inertia::render('Pacientes/Show', [
            'paciente' => $paciente,
            'medicos' => $paciente->medicos, // Pasar la relación a la vista
        ]);
    }

    public function edit(Paciente $paciente)
{
    $medicos = Medico::select('id', 'nombre')->get()->toArray();
    $pacienteOfMedico = $paciente->medicos->pluck('id')->toArray();

    return Inertia::render('Pacientes/Edit', [
        'paciente' => $paciente->toArray(),
        'medicos' => $medicos,
        'pacienteOfMedico' => $pacienteOfMedico,
    ]);
}


    
    public function update(Request $request, Paciente $paciente)
    {
        //
    }

    public function destroy(Paciente $paciente)
    {
        Medico::where('paciente_id', $paciente->id)->delete();
        $paciente->delete();
        return redirect('pacientes')->with('success', 'Paciente Eliminado');
    }
}
