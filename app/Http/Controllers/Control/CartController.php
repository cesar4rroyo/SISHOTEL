<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Servicios;
use Illuminate\Contracts\Session\Session;

class CartController extends Controller
{
    // producto cart controller

    public function addToCart($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            abort(404);
        }
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => [
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precioventa,
                    'cantidad' => 1,
                ]
            ];
            session()->put('cart', $cart);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }
        if (isset($cart[$id])) {
            $cart[$id]['cantidad']++;
            session()->put('cart', $cart);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }

        $cart[$id] = [
            "nombre" => $producto->nombre,
            "precio" => $producto->precioventa,
            "cantidad" => 1
        ];
        session()->put('cart', $cart);

        return response()->json(['respuesta' => 'Se agregó correctamente']);
    }


    public function update(Request $request)
    {
        if ($request->id and $request->cantidad) {
            $cart = session()->get('cart');
            $cart[$request->id]["cantidad"] = $request->cantidad;
            session()->put('cart', $cart);
            // session()->flash('success', 'Cart updated successfully');
        }
        return response()->json(['respuesta' => 'Se actualizó correctamente']);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
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
        $servicio = session()->get('servicio');
        if (!$servicio) {
            $servicio = [
                $id => [
                    'nombre' => $servicios->nombre,
                    'precio' => $servicios->precio,
                    'cantidad' => 1,
                ]
            ];
            session()->put('servicio', $servicio);

            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }
        if (isset($servicio[$id])) {
            $servicio[$id]['cantidad']++;
            session()->put('servicio', $servicio);
            return response()->json(['respuesta' => 'Se agregó correctamente']);
        }

        $servicio[$id] = [
            "nombre" => $servicios->nombre,
            "precio" => $servicios->precio,
            "cantidad" => 1
        ];
        session()->put('servicio', $servicio);

        return response()->json(['respuesta' => 'Se agregó correctamente']);
    }
    public function updateServicioCart(Request $request)
    {
        if ($request->id and $request->cantidad) {
            $servicio = session()->get('servicio');
            $servicio[$request->id]["cantidad"] = $request->cantidad;
            session()->put('servicio', $servicio);
            // session()->flash('success', 'Cart updated successfully');
        }
        return response()->json(['respuesta' => 'Se actualizó correctamente']);
    }

    public function removeServicoCart(Request $request)
    {
        if ($request->id) {
            $servicio = session()->get('servicio');
            if (isset($servicio[$request->id])) {
                unset($servicio[$request->id]);
                session()->put('servicio', $servicio);
            }
            return response()->json(['respuesta' => 'Se eliminó correctamente']);
        }
    }
}
