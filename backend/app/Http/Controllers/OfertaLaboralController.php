<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use Illuminate\Http\Request;

class OfertaLaboralController extends Controller
{
    public function index()
    {
        $ofertas = OfertaLaboral::with('empresa')->where('estado', 'activa')->get();
        return response()->json($ofertas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'salario' => 'required|numeric',
            'ubicacion' => 'required|string',
            'tipo_contrato' => 'required|string',
            'fecha_cierre' => 'required|date|after:today',
        ]);

        $oferta = OfertaLaboral::create([
            'id_empresa' => $request->id_empresa,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'requisitos' => $request->requisitos,
            'salario' => $request->salario,
            'ubicacion' => $request->ubicacion,
            'tipo_contrato' => $request->tipo_contrato,
            'fecha_publicacion' => now(),
            'fecha_cierre' => $request->fecha_cierre,
            'estado' => 'activa',
        ]);

        return response()->json([
            'message' => 'Oferta laboral creada correctamente',
            'oferta' => $oferta->load('empresa')
        ], 201);
    }

    public function show($id)
    {
        $oferta = OfertaLaboral::with(['empresa', 'postulaciones.exalumno.persona'])->findOrFail($id);
        return response()->json($oferta);
    }

    public function update(Request $request, $id)
    {
        $oferta = OfertaLaboral::findOrFail($id);

        $request->validate([
            'titulo' => 'string',
            'descripcion' => 'string',
            'requisitos' => 'string',
            'salario' => 'numeric',
            'ubicacion' => 'string',
            'tipo_contrato' => 'string',
            'fecha_cierre' => 'date|after:today',
            'estado' => 'in:activa,cerrada,cancelada',
        ]);

        $oferta->update($request->only([
            'titulo', 'descripcion', 'requisitos', 'salario', 
            'ubicacion', 'tipo_contrato', 'fecha_cierre', 'estado'
        ]));

        return response()->json([
            'message' => 'Oferta laboral actualizada correctamente',
            'oferta' => $oferta->load('empresa')
        ]);
    }

    public function destroy($id)
    {
        $oferta = OfertaLaboral::findOrFail($id);
        $oferta->delete();

        return response()->json([
            'message' => 'Oferta laboral eliminada correctamente'
        ]);
    }

    public function ofertasEmpresa($idEmpresa)
    {
        $ofertas = OfertaLaboral::where('id_empresa', $idEmpresa)->get();
        return response()->json($ofertas);
    }
}