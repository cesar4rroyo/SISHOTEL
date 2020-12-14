<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateUsuario;
use App\Models\Persona;
use App\Models\Seguridad\Usuario;
use App\Models\TipoUsuario;

class UsuarioController extends Controller
{

    public function index()
    {
        $paginate_number = 10;
        $usuario =
            Usuario::with('persona', 'tipousuario')
            ->orderBy('id')
            ->paginate($paginate_number);
        return view('admin.usuario.index', compact('usuario'));
    }


    public function create()
    {
        $tipousuarios = TipoUsuario::with('usuario')->get();
        $personas = Usuario::getPersonasUsuarios();
        return view('admin.usuario.create', compact('tipousuarios', 'personas'));
    }


    public function store(ValidateUsuario $request)
    {
        $usuario = Usuario::create([
            'login' => $request->login,
            'password' => $request->password,
            'tipousuario_id' => $request->tipousuario,
            'persona_id' => $request->persona
        ]);
        return redirect()
            ->route('usuario')
            ->with('success', 'Agregado correctamente');
    }


    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuario.show', compact('usuario'));
    }


    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $tipousuarios = TipoUsuario::with('usuario')->get();
        $personas = Persona::with('usuario')->get();
        return view('admin.usuario.edit', compact('usuario', 'tipousuarios', 'personas'));
    }


    public function update(ValidateUsuario $request, $id)
    {
        $usuario = Usuario::findOrFail($id)
            ->update([
                'login' => $request->login,
                'password' => $request->password,
                'tipousuario_id' => $request->tipousuario,
                'persona_id' => $request->persona
            ]);

        return redirect()
            ->route('usuario')
            ->with('success', 'Actualizado correctamente');
    }


    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            Usuario::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
