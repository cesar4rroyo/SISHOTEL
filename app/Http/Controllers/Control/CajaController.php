<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Habitacion;
use App\Models\Persona;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Movimiento;
use Carbon\Carbon;

class CajaController extends Controller
{

    public function index()
    {
        $cajas = Caja::with('concepto', 'usuario', 'persona', 'movimiento')->paginate(10);
        return view('control.caja.index', compact('cajas'));
    }


    public function create()
    {
        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $today = Carbon::now()->toDateString();
        $personas = Persona::with('caja', 'reserva', 'movimiento')->orderBy('nombres')->get();
        return view('control.caja.create', compact('conceptos', 'personas', 'today'));
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
        $caja = Caja::findOrFail($id);
        return view('control.caja.show', compact('caja'));
    }


    public function edit($id)
    {
        $caja = Caja::findOrFail($id);
        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $today = Carbon::now()->toDateString();
        $personas = Persona::with('caja', 'reserva', 'movimiento')->orderBy('nombres')->get();
        return view('control.caja.edit', compact('caja', 'conceptos', 'personas', 'today'));
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
        if ($request->ajax()) {
            Caja::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }

    public function checkout(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $habitacion = Habitacion::findOrFail($request->habitacion_id);
        $today = Carbon::now()->toDateString();

        $movimiento->update([
            'fechasalida' => $request->fechasalida,
            'dias' => $request->dia,
            'total' => $request->total,
            'situacion' => 'En Espera Pago',
        ]);

        $habitacion->update([
            'situacion' => 'Disponible'
        ]);

        $caja = Caja::create([
            'fecha' => $today,
            'numero' => $request->numero,
            'concepto_id' => $request->concepto,
            'tipo' => $request->tipo,
            'persona_id' => $request->persona,
            'total' => $request->total,
            'comentario' => $request->comentario,
            'usuario_id' => session()->all()['usuario_id'],
            'movimiento_id' => $id,
        ]);


        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    public function addFromDetallePdto($id)
    {

        $cart = session()->get('cart');
        $total = 0;
        foreach ($cart as $key => $item) {
            $total += ($item['precio'] * $item['cantidad']);
        }

        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $today = Carbon::now()->toDateString();
        $personas = Persona::with('caja', 'reserva', 'movimiento')->orderBy('nombres')->get();
        return view('control.caja.producto.create', compact('conceptos', 'id', 'personas', 'today', 'total'));
    }
    public function addFromDetalleService($id)
    {
        $cart = session()->get('servicio');
        $total = 0;
        foreach ($cart as $key => $item) {
            $total += ($item['precio'] * $item['cantidad']);
        }

        $conceptos = Concepto::with('caja')->orderBy('nombre')->get();
        $today = Carbon::now()->toDateString();
        $personas = Persona::with('caja', 'reserva', 'movimiento')->orderBy('nombres')->get();
        return view('control.caja.servicio.create', compact('conceptos', 'id', 'personas', 'today', 'total'));
    }
    public function storeProducto(Request $request)
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
            'movimiento_id' => $request->movimiento,

        ]);
        session()->pull('cart', []);

        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
    public function storeServicio(Request $request)
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
            'movimiento_id' => $request->movimiento,

        ]);
        session()->pull('servicio', []);
        return redirect()
            ->route('caja')
            ->with('success', 'Registro agregado correctamente');
    }
}
