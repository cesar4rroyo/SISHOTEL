<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Concepto;
use App\Models\Persona;
use App\Models\Procesos\Caja;
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
}
