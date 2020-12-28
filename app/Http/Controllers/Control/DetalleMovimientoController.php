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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        return view('control.detallemovimientos.add');
    }
    public function movimiento($id, $movimiento = null)
    {

        if (is_null($movimiento)) {
            $productos = Producto::get()->toArray();
            return view('control.detallemovimientos.add', compact('productos'));
            $movimientos =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
        } else {
            $servicios = Servicios::get()->toArray();
            $movimientos =
                Movimiento::with('persona', 'reserva', 'habitacion', 'detallemovimiento')
                ->whereHas('habitacion', function ($q) use ($id) {
                    $q->where('id', $id);
                })->latest('fechaingreso')->first()->toArray();
            return view('control.detallemovimientos.addServicio', compact('servicios', 'movimientos'));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detalle = DetalleMovimiento::create([
            'fecha' => Carbon::now()->toDateString(),
            'preciocompra' => $request->preciocompra,
            'precioventa' => $request->precioventa,
            'comentario' => $request->comentario,
            'servicio_id' => $request->servicio,
            'producto_id' => $request->producto,
            'movimiento_id' => $request->movimiento,
        ]);
        return redirect()
            ->route('habitaciones')
            ->with('success', 'La reserva se registró correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
