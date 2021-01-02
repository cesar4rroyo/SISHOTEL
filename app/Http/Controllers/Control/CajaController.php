<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\Movimiento;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class CajaController extends Controller
{

    public function index()
    {
        $cajaApertura =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        $disabled = false;

        if ($cajaApertura['concepto_id'] != '2') {
            $disabled = true;
        }
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')->whereHas('concepto', function ($q) {
                $q->where('id', 2);
            })
            ->latest('fecha')->first()->toArray();

        $cajas =
            Caja::with('concepto', 'usuario', 'persona', 'movimiento')
            ->where('fecha', '>', $caja['fecha'])
            ->orderBy('fecha', 'DESC')
            ->paginate(10);
        // dd($cajas->toArray());

        return view('control.caja.index', compact('disabled', 'cajas'));
    }

    public function exportPdf()
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')->whereHas('concepto', function ($q) {
                $q->where('id', 2);
            })
            ->latest('fecha')->first()->toArray();
        $cajas =
            Caja::with('concepto', 'usuario', 'persona', 'movimiento')
            ->where('fecha', '>', $caja['fecha'])
            ->orderBy('fecha', 'DESC')
            ->get();
        $pdf = PDF::loadView('pdf.caja', compact('cajas'))->setPaper('a4', 'landscape');;
        return $pdf->download('registros-list.pdf');
    }

    public function indexLista(Request $request)
    {
        $search = $request->get('search');
        $concepto = $request->get('concepto');
        $tipo = $request->get('tipo');

        if (!empty($concepto)) {
            $cajas =
                Caja::with('concepto', 'usuario', 'persona', 'movimiento')
                ->whereHas('concepto', function ($q) use ($concepto) {
                    $q->where('id', $concepto);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        } else if (!empty($tipo)) {
            $cajas =
                Caja::with('concepto', 'usuario', 'persona', 'movimiento')
                ->where('tipo', $tipo)
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        } else {
            $cajas =
                Caja::with('concepto', 'usuario', 'persona', 'movimiento')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        $concepto = Concepto::with('caja')->get();
        return view('control.caja.movimientos.index', compact('concepto', 'cajas'));
    }


    public function create()
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        if ($caja['concepto_id'] != '2') {
            $caja = Caja::latest('id')->first();
            if (!is_null($caja)) {
                $caja->get()->toArray();
                $numero = $caja['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.create', compact('numero', 'conceptos', 'personas', 'today'));
        } else {
            return redirect()
                ->route('caja')
                ->with('error', 'No se ha aperturado la caja');
        }
    }


    public function store(Request $request)
    {
        $caja = Caja::create([
            'fecha' => $request->fecha,
            'numero' => $request->numero,
            'concepto_id' => $request->concepto,
            'tipo' => $request->tipo,
            'persona_id' => $request->persona,
            'total' => $request->total,
            'comentario' => $request->comentario,
            'usuario_id' => session()->all()['usuario_id'],

        ]);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }


    public function show($id)
    {
        $caja = Caja::with('detallecaja.producto', 'detallecaja.servicios', 'movimiento')->findOrFail($id);
        $detallecaja = $caja->toArray()['detallecaja'];
        // dd($detallecaja);
        return view('control.caja.show', compact('detallecaja', 'caja'));
    }


    public function edit($id)
    {

        $cajaApertura =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        if ($cajaApertura['concepto_id'] != '2') {
            $caja = Caja::findOrFail($id);
            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.edit', compact('caja', 'conceptos', 'personas', 'today'));
        } else {
            return redirect()
                ->route('caja')
                ->with('error', 'La caja ya fue cerrada');
        }
    }


    public function update(Request $request, $id)
    {
        $caja = Caja::findOrFail($id);

        $caja->update([
            'fecha' => $request->fecha,
            'numero' => $request->numero,
            'concepto_id' => $request->concepto,
            'tipo' => $request->tipo,
            'persona_id' => $request->persona,
            'total' => $request->total,
            'comentario' => $request->comentario,
            'usuario_id' => session()->all()['usuario_id'],

        ]);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro actualizado correctamente');
    }


    public function destroy(Request $request, $id)
    {
        $cajaApertura =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        if ($cajaApertura['concepto_id'] != '2') {
            if ($request->ajax()) {
                Caja::destroy($id);
                return response()->json(['mensaje' => 'ok']);
            } else {
                abort(404);
            }
        }
    }

    public function create_cierre(Request $request)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        if ($caja['concepto_id'] != '2') {
            $total = $request->total;
            if (!empty($total)) {
                $caja = Caja::latest('id')->first();
                if (!is_null($caja)) {
                    $caja->get()->toArray();
                    $numero = $caja['numero'] + 1;
                    $numero = $this->zero_fill($numero, 8);
                } else {
                    $numero = $this->zero_fill(1, 8);
                }
                $caja =
                    Caja::with('concepto', 'usuario', 'persona', 'movimiento')->get()->toArray();
                $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
                $today = Carbon::now()->toDateString();
                $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
                return view('control.caja.cierre.create', compact('numero', 'total', 'conceptos', 'personas', 'today'));
            }
        }
        return redirect()
            ->route('caja')
            ->with('error', 'La caja ya se cerró, abra otra de nuevo');
    }
    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
    public function create_apertura()
    {
        $cajaValidar =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        if ($cajaValidar['concepto_id'] == '2') {
            $caja = Caja::latest('id')->first();

            if (!is_null($caja)) {
                $caja->get()->toArray();
                $numero = $caja['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }

            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.apertura.create', compact('numero', 'conceptos', 'personas', 'today'));
        }
        return redirect()
            ->route('caja')
            ->with('error', 'Hay una caja abierta, cierrela y crea otra de nuevo');
    }

    public function createCheckout(Request $request, $id)
    {

        $movimiento = Movimiento::findOrFail($id);
        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $today = Carbon::now()->toDateString();
        $total = $request->total;
        $habitacion = $request->habitacion_id;
        $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
        $caja = Caja::latest('id')->first();

        if (!is_null($caja)) {
            $caja->get()->toArray();
            $numero = $caja['numero'] + 1;
            $numero = $this->zero_fill($numero, 8);
        } else {
            $numero = $this->zero_fill(1, 8);
        }
        $movimiento->update([
            'fechasalida' => $request->fechasalida,
            'dias' => $request->dias,
            'total' => $request->total,
            'situacion' => 'En espera pago',
        ]);

        return view('control.caja.checkout.create', compact('numero', 'habitacion', 'conceptos', 'id', 'personas', 'today', 'total'));
    }
    public function checkout(Request $request, $id)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        $movimiento = Movimiento::findOrFail($id);

        if ($caja['concepto_id'] != '2') {
            $movimiento->update([
                'situacion' => 'Pago Realizado',
            ]);
            $habitacion = $request->habitacion;
            $caja = Caja::create([
                'fecha' => $request->fecha,
                'numero' => $request->numero,
                'concepto_id' => $request->concepto,
                'tipo' => $request->tipo,
                'persona_id' => $request->persona,
                'total' => $request->total,
                'comentario' => $request->comentario,
                'usuario_id' => session()->all()['usuario_id'],
                'movimiento_id' => $id,
            ]);
            return view('control.caja.checkout.updatehabitacion', compact('habitacion'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }
    public function updateHabitacion(Request $request, $id)
    {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->update([
            'situacion' => 'En limpieza',

        ]);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    public function addFromDetallePdto($id)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            $cart = session()->get('cart');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $cajaValidate = Caja::latest('id')->first();

            if (!is_null($cajaValidate)) {
                $cajaValidate->get()->toArray();
                $numero = $cajaValidate['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }

            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.producto.create', compact('numero', 'conceptos', 'id', 'personas', 'today', 'total'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }
    public function addFromDetalleService($id)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            $cart = session()->get('servicio');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $cajaValidate = Caja::latest('id')->first();

            if (!is_null($cajaValidate)) {
                $cajaValidate->get()->toArray();
                $numero = $cajaValidate['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }

            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.servicio.create', compact('numero', 'conceptos', 'id', 'personas', 'today', 'total'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }
    public function storeProducto(Request $request)
    {
        $comentario = $request->comentario;
        $cajaAdd = Caja::create([
            'fecha' => $request->fecha,
            'numero' => $request->numero,
            'concepto_id' => $request->concepto,
            'tipo' => $request->tipo,
            'persona_id' => $request->persona,
            'total' => $request->total,
            'comentario' => $comentario,
            'usuario_id' => session()->all()['usuario_id'],

        ]);

        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        $id_caja = $caja['id'];
        $productos = session()->all()['cart'];
        foreach ($productos as $key => $item) {
            $detallecaja = DetalleCaja::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'producto_id' => $key,
                'caja_id' => $id_caja,
            ]);
        }


        session()->pull('cart', []);

        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    public function storeServicio(Request $request)
    {
        $comentario = $request->comentario;

        $cajaAdd = Caja::create([
            'fecha' => $request->fecha,
            'numero' => $request->numero,
            'concepto_id' => $request->concepto,
            'tipo' => $request->tipo,
            'persona_id' => $request->persona,
            'total' => $request->total,
            'comentario' => $request->comentario,
            'usuario_id' => session()->all()['usuario_id'],

        ]);
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        $id_caja = $caja['id'];
        $servicios = session()->all()['servicio'];
        foreach ($servicios as $key => $item) {
            $detallecaja = DetalleCaja::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'servicio_id' => $key,
                'caja_id' => $id_caja,
            ]);
        }
        session()->pull('servicio', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
}
