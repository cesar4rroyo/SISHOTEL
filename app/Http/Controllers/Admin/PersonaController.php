<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidatePersona;
use App\Models\Habitacion;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Procesos\Pasajero;
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

    public function getPersonaDNI(Request $request){
        $dni = $request->dni;
        $persona = Persona::with('nacionalidad', 'roles')
            ->where('dni', $dni)
            ->get()
            ->toArray()[0];
     
        $roles = [];
        if (count($persona['roles']) != 0) {
            foreach ($persona['roles'] as $item) {
                $roles[] =
                    $item['id'];
            }
        }
        return response()->json(['persona' => $persona, 'roles' => $roles]);

    }

    public function pasajeroDestroy(Request $request){
        if ($request->ajax()) {
            $id = $request->id;
            Pasajero::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }

   
    public function store_checkout(Request $request)
    {
        
        try {
            $persona = Persona::create([
                'nombres' => strtoupper($request->nombresH),
                'apellidos' => strtoupper($request->apellidosH),
                'razonsocial' => strtoupper($request->razonsocialH),
                'ruc' => $request->rucH,
                'dni' => $request->dniH,
                'direccion' => strtoupper($request->direccionH),
                'sexo' => $request->sexoH,
                'fechanacimiento' => $request->fechanacimientoH,
                'telefono' => $request->telefonoH,
                'observacion' => strtoupper($request->observacionH),
                'nacionalidad_id' => $request->nacionalidad_idH,
                'edad' => $request->edadH,
                'email' => $request->emailH,
                'ciudad' => strtoupper($request->ciudadH),    
            ]);
            $persona->roles()->sync($request->rol_idH);

            $ultimapersona = Persona::latest('created_at')->first()->toArray();
            $pasajero = Pasajero::create([
                'movimiento_id' => $request->nro_movimientoH,
                'persona_id' => $ultimapersona['id'],
            ]);

            return response()->json([
                'message' => 'Se agregado correctamente',
                'type' => 'success'
            ]); 
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }

    }

    public function addHuespedHabitacion(Request $request)
    {
        try {
            $id_persona = $request->id;
            $id_movimiento = $request->id_movimiento;
            $pasajeros = Pasajero::get()->toArray();
            foreach ($pasajeros as $item) {
                if($item['persona_id']==$id_persona && $item['movimiento_id']==$id_movimiento){
                    return response()->json([
                        'message' => 'Este pasajero ya se encuentra en la habitación',
                        'type' => 'error'
                    ]); 
                }else{
                    $pasajero = Pasajero::create([
                        'movimiento_id' => $id_movimiento,
                        'persona_id' => $id_persona
                    ]);
                    return response()->json([
                        'message' => 'Se agregado correctamente',
                        'type' => 'success'
                    ]); 
                }
            }        
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function getClientesSinRuc()
    {
        $persona = Persona::get()->toArray();
        $data = [];
        foreach ($persona as $item) {
            if (!is_null($item['ruc']) && !is_null($item['razonsocial'])) {
                $nombres = $item['razonsocial'];
            } else {
                $nombres = $item['nombres'] . " " . $item['apellidos'];
            }
            $data[] = [
                'id' => $item['id'],
                'nombre' => $nombres,
            ];
        }
        $response = ['data' => $data];
        return response()->json($response);
    }
    public function getClientesRuc()
    {
        $persona = Persona::whereNotNull('ruc')->get()->toArray();
        $data = [];
        foreach ($persona as $item) {
            $data[] = [
                'id' => $item['id'],
                'nombre' => $item['razonsocial'],
            ];
        }
        $response = ['data' => $data];
        return response()->json($response);
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
    public function storeClienteRuc(Request $request)
    {
        $persona = Persona::create([
            'nombres' => '-',
            'apellidos' => '-',
            'razonsocial' => strtoupper($request->razonsocial),
            'ruc' => $request->ruc,
            'direccion' => strtoupper($request->direccion),
            'nacionalidad_id' => '155',
        ]);
        $persona->roles()->sync('2');

        return response()->json(['mensaje' => 'ok']);
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
