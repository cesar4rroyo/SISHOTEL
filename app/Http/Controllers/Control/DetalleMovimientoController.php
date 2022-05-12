<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
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
            Movimiento::with('pasajero', 'reserva', 'habitacion', 'detallemovimiento')
            ->whereHas('habitacion', function ($q) use ($id) {
                $q->where('id', $id);
            })->latest('fechaingreso')->first()->toArray();
        $pasajeros = Pasajero::with('persona', 'movimiento')
            ->whereHas('movimiento', function ($q) use ($id) {
                $q->where('habitacion_id', $id);
            })
            ->where('movimiento_id', $movimientos['id'])
            ->get()
            ->toArray();
        return view('control.detallemovimientos.addServicio', compact('pasajeros', 'servicios', 'movimientos', 'id'));
    }
    //consultar productos search
    public function productos($id, Request $request)
    {
        $search = $request->get('search');
        if (!empty($search)) {
            $productos = Producto::where('nombre', 'LIKE', '%' . $search . '%')->get()->toArray();
        } else {
            $productos = Producto::orderBy('nombre')->get()->toArray();
        }
        $movimientos =
            Movimiento::with('pasajero', 'reserva', 'habitacion', 'detallemovimiento')
            ->whereHas('habitacion', function ($q) use ($id) {
                $q->where('id', $id);
            })->latest('fechaingreso')->first()->toArray();
        $pasajeros = Pasajero::with('persona', 'movimiento')
            ->whereHas('movimiento', function ($q) use ($id) {
                $q->where('habitacion_id', $id);
            })
            ->where('movimiento_id', $movimientos['id'])
            ->get()
            ->toArray();
        return view('control.detallemovimientos.add', compact('pasajeros', 'productos', 'movimientos', 'id'));
    }
    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
    public function movimiento($id, $movimiento = null)
    {
        $serieFacturacion = env('SERIE_FACTURACION');
        $movimientos =
            Movimiento::with('pasajero', 'reserva', 'habitacion', 'detallemovimiento')
            ->whereHas('habitacion', function ($q) use ($id) {
                $q->where('id', $id);
            })->latest('fechaingreso')->first()->toArray();
        $pasajeros = Pasajero::with('persona', 'movimiento')
            ->whereHas('movimiento', function ($q) use ($id) {
                $q->where('habitacion_id', $id);
            })
            ->where('movimiento_id', $movimientos['id'])
            ->get()
            ->toArray();
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

        if (is_null($movimiento)) {
            $productos = Producto::get()->toArray();


            return view('control.detallemovimientos.add', compact('pasajeros', 'productos', 'movimientos', 'id', 'numero'));
        } else {
            $servicios = Servicios::whereNotIn('id', [1, 2, 3, 4, 6])
                ->get()
                ->toArray();


            return view('control.detallemovimientos.addServicio', compact('pasajeros', 'servicios', 'movimientos', 'id', 'numero'));
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

    public function eliminarMovimiento(Request $request){
        if ($request->ajax()) {
            $id = $request->id;
            $detalle = DetalleMovimiento::find($id);
            $detalle->delete();
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
