<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Producto;
use App\Models\Servicios;
use Carbon\Carbon;

class DetalleMovimientoController extends Controller
{
    public function create($id)
    {

        return view('control.detallemovimientos.add');
    }
    //consultar servicios search
    public function servicios($id, Request $request)
    {

        $search = $request->get('search');
        if (!empty($search)) {
            $servicios = Servicios::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $servicios = Servicios::get()->toArray();
        }

        $movimientos =
            Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
            ->whereHas('habitacion', function ($q) use ($id) {
                $q->where('id', $id);
            })->latest('fechaingreso')->first()->toArray();
        return view('control.detallemovimientos.addServicio', compact('servicios', 'movimientos', 'id'));
    }
    //consultar productos search
    public function productos($id, Request $request)
    {
        $search = $request->get('search');
        if (!empty($search)) {
            $productos = Producto::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $productos = Producto::get()->toArray();
        }
        $movimientos =
            Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
            ->whereHas('habitacion', function ($q) use ($id) {
                $q->where('id', $id);
            })->latest('fechaingreso')->first()->toArray();
        return view('control.detallemovimientos.add', compact('productos', 'movimientos', 'id'));
    }
    public function movimiento($id, $movimiento = null)
    {

        if (is_null($movimiento)) {
            $productos = Producto::get()->toArray();
            $movimientos =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
            return view('control.detallemovimientos.add', compact('productos', 'movimientos', 'id'));
        } else {
            $servicios = Servicios::get()->toArray();
            $movimientos =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
            return view('control.detallemovimientos.addServicio', compact('servicios', 'movimientos', 'id'));
        }
    }
    /**
     Guardar productos
     */
    public function store(Request $request)
    {
        $comentario = ($request->comentario) ? $request->comentario : '-';
        $movimiento_id = $request->movimiento;
        $productos = session()->all()['cart'];
        foreach ($productos as $key => $item) {
            DetalleMovimiento::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'fecha' => Carbon::now(),
                'producto_id' => $key,
                'movimiento_id' => $movimiento_id,
            ]);
        }
        session()->pull('cart', []);

        return redirect()->route('habitaciones');
    }
    /**
     Guardar Servicios
     */

    public function storeServicio(Request $request)
    {
        $comentario = ($request->comentario) ? $request->comentario : '-';
        $movimiento_id = $request->movimiento;
        $servicios = session()->all()['servicio'];
        foreach ($servicios as $key => $item) {
            DetalleMovimiento::create([
                'cantidad' => $item['cantidad'],
                'preciocompra' => $item['precio'],
                'precioventa' => ($item['cantidad'] * $item['precio']),
                'comentario' => $comentario,
                'fecha' => Carbon::now(),
                'servicio_id' => $key,
                'movimiento_id' => $movimiento_id,
            ]);
        }
        session()->pull('servicio', []);
        return redirect()->route('habitaciones');
    }
}
