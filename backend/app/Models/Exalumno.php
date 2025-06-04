<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exalumno extends Model
{
    use HasFactory;

    protected $table = 'exalumno';
    protected $primaryKey = 'id_exalumno';

    protected $fillable = [
        'id_persona',
        'carnet',
        'estado_academico',
        'fecha_ingreso',
        'fecha_egreso',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function formacionAcademica()
    {
        return $this->hasMany(FormacionAcademica::class, 'id_exalumno');
    }

    public function experienciaLaboral()
    {
        return $this->hasMany(ExperienciaLaboral::class, 'id_exalumno');
    }

    public function postulaciones()
    {
        return $this->hasMany(PostulacionOferta::class, 'id_exalumno');
    }
}