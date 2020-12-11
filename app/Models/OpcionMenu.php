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
        $menus = [];
        $opcionmenu = new OpcionMenu();
        $opcion_tipousuario = $opcionmenu->getOpcionMenus();
        $grupos = $opcionmenu->getGrupoMenus();

        // foreach ($grupos as $line) {
        //     $items = [];
        //     foreach ($opcion_tipousuario as $opcion) {
        //         if ($line["id"] == $opcion["grupomenu_id"]) {
        //             $items = [array_merge($line, ['opciones' => $opcion])];
        //             $menus = array_merge($menus, $items);
        //         }
        //         $items = [];
        //     }

        //     $menus = array_merge($menus, $items);
        // }
        return $opcion_tipousuario;
    }


    public function getOpcionMenus()
    {
        $opcionmenu = OpcionMenu::whereHas('tipousuario', function ($query) {
            $query->where('tipousuario_id', session()->get('tipousuario_id'))->orderBy('orden');
        })->get()->toArray();

        return $opcionmenu;
    }
    public function getPadres($padres, $line)
    {
        $padres = [];
        foreach ($padres as $line1) {
            if ($line['id'] == $line1['opcionmenu_id']) {
                $padres = array_merge($padres, [array_merge($line1, ['opciones' => $this->getPadres($padres, $line1)])]);
            }
        }
    }

    public function getGrupoMenus()
    {
        $grupo = GrupoMenu::orderBy('orden')->get()->toArray();
        return $grupo;
    }
}
