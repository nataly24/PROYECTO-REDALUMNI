<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'correo_electronico',
        'contrasena',
        'estado_cuenta',
        'fecha_registro'
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'id_usuario', 'id_rol');
    }

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id_usuario');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'id_usuario');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('nombre_rol', $role)->exists();
    }
}