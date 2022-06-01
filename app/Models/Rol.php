<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{

    protected $table = 'rol';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->belongsToMany(Persona::class, 'rolpersona');
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
