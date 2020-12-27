<?php

namespace App\Http\Controllers\Reservas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if ($request->ajax()) {
            $reserva = Reserva::create([
                'fecha' => $request->fecha,
                'observacion' => $request->observacion,
                'persona_id' => $request->persona_id,
                'habitacion_id' => $request->habitacion_id,
                'usuario_id' => session()->all()['usuario_id'],
                'situacion' => 'Reservado',
            ]);
            return response()->json(['respuesta' => 'La reserva se registró correctamente']);
        } else {
            abort(404);
        }
    }

    public function show()
    {
        $data = [];
        $reservas = Reserva::with('habitacion', 'persona')->get();
        foreach ($reservas as $reserva) {
            $data[] = [
                'start' => $reserva->fecha,
                'title' => 'Reserva de ' . $reserva->persona->nombres,
                'observacion' => $reserva->observacion,
                'situacion' => $reserva->situacion,
                'persona' => $reserva->persona->nombres,
                'nro_telefono' => $reserva->persona->telefono,
                'dni' => $reserva->persona->dni,
                'habitacion' => $reserva->habitacion->numero,



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
        //
    }

    public function destroy($id)
    {
        //
    }
}
