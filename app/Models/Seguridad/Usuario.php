<?php

namespace App\Models\Seguridad;

use App\Models\TipoUsuario;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
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
                'tipousuario_nombre' => $tipousuario[0]['nombre']
            ]);
        }


        // Session::put('tipousuario', $tipousuario);
    }
}
