<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{

    protected $table = 'tipohabitacion';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'precio'];

    public function habitacion()
    {
        return $this->hasMany(Habitacion::class, 'tipohabitacion_id');
    }

    public function scopelistar($query, $nombre)
	{
		return $query
            ->where(function ($subquery) use ($nombre) {
				if (!is_null($nombre) && strlen($nombre) > 0) {
					$subquery->where('nombre', 'LIKE', '%'.$nombre.'%');
				}
			})
			->orderBy('nombre', 'DESC');
	}
}
