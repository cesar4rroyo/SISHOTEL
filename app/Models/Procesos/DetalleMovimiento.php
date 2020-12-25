<?php

namespace App\Models\Procesos;

use App\Models\Producto;
use App\Models\Servicios;
use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    protected $table = 'detallemovimiento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cantidad',
        'preciocompra',
        'precioventa',
        'comentario',
        'fecha',
        'servicio_id',
        'producto_id',
        'movimiento_id'

    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function servicios()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
}
