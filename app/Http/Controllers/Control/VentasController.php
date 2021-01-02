<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\DetalleCaja;
use App\Models\Producto;
use App\Models\Servicios;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function indexProductos(Request $request)
    {
        $search = $request->get('search');
        if (!empty($search)) {
            $productos = Producto::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $productos = Producto::get()->toArray();
        }
        return view('control.ventas.add', compact('productos'));
    }
    public function indexServicios(Request $request)
    {
        $search = $request->get('search');
        if (!empty($search)) {
            $servicios = Servicios::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $servicios = Servicios::get()->toArray();
        }
        return view('control.ventas.addServicio', compact('servicios'));
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

    public function addFromDetallePdto(Request $request)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            $cart = session()->get('cart_ventas');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $cajaID = Caja::latest('id')->first();

            if (!is_null($cajaID)) {
                $cajaID->get()->toArray();
                $numero = $cajaID['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            $comentario = $request->comentario;
            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.ventas.createProducto', compact('numero', 'conceptos', 'personas', 'today', 'total', 'comentario'));
        }
        return redirect()
            ->route('habitaciones')
            ->with('error', 'La caja no ha sido aperturada');
    }
    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
    public function addFromDetalleService(Request $request)
    {
        $caja =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
        if ($caja['concepto_id'] != '2') {
            $cart = session()->get('servicio_ventas');
            $total = 0;
            foreach ($cart as $key => $item) {
                $total += ($item['precio'] * $item['cantidad']);
            }
            $cajaID = Caja::latest('id')->first();

            if (!is_null($cajaID)) {
                $cajaID->get()->toArray();
                $numero = $cajaID['numero'] + 1;
                $numero = $this->zero_fill($numero, 8);
            } else {
                $numero = $this->zero_fill(1, 8);
            }
            $comentario = $request->comentario;
            $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
            $today = Carbon::now()->toDateString();
            $personas = Persona::with('caja', 'reserva', 'pasajero')->orderBy('nombres')->get();
            return view('control.ventas.createServicio', compact('numero', 'conceptos', 'personas', 'today', 'total', 'comentario'));
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

        session()->pull('cart_ventas', []);

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
            'comentario' => $comentario,
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
        session()->pull('servicio_ventas', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
}
