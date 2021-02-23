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
use Illuminate\Support\Facades\Storage;

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
            ->latest('created_at')->first()->toArray();

        $fecha = $caja['created_at'];

        if (!$fecha) {
            $fecha = $caja['fecha'];
        }

        $cajas =
            Caja::with('concepto', 'usuario', 'persona', 'movimiento')
            ->where('created_at', '>', $fecha)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $cajasArray= Caja::with('concepto', 'usuario', 'persona', 'movimiento')
            ->where('created_at', '>', $fecha)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();

        $totalEfectivo = 0;
        $totalTarjeta = 0;
        $totalDeposito = 0;
        $totalVisa = 0;
        $totalMaster = 0;
        $totalOtrasTarjetas = 0;
        $apertura = 0;
        $totalGeneral = 0;

        foreach ($cajasArray as $item) {
            $totalGeneral = $totalGeneral + $item['total'];
            if($item['concepto']['id']==1){
                $apertura = $item['total'];
            }
            if($item['concepto']['id']==3 && is_null($item['movimiento'])){
                $totalEfectivo=$totalEfectivo + $item['efectivo'];
                $totalTarjeta=$totalTarjeta + $item['tarjeta'];
                $totalDeposito=$totalDeposito + $item['deposito'];
                if(($item['tipotarjeta'])!=''){
                    switch ($item['tipotarjeta']) {
                        case 'visa':
                            $totalVisa = $totalVisa + $item['tarjeta'];
                            break;
                        case 'master':
                            $totalMaster = $totalMaster + $item['tarjeta'];
                            break;
                        case 'otro':
                            $totalOtrasTarjetas = $totalOtrasTarjetas + $item['tarjeta'];                            
                            break;                       
                    }
                }
            }                    
            if(!is_null($item['movimiento'])){
                $totalEfectivo=$totalEfectivo + $item['movimiento']['efectivo'];
                $totalTarjeta=$totalTarjeta + $item['movimiento']['tarjeta'];
                $totalDeposito=$totalDeposito + $item['movimiento']['deposito'];
                if(($item['movimiento']['tipotarjeta'])!=''){
                    switch ($item['movimiento']['tipotarjeta']) {
                        case 'visa':
                            $totalVisa = $totalVisa + $item['movimiento']['tarjeta'];
                            break;
                        case 'master':
                            $totalMaster = $totalMaster + $item['movimiento']['tarjeta'];
                            break;
                        case 'otro':
                            $totalOtrasTarjetas = $totalOtrasTarjetas + $item['movimiento']['tarjeta'];                            
                            break;                       
                    }
                }
            }            
        }


        $info=[
            'visa'=>$totalVisa,
            'master'=>$totalMaster,
            'otrasTarjetas'=>$totalOtrasTarjetas,
            'apertura'=>$apertura,
            'tarjetas'=>$totalTarjeta,
            'efectivo'=>$totalEfectivo,
            'depositos'=>$totalDeposito,
            'total'=>$totalGeneral,
        ];

        //dd($totalEfectivo . " " . $totalTarjeta . " " . $totalDeposito);


        return view('control.caja.index', compact('disabled', 'cajas', 'btnApertura', 'btnCerrar', 'btnNuevo','info'));
    }

    public function exportPdf()
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')->whereHas('concepto', function ($q) {
                $q->where('id', 2);
            })
            ->latest('created_at')->first()->toArray();
        
        $cajas =
            Caja::with('concepto', 'usuario', 'persona', 'movimiento')
            ->where('created_at', '>', $caja['created_at'])
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
        $data = [];
        foreach ($cajas as $item) {
            if (!is_null($item['movimiento'])) {
                $movimiento = 'Pago Servicio de Hotel Nro. : 000' . $item['movimiento']['id'];
            } else {
                $movimiento = '';
            }
            if (!is_null($item['persona'])) {
                if (!is_null($item['persona']['razonsocial']) && trim($item['persona']['razonsocial']) != '') {
                    $cliente = $item['persona']['razonsocial'];
                } else {
                    if (!is_null($item['persona'])) {
                        $cliente = $item['persona']['nombres'] . ' ' . (!is_null($item['persona']['apellidos']) ? $item['persona']['apellidos'] : ' ');
                    } else {
                        $cliente = 'VARIOS';
                    }
                }
            } else {
                $cliente = '-';
            }

            $data[] = [
                'fecha' => $item['fecha'],
                'tipo' => $item['tipo'],
                'total' => $item['total'],
                'concepto' => $item['concepto']['nombre'],
                'comentario' => isset($item['comentario']) ? $item['comentario'] : '-',
                'movimiento' => $movimiento,
                'usuario' => $item['usuario']['login'],
                'persona' => $cliente,
            ];
        }
        $pdf = PDF::loadView('pdf.caja', compact('cajas', 'data'))->setPaper('a4', 'landscape');
        return $pdf->stream('registros-list.pdf');
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
            $personas = Persona::getClientesConRucDni();
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
            $personas = Persona::getClientesConRucDni();
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
                
                    $totalEfectivo = 0;
                    $totalTarjeta = 0;
                    $totalDeposito = 0;
                    $totalVisa = 0;
                    $totalMaster = 0;
                    $totalOtrasTarjetas = 0;
                    $apertura = 0;
                    $totalGeneral = 0;
            
                    foreach ($caja as $item) {
                        $totalGeneral = $totalGeneral + $item['total'];
                        if($item['concepto']['id']==1){
                            $apertura = $item['total'];
                        }
                        if($item['concepto']['id']==3 && is_null($item['movimiento'])){
                            $totalEfectivo=$totalEfectivo + $item['efectivo'];
                            $totalTarjeta=$totalTarjeta + $item['tarjeta'];
                            $totalDeposito=$totalDeposito + $item['deposito'];
                            if(($item['tipotarjeta'])!=''){
                                switch ($item['tipotarjeta']) {
                                    case 'visa':
                                        $totalVisa = $totalVisa + $item['tarjeta'];
                                        break;
                                    case 'master':
                                        $totalMaster = $totalMaster + $item['tarjeta'];
                                        break;
                                    case 'otro':
                                        $totalOtrasTarjetas = $totalOtrasTarjetas + $item['tarjeta'];                            
                                        break;                       
                                }
                            }
                        }                    
                        if(!is_null($item['movimiento'])){
                            $totalEfectivo=$totalEfectivo + $item['movimiento']['efectivo'];
                            $totalTarjeta=$totalTarjeta + $item['movimiento']['tarjeta'];
                            $totalDeposito=$totalDeposito + $item['movimiento']['deposito'];
                            if(($item['movimiento']['tipotarjeta'])!=''){
                                switch ($item['movimiento']['tipotarjeta']) {
                                    case 'visa':
                                        $totalVisa = $totalVisa + $item['movimiento']['tarjeta'];
                                        break;
                                    case 'master':
                                        $totalMaster = $totalMaster + $item['movimiento']['tarjeta'];
                                        break;
                                    case 'otro':
                                        $totalOtrasTarjetas = $totalOtrasTarjetas + $item['movimiento']['tarjeta'];                            
                                        break;                       
                                }
                            }
                        }            
                    }
            
            
                    $info=[
                        'visa'=>$totalVisa,
                        'master'=>$totalMaster,
                        'otrasTarjetas'=>$totalOtrasTarjetas,
                        'apertura'=>$apertura,
                        'tarjetas'=>$totalTarjeta,
                        'efectivo'=>$totalEfectivo,
                        'depositos'=>$totalDeposito,
                        'total'=>$totalGeneral,
                    ];

                $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
                $today = Carbon::now()->toDateString();
                $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
                return view('control.caja.cierre.create', compact('numero', 'total', 'conceptos', 'personas', 'today', 'info'));
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
        //servicios adicionales
        $early_checkin = $request->early_checkin;
        $late_checkout = $request->late_checkout;
        $day_use = $request->day_use;
        //metodo de pago verficiacio
        $efectivo=0;
        $tarjeta=0;
        $deposito=0;
        $modalidad = $request->modalidadpago;
        $tipotarjeta = "";
        $fechadeposito="";
        $nrooperacion="";
        $nombrebanco="";
        $urlimagen='';
        switch ($modalidad) {
            case 'efectivo':
                $efectivo = $request->txtEfectivoSolo;
                break;
            case 'tarjeta':
                $tarjeta = $request->txtTarjetaSolo;
                $tipotarjeta = $request->tipotarjetaSolo;                
                break;
            case 'deposito':               
                $fechadeposito = $request->txtFechaSoloDeposito;
                $nrooperacion=$request->txtNroOperacionSolo;
                $nombrebanco=strtoupper($request->txtNombreBancoSolo);
                if(!is_null($request->imgDepositoSolo)){
                    $imagen = $request->file('imgDepositoSolo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }
                $deposito = $request->txtDepositoSolo;            
                break;
            case 'efectivotarjeta':
                $efectivo = $request->txtEfectivoTarjeta;            
                $tarjeta = $request->txtTarjetaEfectivo;
                $tipotarjeta = $request->tipotarjetaEfectivo;                
                break;
            case 'depositoefectivo':
                $deposito = $request->txtDepositoEfectivo;            
                $efectivo = $request->txtEfectivoDeposito;  
                $fechadeposito = $request->txtFechaDepositoEfectivo;
                $nrooperacion=$request->txtNroOperacionEfectivo;
                $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
                if(!is_null($request->imgDepositoEfectivo)){
                    $imagen = $request->file('imgDepositoEfectivo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }
                break;
            case 'depositotarjeta':
                $deposito = $request->txtDepositoTarjeta;            
                $tarjeta = $request->txtTarjetaDeposito;
                $tipotarjeta = $request->tipotarjetaDeposito;  
                $fechadeposito = $request->txtFechaDepositoTarjeta;
                $nrooperacion=$request->txtNroOperacionTarjeta;
                $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
                if(!is_null($request->imgDepositoTarjeta)){
                    $imagen = $request->file('imgDepositoTarjeta')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }              
                break;            
        }


        if($deposito==0 && $tarjeta==0 && $efectivo==0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
        }
        $cobrado = $deposito + $tarjeta + $efectivo;
        if($cobrado != $request->total){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
        } 
        if($tipotarjeta=='' && $tarjeta!=0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
        }
        

        if (is_null($early_checkin)) {
            $early_checkin = 0;
        }
        if (is_null($late_checkout)) {
            $late_checkout = 0;
        }
        if (is_null($day_use)) {
            $day_use = 0;
        }
        
        $persona = $request->persona;
        $tipoDoc = $request->tipodocumento;
        $verificarApertura =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($verificarApertura['concepto_id'] != '2') {
            $movimiento = Movimiento::findOrFail($id);
            //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
            $habitacion = Habitacion::findOrFail($request->habitacion_id);
            $habitacion->update([
                'situacion' => 'En limpieza',
            ]);
            //comprobante datos      
            $today = Carbon::now()->toDateString();
            $total = $request->total;
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
            $habitacion = $request->habitacion_id;
            //crear numero correlativo para caja
            $caja = Caja::latest('id')->first();
            if (!is_null($caja)) {
                $caja->get()->toArray();
                $numero = $caja['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            //actualiza movimiento con fecha salida, dias, total y la situación
            $movimiento->update([
                'fechasalida' => $request->fechasalida,
                'dias' => $request->dias,
                'total' => $request->total,
                'situacion' => 'Pago Realizado',
                'descuento' => $request->txtDescuento,
                'early_checkin' => $early_checkin,
                'late_checkout' => $late_checkout,
                'day_use' => $day_use,
                'tarjeta'=>$tarjeta,
                'deposito'=>$deposito,
                'efectivo'=>$efectivo,
                'tipotarjeta'=>$tipotarjeta,
                'modalidadpago'=>$modalidad,
                'fechadeposito'=>$fechadeposito,
                'nrooperacion'=>$nrooperacion,
                'nombrebanco'=>$nombrebanco,
                'urlimagen'=>$urlimagen,
                // 'comentario' => $request->comentario,
            ]);
            //guardar un nuevo registro para caja 
            $cajaStore = Caja::create([
                'fecha' => Carbon::now()->toDateTimeLocalString(),
                'tipo' => 'Ingreso',
                'numero' => $numero,
                'total' => $total,
                'persona_id' => $persona,
                'movimiento_id' => $id,
                'usuario_id' => session()->all()['usuario_id'],
                'concepto_id' => 3,
                'comentario' => $request->comentario,
                'modalidadpago'=>$modalidad

            ]);
            //guardar nuevo registro de comprobante
            $comprobante = Comprobante::create([
                'tipodocumento' => $request->tipodocumento,
                'numero' => $request->numero_comprobante,
                'fecha' => $today,
                'subtotal' => $subtotal,
                'total' => $total,
                'igv' => $igv,
                'comentario' => $request->comentario,
                'movimiento_id' => $id,
                'persona_id' => $persona,
            ]);
            $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
            $detalleComprobante = DetalleComprobante::create([
                'cantidad' => 1,
                'preciocompra' => $total - $day_use - $early_checkin - $late_checkout,
                'precioventa' => $total - $day_use - $early_checkin - $late_checkout,
                'comentario' => 'Servicio de Hotel - ' . $request->comentario,
                'servicio_id' => 1,
                'comprobante_id' => $id_ComprobanteAnterior,
            ]);
            if (($early_checkin) != 0) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => 1,
                    'preciocompra' => $early_checkin,
                    'precioventa' => $early_checkin,
                    'comentario' => 'Early Check In - ' . $request->comentario,
                    'servicio_id' => 2,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            if (($late_checkout) != 0) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => 1,
                    'preciocompra' => $late_checkout,
                    'precioventa' => $late_checkout,
                    'comentario' => 'Late Check Out - ' . $request->comentario,
                    'servicio_id' => 3,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            if (($day_use) != 0) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => 1,
                    'preciocompra' => $day_use,
                    'precioventa' => $day_use,
                    'comentario' => 'Day Use - ' . $request->comentario,
                    'servicio_id' => 4,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);

            // return redirect()
            //     ->route('caja')
            //     ->with('success', 'Registro agregado correctamente');
        } else {
            return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
            // return redirect()
            //     ->route('habitaciones')
            //     ->with('error', 'La caja no ha sido aperturada');
        }
    }
    public function addFromDetallePdto(Request $request, $id)
    {
        //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
        //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
        //ya se crear un nuevo registro o aperturar la caja.
        if($request->total==0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'Al parecer no tiene ningún producto/servico agregado']);
        }
        $persona = $request->persona;
        $tipoDoc = $request->tipodocumento;
        $efectivo=0;
        $tarjeta=0;
        $deposito=0;
        $modalidad = $request->modalidadpago;
        $tipotarjeta = "";
        $fechadeposito="";
        $nrooperacion="";
        $nombrebanco="";
        $urlimagen='';
        switch ($modalidad) {
            case 'efectivo':
                $efectivo = $request->txtEfectivoSolo;
                break;
            case 'tarjeta':
                $tarjeta = $request->txtTarjetaSolo;
                $tipotarjeta = $request->tipotarjetaSolo;                
                break;
            case 'deposito':
                $deposito = $request->txtDepositoSolo;   
                $fechadeposito = $request->txtFechaSoloDeposito;
                $nrooperacion=$request->txtNroOperacionSolo;
                $nombrebanco=strtoupper($request->txtNombreBancoSolo);
                if(!is_null($request->imgDepositoSolo)){
                    $imagen = $request->file('imgDepositoSolo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }         
                break;
            case 'efectivotarjeta':
                $efectivo = $request->txtEfectivoTarjeta;            
                $tarjeta = $request->txtTarjetaEfectivo;
                $tipotarjeta = $request->tipotarjetaEfectivo;                
                break;
            case 'depositoefectivo':
                $deposito = $request->txtDepositoEfectivo;            
                $efectivo = $request->txtEfectivoDeposito;  
                $fechadeposito = $request->txtFechaDepositoEfectivo;
                $nrooperacion=$request->txtNroOperacionEfectivo;
                $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
                if(!is_null($request->imgDepositoEfectivo)){
                    $imagen = $request->file('imgDepositoEfectivo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }
                break;
            case 'depositotarjeta':
                $deposito = $request->txtDepositoTarjeta;            
                $tarjeta = $request->txtTarjetaDeposito;
                $tipotarjeta = $request->tipotarjetaDeposito;
                $fechadeposito = $request->txtFechaDepositoTarjeta;
                $nrooperacion=$request->txtNroOperacionTarjeta;
                $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
                if(!is_null($request->imgDepositoTarjeta)){
                    $imagen = $request->file('imgDepositoTarjeta')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }                  
                break;            
        }

        if($deposito==0 && $tarjeta==0 && $efectivo==0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
        }
        $cobrado = $deposito + $tarjeta + $efectivo;
        if($cobrado != $request->total){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
        } 
        if($tipotarjeta=='' && $tarjeta!=0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
        }
        if (is_null($persona)) {
            $persona = 1;
        }
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
            $today = Carbon::now()->toDateString();
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
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
            //guardar un nuevo registro para caja 
            $cajaStore = Caja::create([
                'fecha' => $request->fecha,
                'tipo' => 'Ingreso',
                'numero' => $numero,
                'total' => $total,
                'persona_id' => $persona,
                'usuario_id' => session()->all()['usuario_id'],
                'concepto_id' => 3,
                'comentario' => $request->comentario,
                'tarjeta'=>$tarjeta,
                'deposito'=>$deposito,
                'efectivo'=>$efectivo,
                'tipotarjeta'=>$tipotarjeta,
                'modalidadpago'=>$modalidad,
                'fechadeposito'=>$fechadeposito,
                'nrooperacion'=>$nrooperacion,
                'nombrebanco'=>$nombrebanco,
                'urlimagen'=>$urlimagen,
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
                    'comentario' => $request->comentario,
                    'producto_id' => $key,
                    'caja_id' => $id_caja,

                ]);
            }
            //guardar nuevo registro de comprobante
            $comprobante = Comprobante::create([
                'tipodocumento' => $request->tipodocumento,
                'numero' => $request->numero_comprobante,
                'fecha' => $today,
                'subtotal' => $subtotal,
                'total' => $total,
                'igv' => $igv,
                'comentario' => $request->comentario,
                'persona_id' => $persona,

            ]);
            //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
            $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
            foreach ($productos as $key => $item) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => $item['cantidad'],
                    'preciocompra' => $item['precio'],
                    'precioventa' => ($item['cantidad'] * $item['precio']),
                    'comentario' => $request->comentario,
                    'producto_id' => $key,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            //limpiar la session donde se encuentran los productos
            session()->pull('cart', []);
            //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
            return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);
            // return redirect()
            //     ->route('caja')
            //     ->with('success', 'Registro agregado correctamente');
        }
        //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
        // return redirect()
        //     ->route('habitaciones')
        //     ->with('error', 'La caja no ha sido aperturada');
        return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    }
    public function addFromDetalleService(Request $request, $id)
    {
        //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
        //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
        //ya se crear un nuevo registro o aperturar la caja.
        if($request->total==0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'Al parecer no tiene ningún producto/servico agregado']);
        }
        $persona = $request->persona;
        $tipoDoc = $request->tipodocumento;
        $efectivo=0;
        $tarjeta=0;
        $deposito=0;
        $modalidad = $request->modalidadpago;
        $tipotarjeta = "";
        $fechadeposito="";
        $nrooperacion="";
        $nombrebanco="";
        $urlimagen='';
        switch ($modalidad) {
            case 'efectivo':
                $efectivo = $request->txtEfectivoSolo;
                break;
            case 'tarjeta':
                $tarjeta = $request->txtTarjetaSolo;
                $tipotarjeta = $request->tipotarjetaSolo;                
                break;
            case 'deposito':
                $deposito = $request->txtDepositoSolo;
                $fechadeposito = $request->txtFechaSoloDeposito;
                $nrooperacion=$request->txtNroOperacionSolo;
                $nombrebanco=strtoupper($request->txtNombreBancoSolo);
                if(!is_null($request->imgDepositoSolo)){
                    $imagen = $request->file('imgDepositoSolo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }              
                break;
            case 'efectivotarjeta':
                $efectivo = $request->txtEfectivoTarjeta;            
                $tarjeta = $request->txtTarjetaEfectivo;
                $tipotarjeta = $request->tipotarjetaEfectivo;                
                break;
            case 'depositoefectivo':
                $deposito = $request->txtDepositoEfectivo;            
                $efectivo = $request->txtEfectivoDeposito;
                $fechadeposito = $request->txtFechaDepositoEfectivo;
                $nrooperacion=$request->txtNroOperacionEfectivo;
                $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
                if(!is_null($request->imgDepositoEfectivo)){
                    $imagen = $request->file('imgDepositoEfectivo')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }  
                break;
            case 'depositotarjeta':
                $deposito = $request->txtDepositoTarjeta;            
                $tarjeta = $request->txtTarjetaDeposito;
                $tipotarjeta = $request->tipotarjetaDeposito;  
                $fechadeposito = $request->txtFechaDepositoTarjeta;
                $nrooperacion=$request->txtNroOperacionTarjeta;
                $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
                if(!is_null($request->imgDepositoTarjeta)){
                    $imagen = $request->file('imgDepositoTarjeta')->store('public/depositos');
                    $urlimagen = Storage::url($imagen);
                }                
                break;            
        }

        if($deposito==0 && $tarjeta==0 && $efectivo==0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
        }
        $cobrado = $deposito + $tarjeta + $efectivo;
        if($cobrado != $request->total){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
        } 
        if($tipotarjeta=='' && $tarjeta!=0){
            return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
        }
        if (is_null($persona)) {
            $persona = 1;
        }
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
            $today = Carbon::now()->toDateString();
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
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
            //guardar un nuevo registro para caja 
            $cajaStore = Caja::create([
                'fecha' => $request->fecha,
                'tipo' => 'Ingreso',
                'numero' => $numero,
                'total' => $total,
                'persona_id' => $persona,
                'usuario_id' => session()->all()['usuario_id'],
                'concepto_id' => 3,
                'comentario' => $request->comentario_caja,
                'tarjeta'=>$tarjeta,
                'deposito'=>$deposito,
                'efectivo'=>$efectivo,
                'tipotarjeta'=>$tipotarjeta,
                'modalidadpago'=>$modalidad,
                'fechadeposito'=>$fechadeposito,
                'nrooperacion'=>$nrooperacion,
                'nombrebanco'=>$nombrebanco,
                'urlimagen'=>$urlimagen,
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
                    'comentario' => $request->comentario_caja,
                    'servicio_id' => $key,
                    'caja_id' => $id_caja,
                ]);
            }
            //guardar nuevo registro de comprobante
            $comprobante = Comprobante::create([
                'tipodocumento' => $request->tipodocumento,
                'numero' => $request->numero_comprobante,
                'fecha' => $today,
                'subtotal' => $subtotal,
                'total' => $total,
                'igv' => $igv,
                'comentario' => $request->comentario_caja,
                'persona_id' => $persona,

            ]);
            //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
            $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
            foreach ($servicios as $key => $item) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => $item['cantidad'],
                    'preciocompra' => $item['precio'],
                    'precioventa' => ($item['cantidad'] * $item['precio']),
                    'comentario' => $request->comentario_caja,
                    'producto_id' => $key,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            //limpiar la session donde se encuentran los productos
            session()->pull('servicio', []);
            return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);

            // return redirect()
            //     ->route('caja')
            //     ->with('success', 'Registro agregado correctamente');
        }
        // return redirect()
        //     ->route('habitaciones')
        //     ->with('error', 'La caja no ha sido aperturada');
        return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    }
    public function updateHabitacion($id)
    {

        //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->update([
            'situacion' => 'Disponible',
        ]);

        return redirect()
            ->route('habitaciones')
            ->with('success', 'Actualizado correctamente');
    }
}
    /* //funcion para enviar a caja y generar la primera parte del comprobante,
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
    } */
    //funcion para enviar a caja y generar la primera parte del comprobante,
    //solo es para servicios seleccionados desde la habítación;
    /* public function storeServicio(Request $request)
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
    } */


    /* public function checkout(Request $request, $id)
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
    } */

    //esta funcion es para generar el comprobante de un movimiento cuando se hace checkout
    /* 
    //estax funciones addFromDetallePdto y addFromDetalleService se encargara de verificar 
    //si la caja esta aperturada o no, además de enviar
    //los datos necesarios que serán utilizados en la vista para agregarlo a las tablas caja,
    //comprobante y/o detalleComprobante
    
 */
