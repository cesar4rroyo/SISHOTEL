<?php

namespace App\Models\Procesos;

use App\Models\Producto;
use App\Models\Servicios;
use Illuminate\Database\Eloquent\Model;

class DetalleCaja extends Model
{
    protected $table = 'detallecaja';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cantidad',
        'preciocompra',
        'precioventa',
        'comentario',
        'caja_id',
        'servicio_id',
        'producto_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function servicios()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }
}
