<?php

namespace App\Http\Middleware;

use App\Models\OpcionMenu;
use Closure;
use Illuminate\Support\Facades\DB;

class AccesoPermisos
{

    public function handle($request, Closure $next)
    {
        $ruta = $request->path();
        $ruta_corta = explode('/', $ruta);
        $ruta_final = $ruta_corta[0] . "/" . $ruta_corta[1];
        if ($this->permiso($ruta_final)) {
            return $next($request);
        } else {
            return redirect('/')->with('warning', 'No cuentas con permisos para ingresar a esta seccion');
        }
    }

    private function permiso($ruta)
    {
        $opcion = OpcionMenu::where('link', '=', $ruta)->get()->toArray();
        $tipousuario_id = session()->get('tipousuario_id');
        $final = DB::table('acceso')
            ->where('opcionmenu_id', '=', $opcion[0]['id'])
            ->where('tipousuario_id', '=', $tipousuario_id)
            ->get()
            ->toArray();
        if (count($final) != 0) {
            return true;
        } else {
            return false;
        }
    }
}
