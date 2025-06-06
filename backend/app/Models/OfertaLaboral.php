<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    use HasFactory;

    protected $table = 'oferta_laboral';
    protected $primaryKey = 'id_oferta';

    protected $fillable = [
        'id_empresa',
        'titulo',
        'descripcion',
        'requisitos',
        'salario',
        'ubicacion',
        'tipo_contrato',
        'fecha_publicacion',
        'fecha_cierre',
        'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function postulaciones()
    {
        return $this->hasMany(PostulacionOferta::class, 'id_oferta');
    }
}