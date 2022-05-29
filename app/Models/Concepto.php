<?php

namespace App\Models;

use App\Models\Procesos\Caja;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{

    protected $table = 'concepto';

    protected $primaryKey = 'id';

    protected $fillable = ['nombre', 'tipo'];

    public function caja()
    {
        return $this->hasMany(Caja::class, 'concepto_id');
    }

    public function scopelistar($query, $nombre, $tipo)
	{
		return $query
            ->where(function ($subquery) use ($nombre) {
				if (!is_null($nombre) && strlen($nombre) > 0) {
					$subquery->where('nombre', 'LIKE', '%'.$nombre.'%');
				}
			})
            ->where(function ($subquery) use ($tipo) {
                if (!is_null($tipo) && strlen($tipo) > 0) {
                    $subquery->where('tipo', $tipo);
                }
            })
			->orderBy('nombre', 'DESC');
	}
}
