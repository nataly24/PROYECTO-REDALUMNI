<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getStats()
    {
        try {
            $counts = [
                'usuario' => DB::table('usuario')->count(),
                'empresa' => DB::table('empresa')->count(),
                'oferta_laboral' => DB::table('oferta_laboral')->count(),
                'exalumno' => DB::table('exalumno')->count()
            ];

            return response()->json([
                "totalUsuarios" => $counts['usuario'],
                "empresasRegistradas" => $counts['empresa'],
                "ofertasLaborales" => $counts['oferta_laboral'],
                "exalumnosRegistrados" => $counts['exalumno'],
                "notificaciones" => 7
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje" => "Error al obtener estadísticas",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}