<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Piso;
use App\Models\Procesos\Reserva;
use Carbon\Carbon;

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
            $fechaActual = Carbon::now()->toDateString();
            // $habitacionMov = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
            //     $query->where('piso_id', $piso);
            // })->whereHas('movimiento', function ($q) use ($fechaActual) {
            //     $q->whereDate('fechaingreso', '%LIKE%', $fechaActual);
            // })->get()->toArray();
            $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
                $query->where('piso_id', $piso);
            })->get()->toArray();
            $reservas = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
                $query->where('piso_id', $piso);
            })->whereHas('reserva', function ($q) use ($fechaActual) {
                $q->where('fecha', $fechaActual);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find($piso);
        } else {
            $fechaActual = Carbon::now()->toDateString();
            $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) {
                $query->where('piso_id', 1);
            })->get()->toArray();
            $pisos = Piso::with('habitacion')->get()->toArray();
            $piso = Piso::find(1);
            $reservas = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) {
                $query->where('piso_id', 1);
            })->whereHas('reserva', function ($q) use ($fechaActual) {
                $q->where('fecha', $fechaActual);
            })->get()->toArray();
            // $habitacionMov = Habitacion::with('tipohabitacion', 'piso', 'reserva', 'movimiento')->whereHas('piso', function ($query) use ($piso) {
            //     $query->where('piso_id', 1);
            // })->whereHas('movimiento', function ($q) use ($fechaActual) {
            //     $q->whereDate('fechaingreso', '%LIKE%', $fechaActual);
            // })->get()->toArray();
        }
        // dd($habitacion);
        return view('control.index', compact('habitacion', 'pisos', 'piso', 'fechaActual', 'reservas'));
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
        $habitacion = Habitacion::with('tipohabitacion', 'piso', 'reserva')->find($id);
        $reservas = Reserva::with('habitacion', 'persona')->where('situacion', "Reservado")->whereHas('habitacion', function ($query) use ($id) {
            $query->where('habitacion_id', $id);
        })->orderBy('fecha')->paginate(10);
        return view('control.reservas.reservas', compact('habitacion', 'reservas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
