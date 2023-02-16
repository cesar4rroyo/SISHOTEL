<?php

namespace App\Models;

use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
use App\Models\Procesos\Reserva;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;
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
        'nacionalidad_id',
        'edad',
        'ciudad',
        'email'
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

    public function comprobante()
    {
        return $this->hasMany(Comprobante::class);
    }
    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }
    public function pasajero()
    {
        return $this->hasMany(Pasajero::class);
    }
    public function caja()
    {
        return $this->hasMany(Caja::class);
    }
    public static function getClientes()
    {
        $id_clientes = '2';
        $personas = Persona::whereHas('roles', function ($query) use ($id_clientes) {
            $query->where('rol.id', '=', $id_clientes);
        })->get()->toArray();
        return $personas;
    }
    public static function getClientesConRucDni()
    {
        $personas = Persona::getClientes();
        $data = [];
        foreach ($personas as $item) {
            $nombres = '';
            if ($item['ruc'] != '' && (!is_null($item['razonsocial'])) && $item['razonsocial'] != '-' && $item['razonsocial'] != '' && $item['ruc'] != '-') {
                $nombres = $item['razonsocial'];
            } else if ($item['nombres'] != '-' && !is_null($item['nombres'])) {
                $nombres = $item['nombres'] . ' ' . $item['apellidos'];
            }
            $data[] = [
                "id" => $item['id'],
                "nombres" => $nombres,
            ];
        }
        return $data;
    }
}