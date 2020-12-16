<?php

namespace App\Http\Middleware;

use Closure;

class PermisoAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->permiso() == 1) {
            return $next($request);
        } else if ($this->permiso() == 2) {
            return redirect('/')->with('warning', 'No cuentas con todos los provilegios de Super Administrador, algunas opciones estan restringidas.');
        } else {
            return redirect('/')->with('warning', 'Algunas opciones estan restringidas, ya que no cuentas con los permisos necesarios');
        }
    }

    private function permiso()
    {
        return session()->get('tipousuario_id');
    }
}
