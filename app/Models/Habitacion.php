<?php

namespace App\Models;

use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Habitacion extends Model
{

    protected $table = 'habitacion';
    protected $primaryKey = 'id';
    protected $fillable = ['numero', 'situacion', 'piso_id', 'tipohabitacion_id'];


    public function piso()
    {
        return $this->belongsTo(Piso::class, 'piso_id');
    }
    public function tipohabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class, 'tipohabitacion_id');
    }
    public function movimiento()
    {
        return $this->hasMany(Movimiento::class, 'habitacion_id');
    }
    public function reserva()
    {
        return $this->hasMany(Reserva::class, 'habitacion_id');
    }

    public function scopelistar($query, $numero, $piso, $tipohabitacion)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
            ->where(function ($subquery) use ($piso) {
                if (!is_null($piso) && strlen($piso) > 0) {
                    $subquery->where('piso_id', $piso);
                }
            })
            ->where(function ($subquery) use ($tipohabitacion) {
                if (!is_null($tipohabitacion) && strlen($tipohabitacion) > 0) {
                    $subquery->where('tipohabitacion_id', $tipohabitacion);
                }
            })
			->orderBy('numero', 'DESC');
	}


}
