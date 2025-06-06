<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testDatabase()
    {
        try {
            // Probar conexión a la base de datos
            DB::connection()->getPdo();
            
            // Contar usuarios y roles
            $userCount = User::count();
            $roleCount = Role::count();
            $roles = Role::all();
            
            return response()->json([
                'connection' => 'Conexión exitosa a la base de datos',
                'users' => $userCount,
                'roles' => $roleCount,
                'role_list' => $roles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'connection' => 'Error de conexión a la base de datos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
