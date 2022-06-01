<?php

namespace App\Models;

use App\Models\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{

    protected $table = 'tipousuario';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'tipousuario_id');
    }
    public function opcionmenu()
    {
        return $this->belongsToMany(OpcionMenu::class, 'acceso', 'tipousuario_id', 'opcionmenu_id');
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
