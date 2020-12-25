<?php

namespace App\Models\Procesos;

use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha',
        'observacion',
        'situacion',
        'persona_id',
        'usuario_id',
        'habitacion_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function movimiento()
    {
        return $this->hasMany(Movimiento::class, 'reserva_id');
    }
}
