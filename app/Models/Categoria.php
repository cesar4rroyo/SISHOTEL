<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function producto()
    {
        return $this->hasMany(Producto::class);
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
