<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Producto;
use App\Models\Servicios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class VentasController extends Controller
{
    public function getComprobanteNumero($tipo)
    {
        $serieFacturacion = env('SERIE_FACTURACION');
        $comprobante = Comprobante::latest('id')
            ->where('tipodocumento', $tipo)
            ->first();
        if (!is_null($comprobante)) {
            $comprobante->get()->toArray();
            $separar = explode('-', $comprobante['numero']);
            $numero = $separar[1] + 1;
            $numero = $this->zero_fill($numero, 8);
            $yearActual = Carbon::now()->year;
            if ($tipo == 'boleta') {
                $numero = 'B'.$serieFacturacion.'-' . $numero;
            } else if ($tipo == 'factura') {
                $numero = 'F'.$serieFacturacion.'-' . $numero;
            } else if ($tipo == 'ticket') {
                $numero = 'T'.$serieFacturacion.'-' . $numero;
            }
        } else {
            $numero = $this->zero_fill(1, 8);
            $yearActual = Carbon::now()->year;
            if ($tipo == 'boleta') {
                $numero = 'B'.$serieFacturacion.'-' . $numero;
            } else if ($tipo == 'factura') {
                $numero = 'F'.$serieFacturacion.'-' . $numero;
            } else if ($tipo == 'ticket') {
                $numero = 'T'.$serieFacturacion.'-' . $numero;
            }
        }
        return response()->json($numero);
    }
    public function indexProductos(Request $request)
    {
        $serieFacturacion = env('SERIE_FACTURACION');
        $search = $request->get('search');
        $personas = Persona::getClientesConRucDni();
        $comprobante = Comprobante::latest('id')
            ->where('tipodocumento', 'boleta')
            ->first();

        if (!is_null($comprobante)) {
            $comprobante->get()->toArray();
            $separar = explode('-', $comprobante['numero']);
            $numero = $separar[1] + 1;
            $numero = $this->zero_fill($numero, 8);
            $yearActual = Carbon::now()->year;
            $numero = 'B'.$serieFacturacion.'-' . $numero;
        } else {
            $numero = $this->zero_fill(1, 8);
            $yearActual = Carbon::now()->year;
            $numero = 'B'.$serieFacturacion.'-' . $numero;
        }
        if (!empty($search)) {
            $productos = Producto::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $productos = Producto::get()->toArray();
        }
        return view('control.ventas.add', compact('numero', 'personas', 'productos'));
    }
    public function indexServicios(Request $request)
    {
        $serieFacturacion = env('SERIE_FACTURACION');
        $search = $request->get('search');
        $personas = Persona::getClientesConRucDni();
        $comprobante = Comprobante::latest('id')
            ->where('tipodocumento', 'boleta')
            ->first();
        if (!is_null($comprobante)) {
            $comprobante->get()->toArray();
            $separar = explode('-', $comprobante['numero']);
            $numero = $separar[1] + 1;
            $numero = $this->zero_fill($numero, 8);
            $yearActual = Carbon::now()->year;
            $numero = 'B'.$serieFacturacion.'-' . $numero;
        } else {
            $numero = $this->zero_fill(1, 8);
            $yearActual = Carbon::now()->year;
            $numero = 'B'.$serieFacturacion.'-' . $numero;
        }
        if (!empty($search)) {
            $servicios =
                Servicios::where('nombre', 'LIKE', '%' . $search . '%')
                ->whereNotIn('id', [1, 2, 3, 4, 6])
                ->get()
                ->toArray();
        } else {
            $servicios = Servicios::whereNotIn('id', [1, 2, 3, 4, 6])
                ->get()
                ->toArray();
        }
        return view('control.ventas.addServicio', compact('personas', 'numero', 'servicios'));
    }
    public function addToCart($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            abort(404);
        }
        $cart = session()->get('cart_ventas');

        if (!$cart) {
            $cart = [
                $id => [
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precioventa,
                    'cantidad' => 1,
                ]
            ];
            session()->put('cart_ventas', $cart);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }
        if (isset($cart[$id])) {
            $cart[$id]['cantidad']++;
            session()->put('cart_ventas', $cart);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }

        $cart[$id] = [
            "nombre" => $producto->nombre,
            "precio" => $producto->precioventa,
            "cantidad" => 1
        ];
        session()->put('cart_ventas', $cart);

        return response()->json(['respuesta' => 'Se agregó correctamente']);
    }


    public function update(Request $request)
    {
        if ($request->id and $request->cantidad) {
            $cart = session()->get('cart_ventas');
            $cart[$request->id]["cantidad"] = $request->cantidad;
            session()->put('cart_ventas', $cart);
            // session()->flash('success', 'Cart updated successfully');
        }
        return response()->json(['respuesta' => 'Se actualizó correctamente']);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart_ventas');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart_ventas', $cart);
            }
            return response()->json(['respuesta' => 'Se eliminó correctamente']);
        }
    }
    // servicio cart controller

    public function addServiceToCart($id)
    {
        $servicios = Servicios::find($id);
        if (!$servicios) {
            abort(404);
        }
        $servicio = session()->get('servicio_ventas');
        if (!$servicio) {
            $servicio = [
                $id => [
                    'nombre' => $servicios->nombre,
                    'precio' => $servicios->precio,
                    'cantidad' => 1,
                ]
            ];
            session()->put('servicio_ventas', $servicio);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }
        if (isset($servicio[$id])) {
            $servicio[$id]['cantidad']++;
            session()->put('servicio_ventas', $servicio);
            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }

        $servicio[$id] = [
            "nombre" => $servicios->nombre,
            "precio" => $servicios->precio,
            "cantidad" => 1
        ];
        session()->put('servicio_ventas', $servicio);

        return response()->json(['respuesta' => 'Se agregó correctamente']);
    }
    public function updateServicioCart(Request $request)
    {
        if ($request->id and $request->cantidad) {
            $servicio = session()->get('servicio_ventas');
            $servicio[$request->id]["cantidad"] = $request->cantidad;
            session()->put('servicio_ventas', $servicio);
            // session()->flash('success', 'Cart updated successfully');
        }
        return response()->json(['respuesta' => 'Se actualizó correctamente']);
    }

    public function removeServicoCart(Request $request)
    {
        if ($request->id) {
            $servicio = session()->get('servicio_ventas');
            if (isset($servicio[$request->id])) {
                unset($servicio[$request->id]);
                session()->put('servicio_ventas', $servicio);
            }
            return response()->json(['respuesta' => 'Se eliminó correctamente']);
        }
    }
    //esta funcion es para generar los ceros a la izquierda de un número
    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
    //estax funciones addFromDetallePdto y addFromDetalleService se encargara de verificar 
    //si la caja esta aperturada o no, además de enviar
    //los datos necesarios que serán utilizados en la vista para agregarlo a las tablas caja,
    //comprobante y/o detalleComprobante
    public function addFromDetallePdto(Request $request)
    {
        $persona = $request->persona;
        $tipoDoc = $request->tipodocumento;
        $efectivo=0;
        $tarjeta=0;
        $deposito=0;
        $modalidad = $request->modalidadpago;
        $tipotarjeta = "";
        $fechadeposito=null;
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
                    $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
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
                    $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
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
                    $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
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
            $cart = session()->get('cart_ventas');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
            $subtotal = round(($total/1.18),2);
            $igv=round(($total-$subtotal),2);

            $cajaID = Caja::latest('id')->first();
            if (!is_null($cajaID)) {
                $cajaID->get()->toArray();
                $numero = $cajaID['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            $comentario = $request->comentario;
            $today = Carbon::now()->toDateString();
            //guardar un nuevo registro para caja 
            $cajaStore = Caja::create([
                'fecha' => $request->fecha,
                'tipo' => 'Ingreso',
                'numero' => $numero,
                'total' => $total,
                'persona_id' => $persona,
                'usuario_id' => session()->all()['usuario_id'],
                'concepto_id' => 3,
                'comentario' => $comentario,
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
            $caja =
                Caja::with('movimiento', 'persona', 'concepto')
                ->latest('created_at')->first()->toArray();
            $id_caja = $caja['id'];
            $productos = session()->all()['cart_ventas'];
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
                'numero' => $request->numero_comprobante,
                'tipodocumento' => $request->tipodocumento,
                'fecha' => $today,
                'igv' => $igv,
                'total' => $total,
                'subtotal' => $subtotal,
                'comentario' => $comentario,
                'persona_id' => $persona,

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
            session()->pull('cart_ventas', []);

            return response()->json(['respuesta' => 'ok', 'id_comprobante' => $id_ComprobanteAnterior, 'tipoDoc' => $tipoDoc]);
            // return redirect()
            //     ->route('caja')
            //     ->with('success', 'Registro agregado correctamente');
        }
        return response()->json(['respuesta' => 'no', 'mensaje' => 'La caja no ha sido aperturada']);
    }

    public function addFromDetalleService(Request $request)
    {
        $persona = $request->persona;
        $tipoDoc = $request->tipodocumento;
        $efectivo=0;
        $tarjeta=0;
        $deposito=0;
        $modalidad = $request->modalidadpago;
        $tipotarjeta = "";
        $fechadeposito=null;
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
                    $imagen = $request->file('imgDepositoSolo')->storeAs('public/depositos', $request->fecha.'.jpg');
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
                    $imagen = $request->file('imgDepositoEfectivo')->storeAs('public/depositos', $request->fecha.'.jpg');
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
                    $imagen = $request->file('imgDepositoTarjeta')->storeAs('public/depositos', $request->fecha.'.jpg');
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
            $cart = session()->get('servicio_ventas');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $igv = (0.18) * ($total);
            $igv = round($igv, 2);
            $subtotal = $total - $igv;
            $subtotal = round(($total/1.18),2);
            $igv=round(($total-$subtotal),2);

            $cajaID = Caja::latest('id')->first();

            if (!is_null($cajaID)) {
                $cajaID->get()->toArray();
                $numero = $cajaID['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            $comentario = $request->comentario;
            $today = Carbon::now()->toDateString();

            //crear el registro de caja :)
            $cajaAdd = Caja::create([
                'fecha' => $request->fecha,
                'numero' => $numero,
                'concepto_id' => 3,
                'tipo' => 'Ingreso',
                'persona_id' => $persona,
                'total' => $total,
                'comentario' => $comentario,
                'usuario_id' => session()->all()['usuario_id'],
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
            $caja =
                Caja::with('movimiento', 'persona', 'concepto')
                ->latest('created_at')->first()->toArray();
            $id_caja = $caja['id'];
            $servicios = session()->all()['servicio_ventas'];
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
                'numero' => $request->numero_comprobante,
                'tipodocumento' => $request->tipodocumento,
                'fecha' => $today,
                'igv' => $igv,
                'total' => $total,
                'subtotal' => $subtotal,
                'comentario' => $comentario,
                'persona_id' => $persona,

            ]);
            //traer el id del comprobante generado anteriormente para relacionarlo con DetalleComprobante
            $id_ComprobanteAnterior = Comprobante::latest('id')->first()->toArray()['id'];
            foreach ($servicios as $key => $item) {
                $detalleComprobante = DetalleComprobante::create([
                    'cantidad' => $item['cantidad'],
                    'preciocompra' => $item['precio'],
                    'precioventa' => ($item['cantidad'] * $item['precio']),
                    'comentario' => $comentario,
                    'servicio_id' => $key,
                    'comprobante_id' => $id_ComprobanteAnterior,
                ]);
            }
            //limpiar la session donde se encuentran los productos
            session()->pull('servicio_ventas', []);
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
}
    /*  //funcion para enviar a caja y generar la primera parte del comprobante,
    //solo es para productos que no pertenezca a ninguna habitacion;
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
            'total' => $total,
            'comentario' => $comentario,
            'usuario_id' => session()->all()['usuario_id'],
        ]);
        //obtener id del ultimo registro de caja es decir del registro anterior 
        // y con eso pasar a la tabla DeatalleCaja cada producto seleccionado
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        $id_caja = $caja['id'];
        $productos = session()->all()['cart_ventas'];
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
        session()->pull('cart_ventas', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    //funcion para enviar a caja y generar la primera parte del comprobante,
    //solo es para servicios que no pertenezca a ninguna habitacion;
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
            'comentario' => $comentario,
            'usuario_id' => session()->all()['usuario_id'],
        ]);
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();

        $id_caja = $caja['id'];
        $servicios = session()->all()['servicio_ventas'];
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
        session()->pull('servicio_ventas', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    } */
