<?php

namespace App\Models\Procesos;

use App\Models\Producto;
use App\Models\Servicios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Detallenotacredito extends Model
{
    use SoftDeletes;
    protected $table = 'detallenotacredito';
    protected $dates = ['deleted_at'];

    public function producto()
	{
		return $this->belongsTo(Producto::class, 'producto_id');
	}

    public function servicio()
	{
		return $this->belongsTo(Servicios::class, 'servicio_id');
	}
	
    public function notacredito()
	{
		return $this->belongsTo(NotaCredito::class, 'movimiento_id');
	}
}
