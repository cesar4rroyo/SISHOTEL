<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $fillable = [
        'nombres',
        'apellidos',
        'razonsocial',
        'ruc',
        'dni',
        'direccion',
        'sexo',
        'fechanacimiento',
        'telefono',
        'observacion',
        'nacionalidad_id'
    ];
    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class, 'nacionalidad_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rolpersona');
    }
}
