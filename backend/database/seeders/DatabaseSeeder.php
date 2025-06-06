<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insertar roles
        DB::table('rol')->insert([
            ['nombre_rol' => 'Administrador', 'descripcion' => 'Usuario con acceso completo al sistema'],
            ['nombre_rol' => 'Colaborador', 'descripcion' => 'Usuario con permisos para gestionar contenido'],
            ['nombre_rol' => 'Exalumno', 'descripcion' => 'Usuario egresado con acceso a ofertas laborales'],
            ['nombre_rol' => 'Empresa', 'descripcion' => 'Usuario empresa con capacidad para publicar ofertas'],
        ]);

        // Insertar usuarios
        DB::table('usuario')->insert([
            // Administrador
            [
                'id_usuario' => 1,
                'correo_electronico' => 'laura.quispe.redalumni@admin.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Colaborador 1
            [
                'id_usuario' => 2,
                'correo_electronico' => 'vidal.rojas.redalumni@colaborador.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Colaborador 2
            [
                'id_usuario' => 3,
                'correo_electronico' => 'laura.tellez.redalumni@colaborador.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Exalumno 1
            [
                'id_usuario' => 4,
                'correo_electronico' => 'carlos.mamani@redalumni.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Exalumno 2
            [
                'id_usuario' => 5,
                'correo_electronico' => 'maria.gutierrez@redalumni.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Empresa 1: Lafar
            [
                'id_usuario' => 6,
                'correo_electronico' => 'rrhh@lafar.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
            // Empresa 2: Cofar
            [
                'id_usuario' => 7,
                'correo_electronico' => 'rrhh@cofar.com',
                'contrasena' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'estado_cuenta' => 'activo'
            ],
        ]);

        // Insertar relaciones rol_usuario
        $roles = DB::table('rol')->get();
        
        // Administrador
        DB::table('rol_usuario')->insert([
            'id_usuario' => 1,
            'id_rol' => $roles->where('nombre_rol', 'Administrador')->first()->id_rol
        ]);
        
        // Colaboradores
        DB::table('rol_usuario')->insert([
            [
                'id_usuario' => 2,
                'id_rol' => $roles->where('nombre_rol', 'Colaborador')->first()->id_rol
            ],
            [
                'id_usuario' => 3,
                'id_rol' => $roles->where('nombre_rol', 'Colaborador')->first()->id_rol
            ]
        ]);
        
        // Exalumnos
        DB::table('rol_usuario')->insert([
            [
                'id_usuario' => 4,
                'id_rol' => $roles->where('nombre_rol', 'Exalumno')->first()->id_rol
            ],
            [
                'id_usuario' => 5,
                'id_rol' => $roles->where('nombre_rol', 'Exalumno')->first()->id_rol
            ]
        ]);
        
        // Empresas
        DB::table('rol_usuario')->insert([
            [
                'id_usuario' => 6,
                'id_rol' => $roles->where('nombre_rol', 'Empresa')->first()->id_rol
            ],
            [
                'id_usuario' => 7,
                'id_rol' => $roles->where('nombre_rol', 'Empresa')->first()->id_rol
            ]
        ]);

        // Insertar datos de personas
        DB::table('persona')->insert([
            // Administrador
            [
                'id_usuario' => 1,
                'primer_nombre' => 'Laura',
                'segundo_nombre' => 'Natalia',
                'primer_apellido' => 'Quispe',
                'segundo_apellido' => 'Pacari',
                'genero' => 'Femenino',
                'fecha_nacimiento' => '2003-09-22',
                'direccion_domicilio' => 'Zona Sur, Calle 1',
                'celular_contacto' => '777000001'
            ],
            // Colaborador 1
            [
                'id_usuario' => 2,
                'primer_nombre' => 'Vidal',
                'segundo_nombre' => 'Moises',
                'primer_apellido' => 'Rojas',
                'segundo_apellido' => 'Alcon',
                'genero' => 'Masculino',
                'fecha_nacimiento' => '2001-09-12',
                'direccion_domicilio' => 'Zona Central',
                'celular_contacto' => '777000002'
            ],
            // Colaborador 2
            [
                'id_usuario' => 3,
                'primer_nombre' => 'Laura',
                'segundo_nombre' => 'Nathalia',
                'primer_apellido' => 'Quispe',
                'segundo_apellido' => 'Tellez',
                'genero' => 'Femenino',
                'fecha_nacimiento' => '2003-09-12',
                'direccion_domicilio' => 'Zona Villa Fátima',
                'celular_contacto' => '777000003'
            ],
            // Exalumno 1
            [
                'id_usuario' => 4,
                'primer_nombre' => 'Carlos',
                'segundo_nombre' => 'Eduardo',
                'primer_apellido' => 'Mamani',
                'segundo_apellido' => 'Condori',
                'genero' => 'Masculino',
                'fecha_nacimiento' => '1995-05-01',
                'direccion_domicilio' => 'Zona Villa Adela',
                'celular_contacto' => '777000004'
            ],
            // Exalumno 2
            [
                'id_usuario' => 5,
                'primer_nombre' => 'María',
                'segundo_nombre' => 'Elena',
                'primer_apellido' => 'Gutiérrez',
                'segundo_apellido' => 'López',
                'genero' => 'Femenino',
                'fecha_nacimiento' => '1994-09-09',
                'direccion_domicilio' => 'Zona Miraflores',
                'celular_contacto' => '777000005'
            ]
        ]);

        // Obtener IDs de personas para exalumnos
        $personaExalumno1 = DB::table('persona')->where('id_usuario', 4)->first();
        $personaExalumno2 = DB::table('persona')->where('id_usuario', 5)->first();

        // Insertar datos de exalumnos
        DB::table('exalumno')->insert([
            [
                'id_persona' => $personaExalumno1->id_persona,
                'ci' => '12345678',
                'codigo_carrera' => 'SIS-001',
                'carrera' => 'Ingeniería de Sistemas',
                'facultad' => 'Facultad de Ingeniería',
                'estado_academico' => 'Egresado'
            ],
            [
                'id_persona' => $personaExalumno2->id_persona,
                'ci' => '87654321',
                'codigo_carrera' => 'IND-002',
                'carrera' => 'Ingeniería Industrial',
                'facultad' => 'Facultad de Ingeniería',
                'estado_academico' => 'Egresado'
            ]
        ]);

        // Insertar datos de empresas
        DB::table('empresa')->insert([
            // Empresa 1: Lafar
            [
                'id_usuario' => 6,
                'nombre_empresa' => 'Lafar',
                'nit' => '123456789',
                'correo_empresa' => 'contacto@lafar.com',
                'tipo_empresa' => 'Farmacéutica',
                'telefono' => '22334455',
                'direccion_empresa' => 'Av. Principal #123, La Paz',
                'descripcion_empresa' => 'Laboratorios farmacéuticos con amplia gama de productos medicinales',
                'estado_empresa' => 'activa'
            ],
            // Empresa 2: Cofar
            [
                'id_usuario' => 7,
                'nombre_empresa' => 'Cofar',
                'nit' => '987654321',
                'correo_empresa' => 'contacto@cofar.com',
                'tipo_empresa' => 'Farmacéutica',
                'telefono' => '66778899',
                'direccion_empresa' => 'Calle Secundaria #456, La Paz',
                'descripcion_empresa' => 'Empresa farmacéutica líder en Bolivia con más de 30 años de experiencia',
                'estado_empresa' => 'activa'
            ]
        ]);
    }
}