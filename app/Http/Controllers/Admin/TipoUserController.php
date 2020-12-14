<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateTipoUsuario;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\DB;

class TipoUserController extends Controller
{

    public function index()
    {
        $paginate_number = 10;
        $tipousuario = TipoUsuario::with('usuario')->paginate($paginate_number);
        return view('admin.tipousuario.index', compact('tipousuario'));
    }


    public function create()
    {
        return view('admin.tipousuario.create');
    }


    public function store(ValidateTipoUsuario $request)
    {
        TipoUsuario::create($request->all());
        return redirect()
            ->route('tipousuario')
            ->with('success', 'Agregado correctamente');
    }


    public function show($id)
    {
        $tipousuario = TipoUsuario::findOrFail($id);
        return view('admin.tipousuario.show', compact('tipousuario'));
    }


    public function edit($id)
    {
        $tipousuario = TipoUsuario::findOrFail($id);
        return view('admin.tipousuario.edit', compact('tipousuario'));
    }


    public function update(ValidateTipoUsuario $request, $id)
    {
        TipoUsuario::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('tipousuario')
            ->with('success', 'Menú actualizado con exito');
    }


    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            TipoUsuario::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
