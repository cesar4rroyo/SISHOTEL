<?php

namespace App\Http\Controllers\Reservas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateReserva;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Piso;
use App\Models\Procesos\Reserva;
use Carbon\Carbon;

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

        $clientes = Persona::getClientes();
        $habitaciones = Habitacion::with('reserva', 'piso', 'tipohabitacion')->get()->toArray();

        return view('reservas.index', compact('initialDate', 'clientes', 'habitaciones'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $reserva = Reserva::create([
            'fecha' => $request->txtFecha,
            'observacion' => $request->observacion,
            'persona_id' => $request->persona,
            'habitacion_id' => $request->habitacion,
            'usuario_id' => session()->all()['usuario_id'],
            'situacion' => 'Reservado',
        ]);
        return redirect()
            ->route('reserva')
            ->with('success', 'La reserva se registró correctamente');
    }

    public function show()
    {
        $data = [];
        $reservas = Reserva::with('habitacion', 'persona')->get();
        foreach ($reservas as $reserva) {
            if ($reserva->situacion == 'Reservado' || $reserva->situacion == 'Actualizado') {
                $data[] = [
                    'id' => $reserva->id,
                    'start' => $reserva->fecha,
                    'title' => $reserva->habitacion->numero . ' Reserva de ' . $reserva->persona->nombres,
                    'observacion' => $reserva->observacion,
                    'situacion' => $reserva->situacion,
                    'persona' => $reserva->persona->nombres . $reserva->persona->apellidos,
                    'nro_telefono' => $reserva->persona->telefono,
                    'persona_id' => $reserva->persona->id,
                    'dni' => $reserva->persona->dni,
                    'habitacion' => $reserva->habitacion->numero,
                    'habitacion_id' => $reserva->habitacion->id,

                ];
            }
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
        $reserva->update([
            'situacion' => 'Cancelado',
        ]);

        return response()->json(['respuesta' => 'El reserva se cancelo correctamente']);
    }
}
