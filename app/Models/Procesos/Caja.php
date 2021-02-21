<?php

namespace App\Models\Procesos;

use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha',
        'tipo',
        'numero',
        'total',
        'comentario',
        'situacion',
        'concepto_id',
        'persona_id',
        'movimiento_id',
        'usuario_id',
        'efectivo',
        'deposito',
        'tarjeta',
        'tipotarjeta',
        'modalidadpago'
    ];
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function detallecaja()
    {
        return $this->hasMany(DetalleCaja::class, 'caja_id');
    }
}
