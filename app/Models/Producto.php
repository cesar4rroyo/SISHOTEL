<?php

namespace App\Models;

use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Mock;

class Producto extends Model
{
    use SoftDeletes;
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


    public function movimiento()
    {
        return $this
            ->belongsToMany(Movimiento::class, 'detallemovimiento')
            ->withPivot(['cantidad', 'preciocompra', 'precioventa', 'fecha']);
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