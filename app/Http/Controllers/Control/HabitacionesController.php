<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Piso;

class HabitacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $piso = $request->get('piso');
        if (!empty($piso)) {
            $habitacion = Habitacion::with('tipohabitacion', 'piso')->whereHas('piso', function ($query) use ($piso) {
                $query->where('piso_id', $piso);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find($piso);
        } else {
            $habitacion = Habitacion::with('tipohabitacion', 'piso')->whereHas('piso', function ($query) {
                $query->where('piso_id', 1);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find(1);
        }
        // dd($habitacion);
        return view('control.index', compact('habitacion', 'pisos', 'piso'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha = $request->get('fecha');
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->whereDoesntHave('reserva', function ($query) use ($fecha) {
            $query->where('fecha', '=', $fecha);
        })->get()->toArray();
        return response()->json($habitacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
