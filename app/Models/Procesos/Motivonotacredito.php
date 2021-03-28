<?php

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motivonotacredito extends Model
{
    use SoftDeletes;
	protected $table = 'motivonotacredito';
	protected $dates = ['deleted_at'];

    /**
	 * Método para listar las cajas
	 */
	public function scopelistar($query, $nombre, $tipo)
	{
		return $query
			->where(function ($subquery) use ($nombre) {
				if (!is_null($nombre)) {
					$subquery->where('nombre', 'LIKE', '%' . $nombre . '%');
				}
			})
			->where(function ($subquery) use ($tipo) {
				if (!is_null($tipo)) {
					$subquery->where('tipo', 'LIKE', '%' . $tipo . '%');
				}
			})
			->orderBy('tipo', 'ASC')
			->orderBy('nombre', 'ASC');
	}
}
