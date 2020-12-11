<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionMenu extends Model
{
    protected $table = 'opcionmenu';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'icono', 'orden', 'link', 'grupomenu_id'];

    public function grupomenu()
    {
        return $this->belongsTo(GrupoMenu::class, 'grupomenu_id');
    }
    public function tipousuario()
    {
        return $this->belongsToMany(TipoUsuario::class, 'acceso', 'opcionmenu_id', 'tipousuario_id');
    }

    public static function getMenu()
    {
        $opcionmenu = new OpcionMenu();
        $opcion_tipousuario = $opcionmenu->getOpcionMenus();
        return $opcion_tipousuario;
    }


    public function getOpcionMenus()
    {
        $opcionmenu = OpcionMenu::whereHas('tipousuario', function ($query) {
            $query->where('tipousuario_id', session()->get('tipousuario_id'))->orderBy('orden');
        })->get()->toArray();

        return $opcionmenu;
    }


    public function getGrupoMenus()
    {
        $grupo = GrupoMenu::orderBy('orden')->get()->toArray();
        return $grupo;
    }
}
