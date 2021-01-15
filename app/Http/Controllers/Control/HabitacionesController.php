<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Piso;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use Carbon\Carbon;

class HabitacionesController extends Controller
{

    public function index(Request $request)
    {
        $piso = $request->get('piso');
        if (!empty($piso)) {
            $fechaActual = Carbon::now()->toDateString();
            // $habitacionMov = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
            //     $query->where('piso_id', $piso);
            // })->whereHas('movimiento', function ($q) use ($fechaActual) {
            //     $q->whereDate('fechaingreso', '%LIKE%', $fechaActual);
            // })->get()->toArray();
            $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
                $query->where('piso_id', $piso);
            })->get()->toArray();
            $reservas = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
                $query->where('piso_id', $piso);
            })->whereHas('reserva', function ($q) use ($fechaActual) {
                $q->where('fecha', $fechaActual);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find($piso);
            $disponibles = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')
                ->where('situacion', 'Disponible')->get()->toArray();
            $ocupadas = Movimiento::with('habitacion.tipohabitacion', 'pasajero.persona')
                ->where('situacion', 'Pendiente')->get()->toArray();
        } else {
            $fechaActual = Carbon::now()->toDateString();
            $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) {
                $query->where('piso_id', 1);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find(1);
            $reservas = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) {
                $query->where('piso_id', 1);
            })->whereHas('reserva', function ($q) use ($fechaActual) {
                $q->where('fecha', $fechaActual);
            })->get()->toArray();
            // $habitacionMov = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
            //     $query->where('piso_id', 1);
            // })->whereHas('movimiento', function ($q) use ($fechaActual) {
            //     $q->whereDate('fechaingreso', '%LIKE%', $fechaActual);
            // })->get()->toArray();
            $disponibles = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')
                ->where('situacion', 'Disponible')->get()->toArray();
            $ocupadas = Movimiento::with('habitacion.tipohabitacion', 'pasajero.persona')
                ->where('situacion', 'Pendiente')->get()->toArray();
            // dd($disponibles);
        }
        // dd($habitacion);
        return view('control.index', compact('disponibles', 'ocupadas', 'habitacion', 'pisos', 'piso', 'fechaActual', 'reservas'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //fecha de salida de cada habitacion es 12.00 medio dia

        if (!empty($request->fechaSalida)) {
            $horaCheck_in = 14;
            $horaCheck_out = 12;
            $fechaSalida = $request->fechaSalida;
            $fechaSalida2 = Carbon::parse($fechaSalida)->addHours($horaCheck_out)->toDateTimeString();
            $fechaEntrada = $request->fechaEntrada;
            $fechaEntrada2 = Carbon::parse($fechaEntrada)->addHours($horaCheck_in)->toDateTimeString();


            $habitaciones = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')
                ->where(function ($q) use ($fechaEntrada2, $fechaSalida2) {
                    $q->whereNotIn('id', function ($q2) use ($fechaEntrada2, $fechaSalida2) {
                        $q2->from('reserva')
                            ->select('habitacion_id')
                            ->where('fecha', '<=', $fechaSalida2)
                            ->where('fechasalida', '>=', $fechaEntrada2)
                            ->where('situacion', 'Reservado');
                    });
                    $q->whereNotIn('id', function ($q3) use ($fechaEntrada2, $fechaSalida2) {
                        $q3->from('movimiento')
                            ->select('habitacion_id')
                            ->where('fechaingreso', '<=', $fechaSalida2)
                            ->where('fechasalida', '>=', $fechaEntrada2)
                            ->where('situacion', 'Pendiente');
                    });
                })->get()->toArray();

            return response()->json($habitaciones);
        }

        $fecha = $request->get('fecha');


        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->whereDoesntHave('reserva', function ($query) use ($fecha) {
            $query->where('fecha', '=', $fecha);
        })->get()->toArray();
        return response()->json($habitacion);
    }


    public function show($id)
    {
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id);
        $reservas = Reserva::with('habitacion', 'persona')->where('situacion', "Reservado")->whereHas('habitacion', function ($query) use ($id) {
            $query->where('habitacion_id', $id);
        })->orderBy('fecha')->paginate(10);
        return view('control.reservas.reservas', compact('habitacion', 'reservas'));
    }

    public function edit($id)
    {
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
