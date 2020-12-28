<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use App\Models\Seguridad\Usuario;
use Carbon\Carbon;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request)) {
            $persona = Persona::find($request->persona)->get()->toArray();
            $habitacion = Habitacion::find($request->habitacion)->get()->toArray();
            $reserva = Reserva::find($request->id)->get()->toArray();
        } else {
            $persona = Persona::getClientes();
        }
        return response()->redirectTo('create_movimiento');
    }

    /**
     * Show the form for creating a new resource.     
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('control.checkin.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movimiento = Movimiento::create([
            'fechaingreso' => $request->fechaingreso,
            'persona_id' => $request->persona,
            'preciohabitacion' => $request->preciohabitacion,
            'usuario_id' => session()->all()['usuario_id'],
            'habitacion_id' => $request->habitacion,
            'situacion' => 'Pendiente'
        ]);
        $habitacion = Habitacion::find($request->habitacion);
        $habitacion->update([
            'situacion' => 'Ocupada'
        ]);

        return redirect()
            ->route('habitaciones')
            ->with('success', 'Agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id)->toArray();
        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            return view('control.checkin.index', compact('habitacion', 'personas', 'initialDate'));
        } else if ($habitacion['situacion'] == 'Ocupada') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            $movimiento =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
            return view('control.checkout.index', compact('habitacion', 'personas', 'initialDate', 'movimiento'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
