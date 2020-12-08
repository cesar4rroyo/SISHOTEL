<?php

namespace App\Models\Seguridad;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

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
}
