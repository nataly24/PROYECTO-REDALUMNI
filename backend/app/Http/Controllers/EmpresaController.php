<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::with('usuario')->get();
        return response()->json($empresas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuario,correo_electronico',
            'contrasena' => 'required|min:8',
            'nombre_empresa' => 'required|string',
            'nit' => 'required|string|unique:empresa,nit',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'descripcion' => 'required|string',
            'sitio_web' => 'nullable|url',
        ]);

        DB::beginTransaction();

        try {
            // Crear usuario
            $usuario = Usuario::create([
                'correo_electronico' => $request->correo_electronico,
                'contrasena' => Hash::make($request->contrasena),
                'estado_cuenta' => 'pendiente',
            ]);

            // Asignar rol de empresa
            $rolEmpresa = Rol::where('nombre_rol', 'Empresa')->first();
            $usuario->roles()->attach($rolEmpresa);

            // Crear empresa
            $empresa = Empresa::create([
                'id_usuario' => $usuario->id_usuario,
                'nombre_empresa' => $request->nombre_empresa,
                'nit' => $request->nit,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'descripcion' => $request->descripcion,
                'logo' => $request->logo ?? null,
                'sitio_web' => $request->sitio_web,
                'estado' => 'pendiente',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Empresa registrada correctamente',
                'empresa' => $empresa->load('usuario')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $empresa = Empresa::with(['usuario', 'ofertasLaborales'])->findOrFail($id);
        return response()->json($empresa);
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre_empresa' => 'string',
            'nit' => 'string|unique:empresa,nit,'.$id.',id_empresa',
            'direccion' => 'string',
            'telefono' => 'string',
            'descripcion' => 'string',
            'sitio_web' => 'nullable|url',
            'estado' => 'in:pendiente,aprobado,rechazado',
        ]);

        $empresa->update($request->only([
            'nombre_empresa', 'nit', 'direccion', 'telefono', 
            'descripcion', 'logo', 'sitio_web', 'estado'
        ]));

        return response()->json([
            'message' => 'Empresa actualizada correctamente',
            'empresa' => $empresa->load('usuario')
        ]);
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Eliminar empresa
            $empresa->delete();
            
            // Eliminar usuario
            $usuario = $empresa->usuario;
            $usuario->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Empresa eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}