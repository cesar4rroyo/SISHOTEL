<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimiento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fechaingreso',
        'fechasalida',
        'dias',
        'total',
        'preciohabitacion',
        'situacion',
        'habitacion_id',
        'reserva_id',
        'persona_id',
        'usuario_id'
    ];
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
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
    public function comprobante()
    {
        return $this->hasMany(Comprobante::class, 'movimiento_id');
    }
    public function detalleComprobante()
    {
        return $this->hasMany(DetalleComprobante::class, 'movimiento_id');
    }
}
