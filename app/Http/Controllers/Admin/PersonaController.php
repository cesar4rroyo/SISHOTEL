<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Rol;

class PersonaController extends Controller
{

    //  Persona::with('roles')->get()->pluck('roles','id')->toArray();
    public function index(Request $request)
    {
        $search = $request->get('search');
        //search es el rol seleccionado como filtro de las personas
        $paginate_number = 10;
        if (!empty($search)) {
            $persona = Persona::whereHas('roles', function ($query) use ($search) {
                $query->where('rol_id', $search);
            })->paginate($paginate_number);
            $rol = Rol::with('persona')->get();
        } else {
            $persona =
                Persona::with('roles')
                ->paginate($paginate_number);
            $rol = Rol::with('persona')->get();
        }

        return view('admin.persona.index', compact('persona', 'rol'));
    }


    public function create()
    {
        $nacionalidades = Nacionalidad::with('persona')->get();
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        return view('admin.persona.create', compact('nacionalidades', 'roles'));
    }


    public function store(Request $request)
    {
        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'razonsocial' => $request->razonsocial,
            'ruc' => $request->ruc,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'sexo' => $request->sexo,
            'fechanacimiento' => $request->fechanacimiento,
            'telefono' => $request->telefono,
            'observacion' => $request->observacion,
            'nacionalidad_id' => $request->nacionalidad_id,

        ]);
        return redirect()
            ->route('persona')
            ->with('success', 'Agregado correctamente');
    }


    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        return view('admin.persona.show', compact('persona'));
    }


    public function edit($id)
    {
        $nacionalidades = Nacionalidad::with('persona')->get();
        $persona = persona::findOrFail($id);
        return view('admin.persona.edit', compact('persona', 'nacionalidades'));
    }


    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id)
            ->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'razonsocial' => $request->razonsocial,
                'ruc' => $request->ruc,
                'dni' => $request->dni,
                'direccion' => $request->direccion,
                'sexo' => $request->sexo,
                'fechanacimiento' => $request->fechanacimiento,
                'telefono' => $request->telefono,
                'observacion' => $request->observacion,
                'nacionalidad_id' => $request->nacionalidad_id,
            ]);

        return redirect()
            ->route('persona')
            ->with('success', 'Actualizado correctamente');
    }


    public function destroy($id)
    {
        Persona::destroy($id);
        return redirect()
            ->route('persona')
            ->with('success', 'Eliminado Correctamente');
    }
}
