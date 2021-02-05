<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidatePersona;
use App\Models\Habitacion;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Rol;
use Carbon\Carbon;

class PersonaController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        //search es el filtro seleccionado para buscar a las personas
        $rol = $request->get('rol');
        //rol es el rol_id seleccionado como filtro de las personas
        $paginate_number = 20;
        if (!empty($rol)) {
            $persona = Persona::whereHas('roles', function ($query) use ($rol) {
                $query->where('rol_id', $rol);
            })->paginate($paginate_number);
            $rol = Rol::with('persona')->get();
        } else if (!empty($search)) {
            $persona = Persona::where('nombres', 'LIKE', '%' . $search . '%')
                ->orWhere('apellidos', 'LIKE', '%' . $search . '%')
                ->orWhere('ruc', 'LIKE', '%' . $search . '%')
                ->orWhere('dni', 'LIKE', '%' . $search . '%')
                ->orWhere('direccion', 'LIKE', '%' . $search . '%')
                ->orWhere('razonsocial', 'LIKE', '%' . $search . '%')
                ->paginate($paginate_number);
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


    public function store(ValidatePersona $request)
    {

        $persona = Persona::create([
            'nombres' => strtoupper($request->nombres),
            'apellidos' => strtoupper($request->apellidos),
            'razonsocial' => strtoupper($request->razonsocial),
            'ruc' => $request->ruc,
            'dni' => $request->dni,
            'direccion' => strtoupper($request->direccion),
            'sexo' => $request->sexo,
            'fechanacimiento' => $request->fechanacimiento,
            'telefono' => $request->telefono,
            'observacion' => strtoupper($request->observacion),
            'nacionalidad_id' => $request->nacionalidad_id,
            'email' => $request->email,
            'ciudad' => strtoupper($request->ciudad),
            'edad' => $request->edad,

        ]);
        $persona->roles()->sync($request->rol_id);
        return redirect()
            ->route('persona')
            ->with('success', 'Agregado correctamente');
    }
    public function store_checkin_reserva(Request $request, $id)
    {
        $reserva = $id;
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($request->habitacion)->toArray();
        $initialDate = Carbon::now()->format('Y-m-d\TH:i');
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        $nacionalidades = Nacionalidad::with('persona')->get();

        $persona = Persona::create([
            'nombres' => strtoupper($request->nombres),
            'apellidos' => strtoupper($request->apellidos),
            'razonsocial' => strtoupper($request->razonsocial),
            'ruc' => $request->ruc,
            'dni' => $request->dni,
            'direccion' => strtoupper($request->direccion),
            'sexo' => $request->sexo,
            'fechanacimiento' => $request->fechanacimiento,
            'telefono' => $request->telefono,
            'observacion' => strtoupper($request->observacion),
            'nacionalidad_id' => $request->nacionalidad_id,
            'edad' => $request->edad,
            'email' => $request->email,
            'ciudad' => strtoupper($request->ciudad),

        ]);
        $persona->roles()->sync($request->rol_id);

        $personas = Persona::getClientesConRucDni();

        return view('control.checkin.conreserva', compact('reserva', 'roles', 'nacionalidades', 'habitacion', 'personas', 'initialDate'));
    }
    public function store_checkin(Request $request)
    {
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($request->habitacion)->toArray();
        $initialDate = Carbon::now()->format('Y-m-d\TH:i');
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        $nacionalidades = Nacionalidad::with('persona')->get();

        $persona = Persona::create([
            'nombres' => strtoupper($request->nombres),
            'apellidos' => strtoupper($request->apellidos),
            'razonsocial' => strtoupper($request->razonsocial),
            'ruc' => $request->ruc,
            'dni' => $request->dni,
            'direccion' => strtoupper($request->direccion),
            'sexo' => $request->sexo,
            'fechanacimiento' => $request->fechanacimiento,
            'telefono' => $request->telefono,
            'observacion' => strtoupper($request->observacion),
            'nacionalidad_id' => $request->nacionalidad_id,
            'edad' => $request->edad,
            'email' => $request->email,
            'ciudad' => strtoupper($request->ciudad),

        ]);
        $persona->roles()->sync($request->rol_id);

        $personas = Persona::getClientesConRucDni();

        if (!empty($request->reserva)) {
            $id_reserva = $request->reserva;
            return view('control.checkin.index', compact('roles', 'nacionalidades', 'habitacion', 'personas', 'initialDate', 'id_reserva'));
        }

        return view('control.checkin.index', compact('roles', 'nacionalidades', 'habitacion', 'personas', 'initialDate'));
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
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        return view('admin.persona.edit', compact('persona', 'nacionalidades', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->update([
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
            'email' => $request->email,
            'ciudad' => $request->ciudad,
            'edad' => $request->edad,

        ]);
        $persona->roles()->sync($request->rol_id);

        return redirect()
            ->route('persona')
            ->with('success', 'Actualizado correctamente');
    }


    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            Persona::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
    public function buscador(Request $request)
    {
        $search = $request->search;
        $persona = Persona::where('nombres', 'LIKE', '%' . $search . '%')
            ->orWhere('apellidos', 'LIKE', '%' . $search . '%')
            ->orWhere('ruc', 'LIKE', '%' . $search . '%')
            ->orWhere('dni', 'LIKE', '%' . $search . '%')
            ->orWhere('direccion', 'LIKE', '%' . $search . '%')
            ->orWhere('razonsocial', 'LIKE', '%' . $search . '%')
            ->take(10)->get();
        return view('control.caja.checkout.create', compact('persona'));
    }
}
