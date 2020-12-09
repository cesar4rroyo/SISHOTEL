<?php

namespace App\Http\Controllers\Seguridad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index()
    {
        return view('seguridad.index');
    }
    public function username()
    {
        return 'login';
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/auth/login');
    }

    protected function authenticated(Request $request, $user)
    {
        $tipousuario = $user->tipousuario()->get();
        if ($tipousuario->isNotEmpty()) {
            $user->setSession($tipousuario->toArray());
        } else {
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('auth/login')->withErrors(['error' => 'Este usuario no tiene un perfil activo']);
        }
        // dd($tipousuario->toArray());
    }
}
