<?php

namespace App\Models;

use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Procesos\DetalleMovimiento;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'precioventa',
        'preciocompra',
        'categoria_id',
        'unidad_id'
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
    public function detalleComprobante()
    {
        return $this->hasMany(DetalleComprobante::class, 'producto_id');
    }
    public function detalleCaja()
    {
        return $this->hasMany(DetalleCaja::class, 'producto_id');
    }
    public function detalleMovimiento()
    {
        return $this->hasMany(DetalleMovimiento::class, 'producto_id');
    }
}
