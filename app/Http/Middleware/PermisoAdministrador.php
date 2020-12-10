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
        if ($this->permiso()) {
            return $next($request);
        } else {
            return redirect('/')->with('warning', 'No tiene permiso para ingresar');
        }
    }

    private function permiso()
    {
        return session()->get('tipousuario_id') == 1;
    }
}
