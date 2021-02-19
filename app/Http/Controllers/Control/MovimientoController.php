<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
use App\Models\Procesos\Reserva;
use App\Models\Procesos\Tarjeta;
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
        return $pdf->stream('registros-check-out.pdf');
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

    public function store(Request $request, $id_reserva = null)
    {
        // dd($request->all());
        $personas = $request->persona;
        if (session()->get('pasajeros')) {
            session()->pull('pasajeros', []);
        }
        session()->push('pasajeros', $personas);
        $pasajeroPrincipal = $request->persona_principal;

        // dd(session()->all());
        if (!empty($request->numero)) {
            $tarjeta = Tarjeta::create([
                'tipo' => $request->tipo,
                'titular' => $request->titular,
                'numero' => $request->numero,
                'fechavencimiento' => $request->fechavencimiento,
            ]);
            $id_tarjeta = Tarjeta::latest('id')->first()->toArray()['id'];
        }

        if (!is_null($id_reserva)) {
            $reserva = Reserva::findOrFail($id_reserva);
            $reserva->update([
                'situacion' => 'Usada',
            ]);
        }


        $movimiento = Movimiento::create([
            'fechaingreso' => $request->fechaingreso,
            'fechasalida' => isset($request->fechasalida) ? $request->fechasalida : null,
            'total' => isset($request->total) ? $request->total : null,
            'comentario' => isset($request->comentario) ? $request->comentario : '-',
            'descuento' => isset($request->descuento) ? $request->descuento : null,
            'preciohabitacion' => $request->preciohabitacion,
            'usuario_id' => session()->all()['usuario_id'],
            'habitacion_id' => $request->habitacion,
            'situacion' => 'Pendiente',
            'tarjeta_id' => isset($id_tarjeta) ? $id_tarjeta : null,
            'reserva_id' => isset($id_reserva) ? $id_reserva : null,
        ]);
        $habitacion = $request->habitacion;
        $movimiento = Movimiento::latest('id')->first()->toArray()['id'];


        return view('control.checkin.confirmacion', compact('habitacion', 'movimiento', 'pasajeroPrincipal'));
    }
    public function show()
    {
        $movimiento = Movimiento::latest('id')->first()->toArray();
        return response()->json($movimiento);
    }

    public function edit($id, $id_reserva = null)
    {

        //$id ====> es el id de la habitacion,
        //$id_reserva ====> es el id de la reserva (es opcional)
        $conceptos = Concepto::with('caja')
            ->whereNotIn('id', array(1, 2))
            ->orderBy('nombre')
            ->get();
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id)->toArray();

        if ($habitacion['situacion'] == 'Disponible' || $habitacion['situacion'] == 'Limpieza') {
            $initialDate = Carbon::now()->format('Y-m-d\TH:i');
            $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
            $nacionalidades = Nacionalidad::with('persona')->get();
            $personas = Persona::getClientesConRucDni();
            return view('control.checkin.index', compact('roles', 'nacionalidades', 'habitacion', 'personas', 'initialDate', 'id_reserva'));
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
            $pasajerosSelect = [];
            foreach ($pasajeros as $item) {
                if (!is_null($item['persona']['razonsocial']) && trim($item['persona']['razonsocial'])!='') {
                    $nombres = $item['persona']['razonsocial'];
                } else if ($item['persona']['nombres'] != '-' && !is_null($item['persona']['nombres'])) {
                    $nombres = $item['persona']['nombres'] . ' ' . $item['persona']['apellidos'];
                }
                $pasajerosSelect[] = [
                    "id_pasajero"=>$item['id'],
                    "id" => $item['persona']['id'],
                    "nombres" => $nombres,
                    "ruc" => $item['persona']['ruc'],
                    "dni" => $item['persona']['dni'],
                    "telefono" => $item['persona']['telefono'],
                    "direccion" => $item['persona']['direccion'],
                ];
            }
            $personas = Persona::getClientesConRucDni();
            $comprobante = Comprobante::latest('id')->first();
            if (!is_null($comprobante)) {
                $comprobante->get()->toArray();
                $numero = $comprobante['id'] + 1;
                $numero = $this->zero_fill($numero, 8);
                $yearActual = Carbon::now()->year;
                $numero = 'B063-' . $numero;
            } else {
                $numero = $this->zero_fill(1, 8);
                $yearActual = Carbon::now()->year;
                $numero = 'B063-' . $numero;
            }
            $roles = Rol::orderBy('id')->pluck('nombre', 'id')->toArray();
            $nacionalidades = Nacionalidad::with('persona')->get();
            return
                view(
                    'control.checkout.index',
                    compact('roles', 'nacionalidades','id_movimiento', 'numero', 'conceptos', 'habitacion', 'initialDate', 'detalles', 'movimiento', 'pasajerosSelect', 'personas')
                );
        }
    }

    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    public function exportPdfCheckIn($id)
    {
        $movimiento =
            Movimiento::with('pasajero.persona.nacionalidad', 'habitacion.tipohabitacion', 'tarjeta')
                ->where('id', $id)
                ->get()
                ->toArray()[0];
        // dd($movimiento);
        $pdf = PDF::loadView('pdf.checkin', compact('movimiento'))->setPaper('a4');
        return $pdf->stream('registros-check-in.pdf');
    }

    public function update(Request $request, $id)
    {
        try {
            $pasajero = Pasajero::create([
                'movimiento_id' => $request->movimiento,
                'persona_id' => $request->pasajeroPrincipal
            ]);
            $pasajeros = session()->get('pasajeros')[0];
            if (!is_null($pasajeros)) {
                foreach ($pasajeros as $key => $item) {
                    $pasajero = Pasajero::create([
                        'movimiento_id' => $request->movimiento,
                        'persona_id' => $item
                    ]);
                }
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
