<?php

namespace App\Models;

use App\Models\Procesos\Caja;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use App\Models\Seguridad\Usuario;
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
    //funciones para el mantenimiento

    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class, 'nacionalidad_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rolpersona');
    }

    public function usuario()
    {
        return $this->hasMany(Usuario::class);
    }

    //funciones para el proceso

    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }
    public function movimiento()
    {
        return $this->hasMany(Movimiento::class);
    }
    public function caja()
    {
        return $this->hasMany(Caja::class);
    }
}
