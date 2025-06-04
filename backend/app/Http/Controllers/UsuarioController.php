<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('roles')->get();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuario',
            'contrasena' => 'required|min:6',
            'rol' => 'required|string',
            'primer_nombre' => 'required_if:rol,Exalumno|string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'required_if:rol,Exalumno|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'genero' => 'required_if:rol,Exalumno|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => 'required_if:rol,Exalumno|date',
            'direccion_domicilio' => 'nullable|string|max:255',
            'celular_contacto' => 'nullable|string|max:20'
        ]);

        DB::beginTransaction();

        try {
            $usuario = Usuario::create([
                'correo_electronico' => $request->correo_electronico,
                'contrasena' => Hash::make($request->contrasena),
                'estado_cuenta' => 'activo'
            ]);

            $rol = Rol::where('nombre_rol', $request->rol)->first();
            if (!$rol) {
                throw new \Exception('El rol especificado no existe');
            }
            
            $usuario->roles()->attach($rol->id_rol);

            if ($request->rol === 'Exalumno') {
                $persona = Persona::create([
                    'id_usuario' => $usuario->id_usuario,
                    'primer_nombre' => $request->primer_nombre,
                    'segundo_nombre' => $request->segundo_nombre,
                    'primer_apellido' => $request->primer_apellido,
                    'segundo_apellido' => $request->segundo_apellido,
                    'genero' => $request->genero,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'direccion_domicilio' => $request->direccion_domicilio,
                    'celular_contacto' => $request->celular_contacto
                ]);
                
                $usuario->load('persona');
            }

            DB::commit();

            return response()->json([
                'mensaje' => 'Usuario creado exitosamente',
                'usuario' => $usuario->load('roles')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'mensaje' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}