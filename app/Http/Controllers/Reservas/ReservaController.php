<?php

namespace App\Http\Controllers\Reservas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateReserva;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Piso;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Reserva;
use Carbon\Carbon;
use DateTime;

class ReservaController extends Controller
{

    public function index(Request $request)
    {
        $fecha = $request->get('fecha');

        if (!empty($fecha)) {
            $initialDate = $fecha;
        } else {
            $initialDate = Carbon::now();
            $initialDate = $initialDate->toDateString();
        }

        $clientes = Persona::getClientesConRucDni();
        $habitaciones = Habitacion::with('reserva', 'piso', 'tipohabitacion')->get()->toArray();

        return view('reservas.index', compact('initialDate', 'clientes', 'habitaciones'));
    }

    public function listarReservas()
    {
        $hoy = Carbon::now()->toDateTimeLocalString();
        $reservas = Reserva::with('habitacion', 'persona')
            ->where('situacion', "Reservado")
            ->where('fecha', '>', $hoy)
            ->orderBy('fecha')
            ->paginate(10);
        return view('control.reservas.index', compact('reservas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $horaCheck_in = 14;
        $horaCheck_out = 12;
        $fechaentrada = Carbon::parse($request->txtFecha)->addHours($horaCheck_in)->toDateTimeString();
        $fechaSalida = Carbon::parse($request->txtFechaSalida)->addHours($horaCheck_out)->toDateTimeString();



        $habitaciones = $request->habitacion;
        foreach ($habitaciones as $key => $item) {
            $reserva = Reserva::create([
                'fecha' => $fechaentrada,
                'fechasalida' => $fechaSalida,
                'observacion' => $request->observacion,
                'persona_id' => $request->persona,
                'habitacion_id' => $item,
                'usuario_id' => session()->all()['usuario_id'],
                'situacion' => 'Reservado',
            ]);
        }

        return redirect()
            ->route('reserva')
            ->with('success', 'La reserva se registró correctamente');
    }

    public function show()
    {
        $data = [];
        $reservas = Reserva::with('habitacion', 'persona')->get();
        $habitacionesOcupadas = Movimiento::with('habitacion.tipohabitacion', 'pasajero.persona')
            ->where('situacion', 'Pendiente')->get();
        // dd($habitacionesOcupadas->toArray());
        foreach ($reservas as $reserva) {
            if ($reserva->situacion == 'Reservado' || $reserva->situacion == 'Actualizado') {
                if ($reserva->persona->nombres == '-' || !is_null($reserva->persona->razonsocial)) {
                    $persona = $reserva->persona->razonsocial;
                } else {
                    $persona = $reserva->persona->nombres . " " . $reserva->persona->apellidos;
                }
                // $date = Carbon::createFromFormat('Y-m-d', $reserva->fechasalida)->addDay()->toDateString();
                $data[] = [
                    'id' => $reserva->id,
                    'start' => $reserva->fecha,
                    'end' => $reserva->fechasalida,
                    'title' => $reserva->habitacion->numero . ' Reserva de ' . $persona,
                    'observacion' => $reserva->observacion,
                    'situacion' => $reserva->situacion,
                    'persona' => $persona,
                    'nro_telefono' => $reserva->persona->telefono,
                    'persona_id' => $reserva->persona->id,
                    'dni' => $reserva->persona->dni,
                    'habitacion' => $reserva->habitacion->numero,
                    'habitacion_id' => $reserva->habitacion->id,

                ];
            }
        }
        foreach ($habitacionesOcupadas as $habitacion) {
            $data[] = [
                'start' => $habitacion->fechaingreso,
                'end' => $habitacion->fechasalida,
                'title' => $habitacion->habitacion->numero . '- Habitación Ocupada',
                'color' => 'red',
                'persona_id' => $habitacion->pasajero[0]->persona->id,
                'situacion' => 'Ocupada',
                'habitacion_id' => $habitacion->habitacion->id

            ];
        }

        return response()->json($data);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'fecha' => $request->txtFecha,
            'observacion' => $request->observacion,
            'persona_id' => $request->persona,
            'habitacion_id' => $request->habitacion,
            'usuario_id' => session()->all()['usuario_id'],
            'situacion' => 'Reservado',
        ]);
        return response()->json(['respuesta' => 'La reserva se actualizo correctamente']);
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->destroy($id);
        return response()->json(['mensaje' => 'ok']);
    }
}
