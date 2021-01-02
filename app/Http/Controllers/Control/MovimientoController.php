<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
use App\Models\Procesos\Reserva;
use App\Models\Rol;
use App\Models\Seguridad\Usuario;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Barryvdh\DomPDF\Facade as PDF;


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

    public function listarCheckOuts()
    {
        $movimientos =
            Movimiento::with('pasajero.persona.nacionalidad', 'detallemovimiento', 'habitacion.tipohabitacion', 'comprobante', 'caja')
            ->where('situacion', 'Pago Realizado')
            ->get();
        return view('control.checkout.list', compact('movimientos'));
    }

    public function exportPdf($id)
    {
        $movimiento =
            Movimiento::with('pasajero.persona.nacionalidad', 'detallemovimiento', 'habitacion.tipohabitacion', 'comprobante', 'caja')
                ->where('id', $id)
                ->get()
                ->toArray()[0];
        // dd($movimiento);
        $pdf = PDF::loadView('pdf.checkout', compact('movimiento'))->setPaper('a4');
        return $pdf->download('registros-check-out.pdf');
    }
    public function editConReserva($id_habitacion, $id_reserva)
    {
        $reserva = $id_reserva;
        $initialDate = Carbon::now()->format('Y-m-d\TH:i');
        $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
        $nacionalidades = Nacionalidad::with('persona')->get();
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id_habitacion)->toArray();
        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            return view('control.checkin.conreserva', compact('nacionalidades', 'roles', 'habitacion', 'personas', 'initialDate', 'reserva'));
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
        $personas = $request->persona;
        if (session()->get('pasajeros')) {
            session()->pull('pasajeros', []);
        }
        session()->push('pasajeros', $personas);


        $movimiento = Movimiento::create([
            'fechaingreso' => $request->fechaingreso,
            'preciohabitacion' => $request->preciohabitacion,
            'usuario_id' => session()->all()['usuario_id'],
            'habitacion_id' => $request->habitacion,
            'situacion' => 'Pendiente'
        ]);
        $habitacion = $request->habitacion;


        return view('control.checkin.confirmacion', compact('habitacion'));
    }
    public function show()
    {
        $movimiento = Movimiento::latest('id')->first()->toArray();
        return response()->json($movimiento);
    }

    public function edit($id)
    {
        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id)->toArray();
        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $personas = Persona::getClientes();
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
            $nacionalidades = Nacionalidad::with('persona')->get();

            return view('control.checkin.index', compact('roles', 'nacionalidades', 'habitacion', 'personas', 'initialDate'));
        } else if ($habitacion['situacion'] == 'Ocupada') {
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            $movimiento =
                Movimiento::with('pasajero', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
            $id_movimiento = $movimiento['id'];
            $detalles = DetalleMovimiento::with('producto', 'servicios', 'movimiento')
                ->whereHas('movimiento', function ($h) use ($id_movimiento) {
                    $h->where('id', $id_movimiento);
                })->get()->toArray();
            // dd($detalles);
            $pasajeros = Pasajero::with('persona', 'movimiento')
                ->whereHas('movimiento', function ($q) use ($id) {
                    $q->where('habitacion_id', $id);
                })
                ->where('movimiento_id', $movimiento['id'])
                ->get()
                ->toArray();


            return view('control.checkout.index', compact('conceptos', 'habitacion', 'initialDate', 'detalles', 'movimiento', 'pasajeros'));
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $pasajeros = session()->get('pasajeros')[0];
            foreach ($pasajeros as $key => $item) {
                $pasajero = Pasajero::create([
                    'movimiento_id' => $request->movimiento,
                    'persona_id' => $item
                ]);
            }
            $habitacion = Habitacion::find($id);
            $habitacion->update([
                'situacion' => 'Ocupada'
            ]);
            return redirect()
                ->route('habitaciones')
                ->with('success', 'El Check-in se ha realizado correctamente');
        } catch (\Throwable $th) {
            return redirect()
                ->route('habitaciones')
                ->with('error', 'Ha ocurrido un error interno' . $th);
        }
    }


    public function destroy($id)
    {
        //
    }
}
