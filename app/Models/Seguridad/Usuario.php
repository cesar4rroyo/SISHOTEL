<?php

namespace App\Models\Seguridad;

use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use App\Models\TipoUsuario;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Usuario extends Authenticatable
{
    protected $remember_token = 'false';
    protected $table = 'usuario';
    protected $fillable = [
        'login',
        'password',
        'persona_id',
        'tipousuario_id'
    ];

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

    //funciones para el manteniemto

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function tipousuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipousuario_id');
    }
    public function setSession($tipousuario)
    {
        if (count($tipousuario) == 1) {
            Session::put([
                'tipousuario_id' => $tipousuario[0]['id'],
                'tipousuario_nombre' => $tipousuario[0]['nombre'],
                'usuario' => $this->login,
                'accesos' => $this->tipousuario()->with('opcionmenu')->get()->toArray()[0]['opcionmenu'] ?? null,
                'usuario_id' => $this->id,
                'persona' => $this->persona()->get()->toArray()[0] ?? null,
                'roles' => $this->persona()->with('roles')->get()->toArray()[0]['roles'] ?? null,
            ]);
        }
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public static function getPersonasUsuarios()
    {
        $id_rolUsuario = '1';
        $personas = Persona::whereHas('roles', function ($query) use ($id_rolUsuario) {
            $query->where('rol.id', '=', $id_rolUsuario);
        })->get();
        return $personas;
    }
}
