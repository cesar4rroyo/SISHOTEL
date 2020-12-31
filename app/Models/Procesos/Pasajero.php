<?php

namespace App\Models\Procesos;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    protected $table = 'pasajero';
    protected $primaryKey = 'id';
    protected $fillable = [
        'movimiento_id',
        'persona_id'
    ];
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
