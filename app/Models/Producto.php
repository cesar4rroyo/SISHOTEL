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


    public function scopelistar($query, $nombre, $categoria, $unidad)
	{
		return $query
            ->where(function ($subquery) use ($nombre) {
				if (!is_null($nombre) && strlen($nombre) > 0) {
					$subquery->where('nombre', 'LIKE', '%'.$nombre.'%');
				}
			})
            ->where(function ($subquery) use ($categoria) {
                if (!is_null($categoria) && strlen($categoria) > 0) {
                    $subquery->where('categoria_id', $categoria);
                }
            })
            ->where(function ($subquery) use ($unidad) {
                if (!is_null($unidad) && strlen($unidad) > 0) {
                    $subquery->where('unidad_id', $unidad);
                }
            })
			->orderBy('nombre', 'DESC');
	}


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
