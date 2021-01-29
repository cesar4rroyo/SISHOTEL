<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
use Carbon\Carbon;

class RestaurantController extends Controller
{

    public function index()
    {
        $today = Carbon::now()->toDateTimeLocalString();
        $huespedes = Pasajero::with('movimiento.habitacion.tipohabitacion', 'persona.nacionalidad')
            ->whereHas('movimiento', function ($q) use ($today) {
                $q->where('fechaingreso', '<=', $today)
                    ->where('fechasalida', '>=', $today)
                    ->where('situacion', 'Pendiente');
            })
            ->get()
            ->toArray();
        $data = [];
        foreach ($huespedes as $item) {

            $data[] = [
                'id_movimiento' => $item['movimiento']['id'],
                'nombres' => $item['persona']['nombres'],
                'apellidos' => $item['persona']['apellidos'],
                'dni' => $item['persona']['dni'],
                'ruc' => $item['persona']['ruc'],
                'fechaingreso' => $item['movimiento']['fechaingreso'],
                'fechasalida' => $item['movimiento']['fechasalida'],
                'numero' => $item['movimiento']['habitacion']['numero'],
                'tipohabitacion' =>   $item['movimiento']['habitacion']['tipohabitacion']['nombre'],
            ];
        }
        return $data;
    }


    public function store(Request $request, $id)
    {
        $total = $request->total;
        $productos = $request->productos;
        if (is_null($total) || is_null($productos)) {
            $data = [
                'ok' => false,
                'mensaje' => 'Ha ocurrido un error, los datos no se enviaron correctamente',
            ];
            return $data;
        } else {
            try {
                $detalle = DetalleMovimiento::create([
                    'cantidad' => 1,
                    'preciocompra' => 1,
                    'precioventa' => $total,
                    'comentario' => 'Consumo de Restaurante: ' . $productos,
                    'fecha' => Carbon::now()->toDateString(),
                    'servicio_id' => 6,
                    'movimiento_id' => $id,
                ]);
                $data = [
                    'ok' => true,
                    'mensaje' => 'Se ha agregado correctamente',
                ];
                return $data;
            } catch (\Throwable $e) {
                $data = [
                    'ok' => false,
                    'mensaje' => 'Ha ocurrido un error: ' . $e->getMessage(),
                ];
                return $data;
            }
        }
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
