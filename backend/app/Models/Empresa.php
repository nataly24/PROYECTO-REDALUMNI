<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'id_usuario',
        'nombre_empresa',
        'nit',
        'direccion',
        'telefono',
        'descripcion',
        'logo',
        'sitio_web',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function ofertasLaborales()
    {
        return $this->hasMany(OfertaLaboral::class, 'id_empresa');
    }
}