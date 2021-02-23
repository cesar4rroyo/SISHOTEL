<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use SoftDeletes;
    protected $table = 'movimiento';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'fechaingreso',
        'fechasalida',
        'dias',
        'total',
        'preciohabitacion',
        'situacion',
        'habitacion_id',
        'reserva_id',
        'usuario_id',
        'tarjeta_id',
        'comentario',
        'descuento',
        'late_checkout',
        'early_checkin',
        'day_use',
        'efectivo',
        'deposito',
        'tarjeta',
        'tipotarjeta',
        'modalidadpago',
        'fechadeposito',
        'nrooperacion',
        'nombrebanco',
        'urlimagen'
    ];
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
    // public function persona()
    // {
    //     return $this->belongsTo(Persona::class, 'persona_id');
    // }
    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class, 'tarjeta_id');
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
    public function pasajero()
    {
        return $this->hasMany(Pasajero::class, 'movimiento_id');
    }
    public function detallemovimiento()
    {
        return $this->hasMany(DetalleMovimiento::class, 'movimiento_id');
    }

    public function caja()
    {
        return $this->hasMany(Caja::class, 'movimiento_id');
    }

    public function producto()
    {
        return $this
            ->belongsToMany(Producto::class, 'detallemovimiento')
            ->withPivot(['cantidad', 'preciocompra', 'precioventa', 'fecha']);
    }
}
