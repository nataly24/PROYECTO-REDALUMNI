<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Manejar una solicitud de inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
            'contrasena' => 'required',
        ]);

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            throw ValidationException::withMessages([
                'correo_electronico' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        if ($usuario->estado_cuenta !== 'activo') {
            throw ValidationException::withMessages([
                'correo_electronico' => ['Tu cuenta no está activa. Por favor, contacta al administrador.'],
            ]);
        }

        // Obtener roles del usuario
        $roles = $usuario->roles()->pluck('nombre_rol')->toArray();

        // Generar token
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $usuario->id_usuario,
                'correo_electronico' => $usuario->correo_electronico,
            ],
            'roles' => $roles,
        ]);
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}