<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CajaRequest;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Procesos\Movimiento;
use App\Services\CajaService;
use App\Services\InitService;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CajaController extends Controller
{
    protected $servce;

    public function __construct()
    {
        $this->service = new CajaService();
    }

    public function index()
    {
        try {
            return $this->service->indexService();
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function buscar(Request $request)
    {
        try {
           return $this->service->searchService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function create(Request $request)
    {
        try {
            return $this->service->createService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function store(CajaRequest $request)
    {
        try {
            return $this->service->storeService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function edit($id, Request $request)
    {
        try {
            return $this->service->editService($id, $request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function update(CajaRequest $request, $id)
    {
        try {
            return $this->service->updateService($request, $id);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        } 
    }

    public function eliminar($id, $listarLuego)
    {
        try {
            return $this->service->eliminarService($id, $listarLuego);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function destroy($id)
    {
        try {
            return $this->service->destroyService($id);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function print(Request $request)
    {
        try {
            return $this->service->printService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }
    public function printA4(Request $request)
    {
        try {
            return $this->service->printA4Service($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    // public function createCheckout(Request $request, $id)
    // {
    //     //servicios adicionales
    //     $early_checkin = 0;
    //     $late_checkout = 0;
    //     $day_use = 0;
    //     //metodo de pago verficiacio
    //     $efectivo=0;
    //     $tarjeta=0;
    //     $deposito=0;
    //     $modalidad = $request->modalidadpago;
    //     $tipotarjeta = "";
    //     $fechadeposito=null;
    //     $nrooperacion="";
    //     $nombrebanco="";
    //     $urlimagen='';
    //     switch ($modalidad) {
    //         case 'efectivo':
    //             $efectivo = $request->txtEfectivoSolo;
    //             break;
    //         case 'tarjeta':
    //             $tarjeta = $request->txtTarjetaSolo;
    //             $tipotarjeta = $request->tipotarjetaSolo;                
    //             break;
    //         case 'deposito':               
    //             $fechadeposito = $request->txtFechaSoloDeposito;
    //             $nrooperacion=$request->txtNroOperacionSolo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoSolo);
    //             if(!is_null($request->imgDepositoSolo)){
    //                 $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }
    //             $deposito = $request->txtDepositoSolo;            
    //             break;
    //         case 'efectivotarjeta':
    //             $efectivo = $request->txtEfectivoTarjeta;            
    //             $tarjeta = $request->txtTarjetaEfectivo;
    //             $tipotarjeta = $request->tipotarjetaEfectivo;                
    //             break;
    //         case 'depositoefectivo':
    //             $deposito = $request->txtDepositoEfectivo;            
    //             $efectivo = $request->txtEfectivoDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoEfectivo;
    //             $nrooperacion=$request->txtNroOperacionEfectivo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
    //             if(!is_null($request->imgDepositoEfectivo)){
    //                 $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }
    //             break;
    //         case 'depositotarjeta':
    //             $deposito = $request->txtDepositoTarjeta;            
    //             $tarjeta = $request->txtTarjetaDeposito;
    //             $tipotarjeta = $request->tipotarjetaDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoTarjeta;
    //             $nrooperacion=$request->txtNroOperacionTarjeta;
    //             $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
    //             if(!is_null($request->imgDepositoTarjeta)){
    //                 $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }              
    //             break;            
    //     }


    //     if($deposito==0 && $tarjeta==0 && $efectivo==0 && $request->total!=0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
    //     }
    //     $cobrado = $deposito + $tarjeta + $efectivo;
    //     if($cobrado != $request->total){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
    //     } 
    //     if($tipotarjeta=='' && $tarjeta!=0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
    //     }

       

    //     if (is_null($early_checkin)) {
    //         $early_checkin = 0;
    //     }
    //     if (is_null($late_checkout)) {
    //         $late_checkout = 0;
    //     }
    //     if (is_null($day_use)) {
    //         $day_use = 0;
    //     }
        
    //     $persona = $request->persona;
    //     $tipoDoc = $request->tipodocumento;
    //     $verificarApertura =
    //         Caja::with('movimiento', 'persona', 'concepto')
    //         ->latest('created_at')->first()->toArray();
    //     if ($verificarApertura['concepto_id'] != '2') {
    //         $movimiento = Movimiento::findOrFail($id);
    //         //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
    //         $habitacion = Habitacion::findOrFail($request->habitacion_id);
    //         $habitacion->update([
    //             'situacion' => 'En limpieza',
    //         ]);
    //         //comprobante datos      
    //         $today = Carbon::now()->toDateString();
    //         //total sin contar lo cancelado al inicio
    //         $total = $request->total;
    //         $igv = (0.18) * ($total);
    //         $igv = round($igv, 2);
    //         $subtotal = $total - $igv;
    //         $subtotal = round(($total/1.18),2);
    //         $igv=round(($total-$subtotal),2);
            
    //         $habitacion = $request->habitacion_id;
    //         //crear numero correlativo para caja
    //         $caja = Caja::latest('id')->first();
    //         if (!is_null($caja)) {
    //             $caja->get()->toArray();
    //             $numero = $caja['numero'] + 1;
    //             $numero = $this->zero_fill($numero, 8);
    //         } else {
    //             $numero = $this->zero_fill(1, 8);
    //         }
    //         //actualiza movimiento con fecha salida, dias, total y la situación           

    //         if($request->total!=0){
    //             $movimiento->update([
    //                 'fechasalida' => $request->fechasalida,
    //                 'total' => (($request->total) + ($request->pagado)),
    //                 'situacion' => 'Pago Realizado',
    //                 'early_checkin' => $early_checkin,
    //                 'late_checkout' => $late_checkout,
    //                 'day_use' => $day_use,
    //                 'tarjeta'=>$tarjeta,
    //                 'deposito'=>$deposito,
    //                 'efectivo'=>$efectivo,
    //                 'tipotarjeta'=>$tipotarjeta,
    //                 'modalidadpago'=>$modalidad,
    //                 'fechadeposito'=>$fechadeposito,
    //                 'nrooperacion'=>$nrooperacion,
    //                 'nombrebanco'=>$nombrebanco,
    //                 'urlimagen'=>$urlimagen,
    //                 'comentario' => $request->comentario,
    //             ]);
    //         }else{
    //             $movimiento->update([
    //                 'fechasalida' => $request->fechasalida,
    //                 //'total' => (($request->total) + ($request->pagado)),
    //                 'situacion' => 'Pago Realizado',
    //                 'early_checkin' => $early_checkin,
    //                 'late_checkout' => $late_checkout,
    //                 'day_use' => $day_use,
    //                 'tarjeta'=>$tarjeta,
    //                 'deposito'=>$deposito,
    //                 'efectivo'=>$efectivo,
    //                 'tipotarjeta'=>$tipotarjeta,
    //                 'modalidadpago'=>$modalidad,
    //                 'fechadeposito'=>$fechadeposito,
    //                 'nrooperacion'=>$nrooperacion,
    //                 'nombrebanco'=>$nombrebanco,
    //                 'urlimagen'=>$urlimagen,
    //                 'comentario' => $request->comentario,
    //             ]);
    //             return response()->json(['respuesta' => 'ok-0', 'id_comprobante' => null, 'tipoDoc' => null]);
    //         }
            
    //         //guardar un nuevo registro para caja 
    //         $cajaStore = Caja::create([
    //             'fecha' => Carbon::now()->toDateTimeLocalString(),
    //             'tipo' => 'Ingreso',
    //             'numero' => $numero,
    //             'total' => $total,
    //             'persona_id' => $persona,
    //             'movimiento_id' => $id,
    //             'usuario_id' => session()->all()['usuario_id'],
    //             'concepto_id' => 3,
    //             'comentario' => $request->comentario,
    //             'modalidadpago'=>$modalidad

    //         ]);
    //         //guardar nuevo registro de comprobante
    //         $comprobante = Comprobante::create([
    //             'tipodocumento' => $request->tipodocumento,
    //             'numero' => $request->numero_comprobante,
    //             'fecha' => $today,
    //             'subtotal' => $subtotal,
    //             'total' => $total,
    //             'igv' => $igv,
    //             'comentario' => $request->comentario,
    //             'movimiento_id' => $id,
    //             'persona_id' => $persona,
    //         ]);
    //         $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
    //         $detalleComprobante = DetalleComprobante::create([
    //             'cantidad' => 1,
    //             'preciocompra' => $total - $day_use - $early_checkin - $late_checkout,
    //             'precioventa' => $total - $day_use - $early_checkin - $late_checkout,
    //             'comentario' => 'Servicio de Hotel - ' . $request->comentario,
    //             'servicio_id' => 1,
    //             'comprobante_id' => $id_ComprobanteAnterior,
    //         ]);
    //         if (($early_checkin) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $early_checkin,
    //                 'precioventa' => $early_checkin,
    //                 'comentario' => 'Early Check In - ' . $request->comentario,
    //                 'servicio_id' => 2,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         if (($late_checkout) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $late_checkout,
    //                 'precioventa' => $late_checkout,
    //                 'comentario' => 'Late Check Out - ' . $request->comentario,
    //                 'servicio_id' => 3,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         if (($day_use) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $day_use,
    //                 'precioventa' => $day_use,
    //                 'comentario' => 'Day Use - ' . $request->comentario,
    //                 'servicio_id' => 4,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);
    //     } else {
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    //     }
    // }
    // public function cobrarMovimiento(Request $request, $id)
    // {
    //     $early_checkin = 0;
    //     $late_checkout = 0;
    //     $day_use = 0;
    //     //metodo de pago verficiacion
    //     $efectivo=0;
    //     $tarjeta=0;
    //     $deposito=0;
    //     $modalidad = $request->modalidadpago;
    //     $tipotarjeta = "";
    //     $fechadeposito=null;
    //     $nrooperacion="";
    //     $nombrebanco="";
    //     $urlimagen='';
    //     switch ($modalidad) {
    //         case 'efectivo':
    //             $efectivo = $request->txtEfectivoSolo;
    //             break;
    //         case 'tarjeta':
    //             $tarjeta = $request->txtTarjetaSolo;
    //             $tipotarjeta = $request->tipotarjetaSolo;                
    //             break;
    //         case 'deposito':               
    //             $fechadeposito = $request->txtFechaSoloDeposito;
    //             $nrooperacion=$request->txtNroOperacionSolo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoSolo);
    //             if(!is_null($request->imgDepositoSolo)){
    //                 $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }
    //             $deposito = $request->txtDepositoSolo;            
    //             break;
    //         case 'efectivotarjeta':
    //             $efectivo = $request->txtEfectivoTarjeta;            
    //             $tarjeta = $request->txtTarjetaEfectivo;
    //             $tipotarjeta = $request->tipotarjetaEfectivo;                
    //             break;
    //         case 'depositoefectivo':
    //             $deposito = $request->txtDepositoEfectivo;            
    //             $efectivo = $request->txtEfectivoDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoEfectivo;
    //             $nrooperacion=$request->txtNroOperacionEfectivo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
    //             if(!is_null($request->imgDepositoEfectivo)){
    //                 $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }
    //             break;
    //         case 'depositotarjeta':
    //             $deposito = $request->txtDepositoTarjeta;            
    //             $tarjeta = $request->txtTarjetaDeposito;
    //             $tipotarjeta = $request->tipotarjetaDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoTarjeta;
    //             $nrooperacion=$request->txtNroOperacionTarjeta;
    //             $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
    //             if(!is_null($request->imgDepositoTarjeta)){
    //                 $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }              
    //             break;            
    //     }


    //     if($deposito==0 && $tarjeta==0 && $efectivo==0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
    //     }
    //     $cobrado = $deposito + $tarjeta + $efectivo;
    //     if($cobrado != $request->total){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
    //     } 
    //     if($tipotarjeta=='' && $tarjeta!=0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
    //     }
        

    //     if (is_null($early_checkin)) {
    //         $early_checkin = 0;
    //     }
    //     if (is_null($late_checkout)) {
    //         $late_checkout = 0;
    //     }
    //     if (is_null($day_use)) {
    //         $day_use = 0;
    //     }
        
    //     $persona = $request->persona;
    //     $tipoDoc = $request->tipodocumento;
    //     $verificarApertura =
    //         Caja::with('movimiento', 'persona', 'concepto')
    //         ->latest('created_at')->first()->toArray();
    //     if ($verificarApertura['concepto_id'] != '2') {
    //         $movimiento = Movimiento::findOrFail($id);
            
    //         /* //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
    //         $habitacion = Habitacion::findOrFail($request->habitacion_id);
    //         $habitacion->update([
    //             'situacion' => 'En limpieza',
    //         ]); */
    //         $habitacion = Habitacion::findOrFail($request->habitacion_id);
    //         $habitacion->update([
    //             'situacion' => 'YA PAGO',
    //         ]);
    //         //comprobante datos      
    //         $today = Carbon::now()->toDateString();
    //         $total = $request->total;
    //         $igv = (0.18) * ($total);
    //         $igv = round($igv, 2);
    //         $subtotal = $total - $igv;
    //         $subtotal = round(($total/1.18),2);
    //         $igv=round(($total-$subtotal),2);
    //         $habitacion = $request->habitacion_id;
    //         //crear numero correlativo para caja
    //         $caja = Caja::latest('id')->first();
    //         if (!is_null($caja)) {
    //             $caja->get()->toArray();
    //             $numero = $caja['numero'] + 1;
    //             $numero = $this->zero_fill($numero, 8);
    //         } else {
    //             $numero = $this->zero_fill(1, 8);
    //         }
    //         //actualiza movimiento con fecha salida, dias, total y la situación
    //         $movimiento->update([
    //             'fechasalida' => $request->fechasalida,
    //             'dias' => $request->dias,
    //             'total' => $request->total,
    //             'situacion' => 'Pago Realizado',
    //             'descuento' => $request->txtDescuento,
    //             'early_checkin' => $early_checkin,
    //             'late_checkout' => $late_checkout,
    //             'day_use' => $day_use,
    //             'tarjeta'=>$tarjeta,
    //             'deposito'=>$deposito,
    //             'efectivo'=>$efectivo,
    //             'tipotarjeta'=>$tipotarjeta,
    //             'modalidadpago'=>$modalidad,
    //             'fechadeposito'=>$fechadeposito,
    //             'nrooperacion'=>$nrooperacion,
    //             'nombrebanco'=>$nombrebanco,
    //             'urlimagen'=>$urlimagen,
    //             // 'comentario' => $request->comentario,
    //         ]);
    //         //guardar un nuevo registro para caja 
    //         $cajaStore = Caja::create([
    //             'fecha' => Carbon::now()->toDateTimeLocalString(),
    //             'tipo' => 'Ingreso',
    //             'numero' => $numero,
    //             'total' => $total,
    //             'persona_id' => $persona,
    //             'movimiento_id' => $id,
    //             'usuario_id' => session()->all()['usuario_id'],
    //             'concepto_id' => 3,
    //             'comentario' => $request->comentario . ' - Pago adelantado',
    //             'modalidadpago'=>$modalidad

    //         ]);
    //         //guardar nuevo registro de comprobante
    //         $comprobante = Comprobante::create([
    //             'tipodocumento' => $request->tipodocumento,
    //             'numero' => $request->numero_comprobante,
    //             'fecha' => $today,
    //             'subtotal' => $subtotal,
    //             'total' => $total,
    //             'igv' => $igv,
    //             'comentario' => $request->comentario . ' - Pago adelantado',
    //             'movimiento_id' => $id,
    //             'persona_id' => $persona,
    //         ]);
    //         $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
    //         $detalleComprobante = DetalleComprobante::create([
    //             'cantidad' => 1,
    //             'preciocompra' => $total - $day_use - $early_checkin - $late_checkout,
    //             'precioventa' => $total - $day_use - $early_checkin - $late_checkout,
    //             'comentario' => 'Servicio de Hotel - ' . $request->comentario,
    //             'servicio_id' => 1,
    //             'comprobante_id' => $id_ComprobanteAnterior,
    //         ]);
    //         if (($early_checkin) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $early_checkin,
    //                 'precioventa' => $early_checkin,
    //                 'comentario' => 'Early Check In - ' . $request->comentario,
    //                 'servicio_id' => 2,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         if (($late_checkout) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $late_checkout,
    //                 'precioventa' => $late_checkout,
    //                 'comentario' => 'Late Check Out - ' . $request->comentario,
    //                 'servicio_id' => 3,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         if (($day_use) != 0) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => 1,
    //                 'preciocompra' => $day_use,
    //                 'precioventa' => $day_use,
    //                 'comentario' => 'Day Use - ' . $request->comentario,
    //                 'servicio_id' => 4,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);

    //         // return redirect()
    //         //     ->route('caja')
    //         //     ->with('success', 'Registro agregado correctamente');
    //     } else {
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    //         // return redirect()
    //         //     ->route('habitaciones')
    //         //     ->with('error', 'La caja no ha sido aperturada');
    //     }
    // }
    // public function addFromDetallePdto(Request $request, $id)
    // {
    //     //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
    //     //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
    //     //ya se crear un nuevo registro o aperturar la caja.
    //     if($request->total==0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Al parecer no tiene ningún producto/servico agregado']);
    //     }
    //     $persona = $request->persona;
    //     $tipoDoc = $request->tipodocumento;
    //     $efectivo=0;
    //     $tarjeta=0;
    //     $deposito=0;
    //     $modalidad = $request->modalidadpago;
    //     $tipotarjeta = "";
    //     $fechadeposito=null;
    //     $nrooperacion="";
    //     $nombrebanco="";
    //     $urlimagen='';
    //     switch ($modalidad) {
    //         case 'efectivo':
    //             $efectivo = $request->txtEfectivoSolo;
    //             break;
    //         case 'tarjeta':
    //             $tarjeta = $request->txtTarjetaSolo;
    //             $tipotarjeta = $request->tipotarjetaSolo;                
    //             break;
    //         case 'deposito':
    //             $deposito = $request->txtDepositoSolo;   
    //             $fechadeposito = $request->txtFechaSoloDeposito;
    //             $nrooperacion=$request->txtNroOperacionSolo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoSolo);
    //             if(!is_null($request->imgDepositoSolo)){
    //                 $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }         
    //             break;
    //         case 'efectivotarjeta':
    //             $efectivo = $request->txtEfectivoTarjeta;            
    //             $tarjeta = $request->txtTarjetaEfectivo;
    //             $tipotarjeta = $request->tipotarjetaEfectivo;                
    //             break;
    //         case 'depositoefectivo':
    //             $deposito = $request->txtDepositoEfectivo;            
    //             $efectivo = $request->txtEfectivoDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoEfectivo;
    //             $nrooperacion=$request->txtNroOperacionEfectivo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
    //             if(!is_null($request->imgDepositoEfectivo)){
    //                 $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }
    //             break;
    //         case 'depositotarjeta':
    //             $deposito = $request->txtDepositoTarjeta;            
    //             $tarjeta = $request->txtTarjetaDeposito;
    //             $tipotarjeta = $request->tipotarjetaDeposito;
    //             $fechadeposito = $request->txtFechaDepositoTarjeta;
    //             $nrooperacion=$request->txtNroOperacionTarjeta;
    //             $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
    //             if(!is_null($request->imgDepositoTarjeta)){
    //                 $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }                  
    //             break;            
    //     }

    //     if($deposito==0 && $tarjeta==0 && $efectivo==0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
    //     }
    //     $cobrado = $deposito + $tarjeta + $efectivo;
    //     if($cobrado != $request->total){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
    //     } 
    //     if($tipotarjeta=='' && $tarjeta!=0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
    //     }
    //     if (is_null($persona)) {
    //         $persona = 1;
    //     }
    //     $caja =
    //         Caja::with('movimiento', 'persona', 'concepto')
    //         ->latest('created_at')->first()->toArray();
    //     if ($caja['concepto_id'] != '2') {
    //         //llamar a la sesion del carrito de productos
    //         $cart = session()->get('cart');
    //         $total = 0;
    //         //gererar el total recorriendo el array de productos 'cart'
    //         foreach ($cart as $key => $item) {
    //             $total += ($item['precio'] * $item['cantidad']);
    //         }
    //         $today = Carbon::now()->toDateString();
    //         $igv = (0.18) * ($total);
    //         $igv = round($igv, 2);
    //         $subtotal = round(($total/1.18),2);
    //         $igv=round(($total-$subtotal),2);

    //         //esta validación es para generar el número correlativo para la caja
    //         $cajaValidate = Caja::latest('id')->first();
    //         //si es diferente de nulo se le sumará uno al registro anterior
    //         if (!is_null($cajaValidate)) {
    //             $cajaValidate->get()->toArray();
    //             $numero = $cajaValidate['numero'] + 1;
    //             $numero = $this->zero_fill($numero, 8);
    //         } else {
    //             //de lo contrario se le dará el número 1 por defecto, seria de esta forma '00000001'
    //             $numero = $this->zero_fill(1, 8);
    //         }
    //         //guardar un nuevo registro para caja 
    //         $cajaStore = Caja::create([
    //             'fecha' => $request->fecha,
    //             'tipo' => 'Ingreso',
    //             'numero' => $numero,
    //             'total' => $total,
    //             'persona_id' => $persona,
    //             'usuario_id' => session()->all()['usuario_id'],
    //             'concepto_id' => 3,
    //             'comentario' => $request->comentario,
    //             'tarjeta'=>$tarjeta,
    //             'deposito'=>$deposito,
    //             'efectivo'=>$efectivo,
    //             'tipotarjeta'=>$tipotarjeta,
    //             'modalidadpago'=>$modalidad,
    //             'fechadeposito'=>$fechadeposito,
    //             'nrooperacion'=>$nrooperacion,
    //             'nombrebanco'=>$nombrebanco,
    //             'urlimagen'=>$urlimagen,
    //         ]);
    //         //obtener id del ultimo registro de caja es decir del registro anterior 
    //         // y con eso pasar a la tabla DeatalleCaja cada producto seleccionado
    //         $caja =
    //             Caja::with('movimiento', 'persona', 'concepto')
    //             ->latest('created_at')->first()->toArray();
    //         $id_caja = $caja['id'];
    //         $productos = session()->all()['cart'];
    //         foreach ($productos as $key => $item) {
    //             $detallecaja = DetalleCaja::create([
    //                 'cantidad' => $item['cantidad'],
    //                 'preciocompra' => $item['precio'],
    //                 'precioventa' => ($item['cantidad'] * $item['precio']),
    //                 'comentario' => $request->comentario,
    //                 'producto_id' => $key,
    //                 'caja_id' => $id_caja,

    //             ]);
    //         }
    //         //guardar nuevo registro de comprobante
    //         $comprobante = Comprobante::create([
    //             'tipodocumento' => $request->tipodocumento,
    //             'numero' => $request->numero_comprobante,
    //             'fecha' => $today,
    //             'subtotal' => $subtotal,
    //             'total' => $total,
    //             'igv' => $igv,
    //             'comentario' => $request->comentario,
    //             'persona_id' => $persona,

    //         ]);
    //         //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
    //         $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
    //         foreach ($productos as $key => $item) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => $item['cantidad'],
    //                 'preciocompra' => $item['precio'],
    //                 'precioventa' => ($item['cantidad'] * $item['precio']),
    //                 'comentario' => $request->comentario,
    //                 'producto_id' => $key,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         //limpiar la session donde se encuentran los productos
    //         session()->pull('cart', []);
    //         //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
    //         return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);
    //         // return redirect()
    //         //     ->route('caja')
    //         //     ->with('success', 'Registro agregado correctamente');
    //     }
    //     //si la caja no esta aperturada entonces se lo devolverpa a la vista principal con un mensaje de error
    //     // return redirect()
    //     //     ->route('habitaciones')
    //     //     ->with('error', 'La caja no ha sido aperturada');
    //     return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    // }
    // public function addFromDetalleService(Request $request, $id)
    // {
    //     //verificar si la caja esta abierta llamando al ultimo movimiento en la caja
    //     //que si su concepto_id  es diferente de '2' -> 'Concepto: Cierre Caja' dejará 
    //     //ya se crear un nuevo registro o aperturar la caja.
    //     if($request->total==0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Al parecer no tiene ningún producto/servico agregado']);
    //     }
    //     $persona = $request->persona;
    //     $tipoDoc = $request->tipodocumento;
    //     $efectivo=0;
    //     $tarjeta=0;
    //     $deposito=0;
    //     $modalidad = $request->modalidadpago;
    //     $tipotarjeta = "";
    //     $fechadeposito=null;
    //     $nrooperacion="";
    //     $nombrebanco="";
    //     $urlimagen='';
    //     switch ($modalidad) {
    //         case 'efectivo':
    //             $efectivo = $request->txtEfectivoSolo;
    //             break;
    //         case 'tarjeta':
    //             $tarjeta = $request->txtTarjetaSolo;
    //             $tipotarjeta = $request->tipotarjetaSolo;                
    //             break;
    //         case 'deposito':
    //             $deposito = $request->txtDepositoSolo;
    //             $fechadeposito = $request->txtFechaSoloDeposito;
    //             $nrooperacion=$request->txtNroOperacionSolo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoSolo);
    //             if(!is_null($request->imgDepositoSolo)){
    //                 $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }              
    //             break;
    //         case 'efectivotarjeta':
    //             $efectivo = $request->txtEfectivoTarjeta;            
    //             $tarjeta = $request->txtTarjetaEfectivo;
    //             $tipotarjeta = $request->tipotarjetaEfectivo;                
    //             break;
    //         case 'depositoefectivo':
    //             $deposito = $request->txtDepositoEfectivo;            
    //             $efectivo = $request->txtEfectivoDeposito;
    //             $fechadeposito = $request->txtFechaDepositoEfectivo;
    //             $nrooperacion=$request->txtNroOperacionEfectivo;
    //             $nombrebanco=strtoupper($request->txtNombreBancoEfectivo);
    //             if(!is_null($request->imgDepositoEfectivo)){
    //                 $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }  
    //             break;
    //         case 'depositotarjeta':
    //             $deposito = $request->txtDepositoTarjeta;            
    //             $tarjeta = $request->txtTarjetaDeposito;
    //             $tipotarjeta = $request->tipotarjetaDeposito;  
    //             $fechadeposito = $request->txtFechaDepositoTarjeta;
    //             $nrooperacion=$request->txtNroOperacionTarjeta;
    //             $nombrebanco=strtoupper($request->txtNombreBancoTarjeta);
    //             if(!is_null($request->imgDepositoTarjeta)){
    //                 $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
    //                 $urlimagen = Storage::url($imagen);
    //             }                
    //             break;            
    //     }

    //     if($deposito==0 && $tarjeta==0 && $efectivo==0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'Debe de seleccionar el método de pago']);
    //     }
    //     $cobrado = $deposito + $tarjeta + $efectivo;
    //     if($cobrado != $request->total){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'La modalidad de pago y el total no coinciden, recarge la página e intente de nuevo']);
    //     } 
    //     if($tipotarjeta=='' && $tarjeta!=0){
    //         return response()->json(['respuesta' => 'no', 'mensaje' => 'No ha seleccionado el tipo de tarjeta, recarge la página e intentelo de nuevo']);
    //     }
    //     if (is_null($persona)) {
    //         $persona = 1;
    //     }
    //     $caja =
    //         Caja::with('movimiento', 'persona', 'concepto')
    //         ->latest('created_at')->first()->toArray();
    //     if ($caja['concepto_id'] != '2') {
    //         //llamar a la sesion del carrito de servicios
    //         $cart = session()->get('servicio');
    //         $total = 0;
    //         //gererar el total recorriendo el array de productos 'cart'
    //         foreach ($cart as $key => $item) {
    //             $total += ($item['precio'] * $item['cantidad']);
    //         }
    //         $today = Carbon::now()->toDateString();
    //         $igv = (0.18) * ($total);
    //         $igv = round($igv, 2);
    //         $subtotal = $total - $igv;
    //         $subtotal = round(($total/1.18),2);
    //         $igv=round(($total-$subtotal),2);
    //         //esta validación es para generar el número correlativo para la caja
    //         $cajaValidate = Caja::latest('id')->first();
    //         //si es diferente de nulo se le sumará uno al registro anterior
    //         if (!is_null($cajaValidate)) {
    //             $cajaValidate->get()->toArray();
    //             $numero = $cajaValidate['numero'] + 1;
    //             $numero = $this->zero_fill($numero, 8);
    //         } else {
    //             //de lo contrario se le dará el número 1 por defecto, seria de esta forma '00000001'
    //             $numero = $this->zero_fill(1, 8);
    //         }
    //         //guardar un nuevo registro para caja 
    //         $cajaStore = Caja::create([
    //             'fecha' => $request->fecha,
    //             'tipo' => 'Ingreso',
    //             'numero' => $numero,
    //             'total' => $total,
    //             'persona_id' => $persona,
    //             'usuario_id' => session()->all()['usuario_id'],
    //             'concepto_id' => 3,
    //             'comentario' => $request->comentario_caja,
    //             'tarjeta'=>$tarjeta,
    //             'deposito'=>$deposito,
    //             'efectivo'=>$efectivo,
    //             'tipotarjeta'=>$tipotarjeta,
    //             'modalidadpago'=>$modalidad,
    //             'fechadeposito'=>$fechadeposito,
    //             'nrooperacion'=>$nrooperacion,
    //             'nombrebanco'=>$nombrebanco,
    //             'urlimagen'=>$urlimagen,
    //         ]);
    //         //obtener id del ultimo registro de caja es decir del registro anterior 
    //         // y con eso pasar a la tabla DeatalleCaja cada producto seleccionado
    //         $caja =
    //             Caja::with('movimiento', 'persona', 'concepto')
    //             ->latest('created_at')->first()->toArray();
    //         $id_caja = $caja['id'];
    //         $servicios = session()->all()['servicio'];
    //         foreach ($servicios as $key => $item) {
    //             $detallecaja = DetalleCaja::create([
    //                 'cantidad' => $item['cantidad'],
    //                 'preciocompra' => $item['precio'],
    //                 'precioventa' => ($item['cantidad'] * $item['precio']),
    //                 'comentario' => $request->comentario_caja,
    //                 'servicio_id' => $key,
    //                 'caja_id' => $id_caja,
    //             ]);
    //         }
    //         //guardar nuevo registro de comprobante
    //         $comprobante = Comprobante::create([
    //             'tipodocumento' => $request->tipodocumento,
    //             'numero' => $request->numero_comprobante,
    //             'fecha' => $today,
    //             'subtotal' => $subtotal,
    //             'total' => $total,
    //             'igv' => $igv,
    //             'comentario' => $request->comentario_caja,
    //             'persona_id' => $persona,

    //         ]);
    //         //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
    //         $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
    //         foreach ($servicios as $key => $item) {
    //             $detalleComprobante = DetalleComprobante::create([
    //                 'cantidad' => $item['cantidad'],
    //                 'preciocompra' => $item['precio'],
    //                 'precioventa' => ($item['cantidad'] * $item['precio']),
    //                 'comentario' => $request->comentario_caja,
    //                 'producto_id' => $key,
    //                 'comprobante_id' => $id_ComprobanteAnterior,
    //             ]);
    //         }
    //         //limpiar la session donde se encuentran los productos
    //         session()->pull('servicio', []);
    //         return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);

    //         // return redirect()
    //         //     ->route('caja')
    //         //     ->with('success', 'Registro agregado correctamente');
    //     }
    //     // return redirect()
    //     //     ->route('habitaciones')
    //     //     ->with('error', 'La caja no ha sido aperturada');
    //     return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    // }
    // public function updateHabitacion($id)
    // {

    //     //se actualiza el estado de la habitacion de 'Ocupado' a 'En limpieza'
    //     $habitacion = Habitacion::findOrFail($id);
    //     $habitacion->update([
    //         'situacion' => 'Disponible',
    //     ]);

    //     return redirect()
    //         ->route('habitaciones')
    //         ->with('success', 'Actualizado correctamente');
    // }
}
  