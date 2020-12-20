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

    //obtener las opciones de menu que le corresponden al tipodeusuario que esta logueado
    public function getOpcionMenus()
    {
        $grupoWithOpciones = GrupoMenu::with([
            'opcionmenu' => function ($query) {
                $query->whereHas('tipousuario', function ($q) {
                    $q->where('tipousuario_id', session()->get('tipousuario_id'))->orderBy('orden');
                });
            }
        ])->get()->toArray();

        return $grupoWithOpciones;
    }


    public function getGrupoMenus()
    {
        $grupo = GrupoMenu::orderBy('orden')->get()->toArray();
        return $grupo;
    }
}
