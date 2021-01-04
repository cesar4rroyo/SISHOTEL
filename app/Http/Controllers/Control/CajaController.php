<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
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
        $btnApertura = true;
        $btnCerrar = false;
        $btnNuevo = false;
        $disabled = false;

        if ($cajaApertura['concepto_id'] != '2') {
            $btnApertura = false;
            $btnCerrar = true;
            $btnNuevo = true;
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

        return view('control.caja.index', compact('disabled', 'cajas', 'btnApertura', 'btnCerrar', 'btnNuevo'));
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
            $conceptos = Concepto::with('caja')
                ->whereNotIn('id', array(1, 2))
                ->orderBy('nombre')
                ->get();
            // dd($conceptos->toArray());
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
            $conceptos = Concepto::with('caja')
                ->whereNotIn('id', array(1, 2))
                ->orderBy('nombre')
                ->get();
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
        $conceptos = Concepto::with('caja')
            ->whereNotIn('id', array(1, 2))
            ->orderBy('nombre')
            ->get();
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
        //validar si la caja esta aperturada o no
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        $movimiento = Movimiento::findOrFail($id);
        if ($caja['concepto_id'] != '2') {
            $movimiento->update([
                'situacion' => 'Pago Realizado',
            ]);
            //guardando movimiento en caja
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
            $comprobante = Comprobante::latest('id')->first();
            if (!is_null($comprobante)) {
                $comprobante->get()->toArray();
                $numero = $comprobante['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            //creando datos de la factura
            $total = $request->total;
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
            //retornanr a vista de generar factura y cambiar estado de la 'habitacion' de disponible a 'en limpieza'
            return view('control.caja.checkout.updatehabitacion', compact('habitacion', 'total', 'igv', 'subtotal', 'id', 'numero'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }

    //esta funcion es para generar el comprobante de un movimiento cuando se hace checkout
    public function updateHabitacion(Request $request, $id)
    {
        //se actualiza el movimiento su situación de 'Pago Pendiente' a 'Pago Realizado'
        $movimiento =
            Movimiento::with('caja.persona')
            ->where('situacion', 'Pago Realizado')
            ->latest()
            ->first()
            ->toArray();
        //creacion del comprobante con los datos del Request
        $comprobante = Comprobante::create([
            'tipodocumento' => $request->tipodocumento,
            'numero' => $request->numero,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'igv' => $request->igv,
            'comentario' => $request->comentario,
            'movimiento_id' => $movimiento['id'],
        ]);
        //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->update([
            'situacion' => 'En limpieza',
        ]);

        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    //estax funciones addFromDetallePdto y addFromDetalleService se encargara de verificar 
    //si la caja esta aperturada o no, además de enviar
    //los datos necesarios que serán utilizados en la vista para agregarlo a las tablas caja,
    //comprobante y/o detalleComprobante
    public function addFromDetallePdto($id)
    {
        //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
        //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
        //ya se crear un nuevo registro o aperturar la caja.
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            //llamar a la sesion del carrito de productos
            $cart = session()->get('cart');
            $total = 0;
            //gererar el total recorriendo el array de productos 'cart'
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            //esta validación es para generar el número correlativo para la caja
            $cajaValidate = Caja::latest('id')->first();
            //si es diferente de nulo se le sumará uno al registro anterior
            if (!is_null($cajaValidate)) {
                $cajaValidate->get()->toArray();
                $numero = $cajaValidate['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                //de lo contrario se le dará el número 1 por defecto, seria de esta forma '00000001'
                $numero = $this->zero_fill(1, 8);
            }
            //enviar hacia la vista las variables u objetos que se usarán posteriormente
            $conceptos = Concepto::with('caja')
                ->whereNotIn('id', array(1, 2))
                ->orderBy('nombre')
                ->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.producto.create', compact('numero', 'conceptos', 'id', 'personas', 'today', 'total'));
        }
        //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }

    public function addFromDetalleService($id)
    {
        //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
        //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
        //ya se crear un nuevo registro o aperturar la caja.
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            //llamar a la sesion del carrito de servicios
            $cart = session()->get('servicio');
            $total = 0;
            //gererar el total recorriendo el array de productos 'cart'
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            //esta validación es para generar el número correlativo para la caja
            $cajaValidate = Caja::latest('id')->first();
            //si es diferente de nulo se le sumará uno al registro anterior
            if (!is_null($cajaValidate)) {
                $cajaValidate->get()->toArray();
                $numero = $cajaValidate['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                //de lo contrario se le dará el número 1 por defecto, seria de esta forma '00000001'
                $numero = $this->zero_fill(1, 8);
            }
            //enviar hacia la vista las variables u objetos que se usarán posteriormente
            $conceptos = Concepto::with('caja')
                ->whereNotIn('id', array(1, 2))
                ->orderBy('nombre')
                ->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.caja.servicio.create', compact('numero', 'conceptos', 'id', 'personas', 'today', 'total'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }
    //funcion para enviar a caja y generar la primera parte del comprobante,
    //solo es para productos seleccionados desde la habítación;
    public function storeProducto(Request $request)
    {
        //comentario es variable compartida tanto para Caja y Detallecaja
        $comentario = $request->comentario;
        //capturar datos para generar el comprobante :)
        $total = $request->total;
        $igv = (0.18) * ($total);
        $igv = round($igv, 2);
        $subtotal = $total - $igv;
        //crear número para el parámetro número de comprobante
        $comprobante = Comprobante::latest('id')->first();
        if (!is_null($comprobante)) {
            $comprobante->get()->toArray();
            $numero = $comprobante['numero'] + 1;
            $numero = $this->zero_fill($numero, 8);
        } else {
            $numero = $this->zero_fill(1, 8);
        }
        //crear el registro de caja :)
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
        //obtener id del ultimo registro de caja es decir del registro anterior 
        // y con eso pasar a la tabla DeatalleCaja cada producto seleccionado
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
        //crear el registro de comprobante con los datos que se tiene 
        $createComprobante = Comprobante::create([
            'numero' => $numero,
            'tipodocumento' => $request->tipodocumento,
            'fecha' => Carbon::now()->toDateString(),
            'igv' => $igv,
            'total' => $total,
            'subtotal' => $subtotal,
            'comentario' => $comentario
        ]);
        //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
        $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
        foreach ($productos as $key => $item) {
            $detalleComprobante = DetalleComprobante::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'producto_id' => $key,
                'comprobante_id' => $id_ComprobanteAnterior,
            ]);
        }
        //limpiar la session donde se encuentran los productos
        session()->pull('cart', []);
        //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    //funcion para enviar a caja y generar la primera parte del comprobante,
    //solo es para servicios seleccionados desde la habítación;
    public function storeServicio(Request $request)
    {
        //comentario es variable compartida tanto para Caja y Detallecaja
        $comentario = $request->comentario;
        //capturar datos para generar el comprobante :)
        $total = $request->total;
        $igv = (0.18) * ($total);
        $igv = round($igv, 2);
        $subtotal = $total - $igv;
        //crear número para el parámetro número de comprobante
        $comprobante = Comprobante::latest('id')->first();
        if (!is_null($comprobante)) {
            $comprobante->get()->toArray();
            $numero = $comprobante['numero'] + 1;
            $numero = $this->zero_fill($numero, 8);
        } else {
            $numero = $this->zero_fill(1, 8);
        }
        //crear el registro de caja :)
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
        //obtener id del ultimo registro de caja es decir del registro anterior 
        // y con eso pasar a la tabla DeatalleCaja cada producto seleccionado
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
        //crear el registro de comprobante con los datos que se tiene 
        $createComprobante = Comprobante::create([
            'numero' => $numero,
            'tipodocumento' => $request->tipodocumento,
            'fecha' => Carbon::now()->toDateString(),
            'igv' => $igv,
            'total' => $total,
            'subtotal' => $subtotal,
            'comentario' => $comentario

        ]);
        //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
        $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
        foreach ($servicios as $key => $item) {
            $detalleComprobante = DetalleComprobante::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'producto_id' => $key,
                'comprobante_id' => $id_ComprobanteAnterior,
            ]);
        }
        //limpiar la session donde se encuentran los productos
        session()->pull('servicio', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
}
