<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Rol;

class RolPersonaController extends Controller
{

    public function index()
    {
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        $personas = Persona::with('roles')->get()->toArray();
        $personasroles = Persona::with('roles')
            ->get()
            ->pluck('roles', 'id')
            ->toArray();
        // dd($personas);
        return view('admin.rolpersona.index', compact('roles', 'personasroles', 'personas'));
    }


    public function store(Request $request)
    {
        if ($request->ajax()) {
            $personas = new Persona();
            if ($request->input('estado') == 1) {
                $personas->find($request->input('persona_id'))->roles()->attach($request->input('rol_id'));
                return response()->json(['respuesta' => 'El rol se asigno correctamente']);
            } else {
                $personas->find($request->input('persona_id'))->roles()->detach($request->input('rol_id'));
                return response()->json(['respuesta' => 'El rol se elimino correctamente']);
            }
        } else {
            abort(404);
        }
    }
}
