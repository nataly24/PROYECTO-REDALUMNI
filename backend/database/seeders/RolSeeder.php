<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'Administrador',
                'descripcion' => 'Usuario con acceso completo al sistema'
            ],
            [
                'nombre_rol' => 'Colaborador',
                'descripcion' => 'Usuario con permisos para gestionar contenido'
            ],
            [
                'nombre_rol' => 'Exalumno',
                'descripcion' => 'Usuario egresado con acceso a ofertas laborales'
            ],
            [
                'nombre_rol' => 'Empresa',
                'descripcion' => 'Usuario empresa con capacidad para publicar ofertas'
            ]
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}