<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{

    protected $table = 'piso';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function habitacion()
    {
        return $this->hasMany(Habitacion::class);
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
