<?php

namespace App\Http\Controllers\Habitacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Piso;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\DB;

class HabitacionController extends Controller
{

    public function index()
    {
        $paginate_number = 10;
        $habitacion =
            Habitacion::with('piso', 'tipohabitacion')
            ->orderBy('numero')
            ->paginate($paginate_number);
        return view('habitacion.habitacion.index', compact('habitacion'));
    }


    public function create()
    {
        $pisos = Piso::with('habitacion')->get();
        $tipohabitaciones = DB::table('tipohabitacion')->get();
        return view('habitacion.habitacion.create', compact('pisos', 'tipohabitaciones'));
    }


    public function store(Request $request)
    {
        // $habitacion = new Habitacion();
        // $piso = Piso::findOrFail($request->piso_id);
        // $tipohabitacion = TipoHabitacion::findOrFail($request->tipohabitacion_id);
        // $piso->habitacion()->save($habitacion);
        // $tipohabitacion->habitacion()->save($habitacion);
        // $habitacion
        //     ->create($request->all())
        //     ->piso()->associate($piso)
        //     ->tpohabitacion()->associate($tipohabitacion);
        $habitacion = Habitacion::create([
            'numero' => $request->numero,
            'situacion' => $request->situacion,
            'piso_id' => $request->piso_id,
            'tipohabitacion_id' => $request->tipohabitacion_id
        ]);

        return redirect()
            ->route('habitacion')
            ->with('success', 'Agregado correctamente');
    }


    public function show($id)
    {
        $habitacion = Habitacion::findOrFail($id);
        return view('habitacion.habitacion.show', compact('habitacion'));
    }


    public function edit($id)
    {
        $habitacion = Habitacion::findOrFail($id);
        $pisos = Piso::with('habitacion')->get();
        $tipohabitaciones = DB::table('tipohabitacion')->get();
        return view('habitacion.habitacion.edit', compact('habitacion', 'pisos', 'tipohabitaciones'));
    }


    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::findOrFail($id)
            ->update([
                'numero' => $request->numero,
                'situacion' => $request->situacion,
                'piso_id' => $request->piso_id,
                'tipohabitacion_id' => $request->tipohabitacion_id
            ]);

        return redirect()
            ->route('habitacion')
            ->with('success', 'Actualizado correctamente');
    }


    public function destroy($id)
    {
        Habitacion::destroy($id);
        return redirect()
            ->route('habitacion')
            ->with('success', 'Eliminado Correctamente');
    }
}
