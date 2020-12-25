<?php

namespace App\Models\Procesos;

use App\Models\Producto;
use App\Models\Servicios;
use Illuminate\Database\Eloquent\Model;

class DetalleComprobante extends Model
{
    protected $table = 'detallecomprobante';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cantidad',
        'preciocompra',
        'precioventa',
        'comentario',
        'servicio_id',
        'producto_id',
        'comprobante_id'

    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function servicios()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class, 'comprobante_id');
    }
}
