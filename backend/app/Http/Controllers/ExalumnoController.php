<?php

namespace App\Http\Controllers;

use App\Models\Exalumno;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ExalumnoController extends Controller
{
    public function index()
    {
        $exalumnos = Exalumno::with('persona.usuario')->get();
        return response()->json($exalumnos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuario,correo_electronico',
            'contrasena' => 'required|min:8',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'carnet' => 'required|string|unique:exalumno,carnet',
            'estado_academico' => 'required|in:Egresado,Graduado',
            'fecha_ingreso' => 'required|date',
            'fecha_egreso' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Crear usuario
            $usuario = Usuario::create([
                'correo_electronico' => $request->correo_electronico,
                'contrasena' => Hash::make($request->contrasena),
                'estado_cuenta' => 'pendiente',
            ]);

            // Asignar rol de exalumno
            $rolExalumno = Rol::where('nombre_rol', 'Exalumno')->first();
            $usuario->roles()->attach($rolExalumno);

            // Crear persona
            $persona = Persona::create([
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'genero' => $request->genero,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'foto_perfil' => $request->foto_perfil ?? null,
            ]);

            // Crear exalumno
            $exalumno = Exalumno::create([
                'id_persona' => $persona->id_persona,
                'carnet' => $request->carnet,
                'estado_academico' => $request->estado_academico,
                'fecha_ingreso' => $request->fecha_ingreso,
                'fecha_egreso' => $request->fecha_egreso,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Exalumno registrado correctamente',
                'exalumno' => $exalumno->load('persona.usuario')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar exalumno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $exalumno = Exalumno::with([
            'persona.usuario', 
            'formacionAcademica', 
            'experienciaLaboral'
        ])->findOrFail($id);
        
        return response()->json($exalumno);
    }

    public function update(Request $request, $id)
    {
        $exalumno = Exalumno::findOrFail($id);

        $request->validate([
            'carnet' => 'string|unique:exalumno,carnet,'.$id.',id_exalumno',
            'estado_academico' => 'in:Egresado,Graduado',
            'fecha_ingreso' => 'date',
            'fecha_egreso' => 'date',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar exalumno
            $exalumno->update($request->only([
                'carnet', 'estado_academico', 'fecha_ingreso', 'fecha_egreso'
            ]));

            // Actualizar persona
            if ($request->has(['nombre', 'apellido', 'fecha_nacimiento', 'genero', 'telefono', 'direccion', 'foto_perfil'])) {
                $exalumno->persona->update($request->only([
                    'nombre', 'apellido', 'fecha_nacimiento', 'genero', 'telefono', 'direccion', 'foto_perfil'
                ]));
            }

            DB::commit();

            return response()->json([
                'message' => 'Exalumno actualizado correctamente',
                'exalumno' => $exalumno->load('persona.usuario')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar exalumno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $exalumno = Exalumno::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Eliminar exalumno
            $exalumno->delete();
            
            // Eliminar persona
            $persona = $exalumno->persona;
            $persona->delete();
            
            // Eliminar usuario
            $usuario = $persona->usuario;
            $usuario->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Exalumno eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar exalumno',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}