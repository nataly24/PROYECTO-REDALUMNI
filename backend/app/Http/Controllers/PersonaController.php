<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::with('usuario')->get();
        return response()->json($personas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'primer_nombre' => 'required|string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'genero' => 'nullable|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => 'nullable|date',
            'direccion_domicilio' => 'nullable|string|max:255',
            'celular_contacto' => 'nullable|string|max:20',
        ]);

        $persona = Persona::create($request->all());

        return response()->json([
            'message' => 'Persona creada correctamente',
            'persona' => $persona
        ], 201);
    }

    public function show($id)
    {
        $persona = Persona::with('usuario', 'exalumno')->findOrFail($id);
        return response()->json($persona);
    }

    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $request->validate([
            'primer_nombre' => 'string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'genero' => 'nullable|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => 'nullable|date',
            'direccion_domicilio' => 'nullable|string|max:255',
            'celular_contacto' => 'nullable|string|max:20',
        ]);

        $persona->update($request->all());

        return response()->json([
            'message' => 'Persona actualizada correctamente',
            'persona' => $persona
        ]);
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return response()->json([
            'message' => 'Persona eliminada correctamente'
        ]);
    }
}