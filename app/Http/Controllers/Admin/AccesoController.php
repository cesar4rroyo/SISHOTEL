<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GrupoMenu;
use App\Models\OpcionMenu;
use App\Models\TipoUsuario;

class AccesoController extends Controller
{

    public function index()
    {
        $tipousuarios = TipoUsuario::orderBy('id')
            ->pluck('nombre', 'id')
            ->toArray();
        $grupomenus = GrupoMenu::with('opcionmenu')
            ->get()
            ->toArray();
        $opcionmenus = OpcionMenu::with('tipousuario')
            ->get()
            ->pluck('tipousuario', 'id')
            ->toArray();
        $opciones = OpcionMenu::with('tipousuario')
            ->get()
            ->toArray();
        return view('admin.acceso.index', compact('opciones', 'tipousuarios', 'grupomenus', 'opcionmenus'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $tipousuarios = new TipoUsuario();
            if ($request->input('estado') == 1) {
                $tipousuarios->find($request->input('tipousuario_id'))->opcionmenu()->attach($request->input('opcionmenu_id'));
                return response()->json(['respuesta' => 'El acceso se asigno correctamente']);
            } else {
                $tipousuarios->find($request->input('tipousuario_id'))->opcionmenu()->detach($request->input('opcionmenu_id'));
                return response()->json(['respuesta' => 'El acceso se elimino correctamente']);
            }
        } else {
            abort(404);
        }
    }
}

