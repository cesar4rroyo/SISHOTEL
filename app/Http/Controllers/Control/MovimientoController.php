<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use App\Models\Seguridad\Usuario;
use Carbon\Carbon;

class MovimientoController extends Controller
{

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

    public function editConReserva($id_habitacion, $id_reserva)
    {
        $reserva = $id_reserva;
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id_habitacion)->toArray();
        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            return view('control.checkin.index', compact('habitacion', 'personas', 'initialDate', 'reserva'));
        } else {
            return redirect()
                ->route('habitaciones')
                ->with('error', 'La habitación se encuentra ocupada o está en limpieza');
        }
    }


    public function create()
    {
        return view('control.checkin.index');
    }

    public function store(Request $request, $id_reserva)
    {
        if ($id_reserva != 'no') {
            $reserva = Reserva::findOrFail($id_reserva);
            $reserva->update([
                'situacion' => 'Usada',
            ]);
        }
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



    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id)->toArray();
        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            return view('control.checkin.index', compact('habitacion', 'personas', 'initialDate'));
        } else if ($habitacion['situacion'] == 'Ocupada') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            $detalles = DetalleMovimiento::with('producto', 'servicios')
                ->whereHas('movimiento', function ($h) use ($id) {
                    $h->wherehas('habitacion', function ($q) use ($id) {
                        $q->where('id', $id);
                    })->latest('fechaingreso');
                })->get()->toArray();
            $movimiento =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();

            return view('control.checkout.index', compact('conceptos', 'habitacion', 'personas', 'initialDate', 'detalles', 'movimiento'));
        }
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
