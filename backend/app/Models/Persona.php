<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';
    protected $primaryKey = 'id_persona';

    protected $fillable = [
        'id_usuario',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'genero',
        'fecha_nacimiento',
        'direccion_domicilio',
        'celular_contacto'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function exalumno()
    {
        return $this->hasOne(Exalumno::class, 'id_persona');
    }

    public function getNombreCompletoAttribute()
    {
        $nombreCompleto = $this->primer_nombre;
        
        if ($this->segundo_nombre) {
            $nombreCompleto .= ' ' . $this->segundo_nombre;
        }
        
        $nombreCompleto .= ' ' . $this->primer_apellido;
        
        if ($this->segundo_apellido) {
            $nombreCompleto .= ' ' . $this->segundo_apellido;
        }
        
        return $nombreCompleto;
    }
}