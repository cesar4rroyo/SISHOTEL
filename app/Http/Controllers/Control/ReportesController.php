<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Procesos\Caja;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleMovimiento;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\Pasajero;
use App\Models\Procesos\Reserva;
use App\Models\Producto;
use App\Models\Seguridad\Usuario;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Servicios;
use App\Models\TipoHabitacion;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReportesController extends Controller
{
    public function pdfHuespedes(Request $request)
    {
        $fechaInicio = $request->from;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $sexo = $request->sexo;
        $edad = $request->edad;
        $presente = $request->presente;
        $habitacion = $request->habitacion;
        if (!is_null($edad)) {
            switch ($edad) {
                case 'r0':
                    $edad = [0, 12];
                    break;
                case 'r1':
                    $edad = [12, 18];
                    break;
                case 'r2':
                    $edad = [18, 30];
                    break;
                case 'r3':
                    $edad = [30, 63];
                    break;
                case 'r4':
                    $edad = [63, 100];
                    break;
            }
        }
        $huespedes = Pasajero::with('movimiento.habitacion.tipohabitacion', 'persona.nacionalidad')
            ->whereHas('movimiento', function ($q) use ($fechaInicio, $fechaFin) {
                $q->where('fechaingreso', '<=', $fechaFin)
                    ->where('fechasalida', '>=', $fechaInicio);
            })
            ->when($sexo, function ($q) use ($sexo) {
                $q->whereHas('persona', function ($q2) use ($sexo) {
                    return $q2->where('sexo', $sexo);
                });
            })
            ->when($edad, function ($q) use ($edad) {
                $q->whereHas('persona', function ($q2) use ($edad) {
                    return $q2->whereBetween('edad', $edad);
                });
            })
            ->when($habitacion, function ($q) use ($habitacion) {
                $q->whereHas('movimiento', function ($q2) use ($habitacion) {
                    return $q2->where('habitacion_id', $habitacion);
                });
            })
            ->when($presente, function ($q) use ($presente) {
                if ($presente == 'presentes') {
                    $q->whereHas('movimiento', function ($q2) {
                        return $q2->where('situacion', 'Pendiente');
                    });
                } else if ($presente == 'retirados') {
                    $q->whereHas('movimiento', function ($q2) {
                        return $q2->where('situacion', 'Pago Realizado');
                    });
                }
            })
            ->get()
            ->toArray();
        $data = [];
        foreach ($huespedes as $item) {

            if ($item['persona']['razonsocial'] && trim($item['persona']['razonsocial']) != '') {
                $nombres = $item['persona']['razonsocial'];
            } else {
                $nombres =  $item['persona']['nombres'] . ' ' . $item['persona']['apellidos'];
            }

            $data[] = [
                'nombres' => $nombres,
                'edad' => $item['persona']['edad'],
                'sexo' => $item['persona']['sexo'],
                'ciudad' => $item['persona']['ciudad'],
                'fechaingreso' => $item['movimiento']['fechaingreso'],
                'fechasalida' => $item['movimiento']['fechasalida'],
                'numero' => $item['movimiento']['habitacion']['numero'],
                'tipohabitacion' =>   $item['movimiento']['habitacion']['tipohabitacion']['nombre'],
                'total' => $item['movimiento']['total'],
                'early_checkin' => $item['movimiento']['early_checkin'],
                'late_checkout' => $item['movimiento']['late_checkout'],
                'day_use' => $item['movimiento']['day_use'],
            ];
        }
        return response()->json(array('data' => $data));
    }
    public function pdfCheckout(Request $request)
    {
        $fechaInicio = $request->from;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $habitacion = $request->habitacion;
        $servicio = $request->servicio;
        $descuento = $request->descuento;

        $movimiento = Movimiento::with(
            'pasajero.persona',
            'habitacion.tipohabitacion',
            'detallemovimiento.producto',
            'detallemovimiento.servicios'
        )
            ->whereBetween('fechasalida', [$fechaInicio, $fechaFin])
            ->where('situacion', 'Pago Realizado')
            ->when($habitacion, function ($q) use ($habitacion) {
                return $q->where('habitacion_id', $habitacion);
            })
            ->when($servicio, function ($q) use ($servicio) {
                return $q->where($servicio, '!=', 'O.OO');
            })
            ->when($descuento, function ($q) use ($descuento) {
                if ($descuento == 'si') {
                    return $q->whereNotNull('descuento');
                } else if ($descuento == 'no') {
                    return $q->whereNull('descuento');
                }
            })
            ->get()
            ->toArray();


        $data = [];
        foreach ($movimiento as $item) {

            $pasajeros = [];
            foreach ($item['pasajero'] as $pasajero) {
                if ($pasajero['persona']['razonsocial'] && trim($pasajero['persona']['razonsocial']) != '') {
                    $pasajeros[] =
                        $pasajero['persona']['razonsocial'];
                } else {
                    $pasajeros[] =
                        $pasajero['persona']['nombres'] . " " . $pasajero['persona']['apellidos'];
                }
            }
            $data[] = [
                'id' => $item['id'],
                'fechaingreso' => $item['fechaingreso'],
                'fechasalida' => $item['fechasalida'],
                'numero' => $item['habitacion']['numero'],
                'tipohabitacion' =>   $item['habitacion']['tipohabitacion']['nombre'],
                'total' => $item['total'],
                'early_checkin' => $item['early_checkin'],
                'late_checkout' => $item['late_checkout'],
                'day_use' => $item['day_use'],
                'pasajeros' => $pasajeros
            ];
        }

        return response()->json(array('data' => $data));
    }
    public function pdfCheckin(Request $request, $formato = null)
    {
        $fechaInicio = $request->from;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $habitacion = $request->habitacion;
        $reserva = $request->reserva;
        $movimiento = Movimiento::with(
            'pasajero.persona',
            'habitacion.tipohabitacion',
            'detallemovimiento.producto',
            'detallemovimiento.servicios'
        )->whereBetween('fechaingreso', [$fechaInicio, $fechaFin])
            ->when($habitacion, function ($q) use ($habitacion) {
                return $q->where('habitacion_id', $habitacion);
            })
            ->when($reserva, function ($q) use ($reserva) {
                if ($reserva == 'no') {
                    return $q->whereNull('reserva_id');
                } else if ($reserva == 'si') {
                    return $q->whereNotNul('reserva_id');
                }
            })
            ->get()
            ->toArray();

        if (!empty($formato)) {
            if ($formato == 'pdf') {
                $pdf = PDF::loadView('control.reportes.checkin.pdf', compact('movimiento'))->setPaper('a4', 'landscape');
                return $pdf->download('checkin' . Carbon::now()->toDateString() . '.pdf');
            } else {
                //excel actions
                dd($formato);
            }
        } else {
            $data = [];
            foreach ($movimiento as $item) {

                $pasajeros = [];
                foreach ($item['pasajero'] as $pasajero) {
                    if ($pasajero['persona']['razonsocial'] && trim($pasajero['persona']['razonsocial']) != '') {
                        $pasajeros[] =
                            $pasajero['persona']['razonsocial'];
                    } else {
                        $pasajeros[] =
                            $pasajero['persona']['nombres'] . " " . $pasajero['persona']['apellidos'];
                    }
                }
                $data[] = [
                    'id' => $item['id'],
                    'fechaingreso' => $item['fechaingreso'],
                    'fechasalida' => $item['fechasalida'],
                    'numero' => $item['habitacion']['numero'],
                    'tipohabitacion' =>   $item['habitacion']['tipohabitacion']['nombre'],
                    'reserva' => !is_null($item['reserva_id']) ? 'Reserva Nro. ' . $item['reserva_id']  : 'No',
                    'comentario' => !is_null($item['comentario']) ? $item['comentario'] : '-',
                    'pasajeros' => $pasajeros
                ];
            }

            return response()->json(array('data' => $data));
        }
    }

    public function pdfReservas(Request $request)
    {
        $fechaInicio = $request->from;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $sexo = $request->sexo;
        $edad = $request->edad;
        $habitacion = $request->habitacion;
        $situacion = $request->situacion;
        if (!is_null($edad)) {
            switch ($edad) {
                case 'r1':
                    $edad = [18, 30];
                    break;
                case 'r2':
                    $edad = [30, 40];
                    break;
                case 'r3':
                    $edad = [40, 50];
                    break;
                case 'r4':
                    $edad = [50, 60];
                    break;
                case 'r5':
                    $edad = [60, 100];
                    break;
            }
        }
        $reservas =
            Reserva::with('persona', 'habitacion.tipohabitacion')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->when($sexo, function ($q) use ($sexo) {
                $q->whereHas('persona', function ($q2) use ($sexo) {
                    return $q2->where('sexo', $sexo);
                });
            })
            ->when($edad, function ($q) use ($edad) {
                $q->whereHas('persona', function ($q2) use ($edad) {
                    return $q2->whereBetween('edad', $edad);
                });
            })
            ->when($habitacion, function ($q) use ($habitacion) {
                $q->whereHas('habitacion', function ($q2) use ($habitacion) {
                    return $q2->where('id', $habitacion);
                });
            })
            ->when($situacion, function ($q) use ($situacion) {
                $q->where('situacion', $situacion);
            })
            ->get()->toArray();

        $data = [];
        foreach ($reservas as $item) {

            if ($item['persona']['razonsocial'] && trim($item['persona']['razonsocial']) != '') {
                $nombres = $item['persona']['razonsocial'];
            } else {
                $nombres =  $item['persona']['nombres'] . ' ' . $item['persona']['apellidos'];
            }

            $data[] = [
                'fechaingreso' => $item['fecha'],
                'fechasalida' => $item['fechasalida'],
                'persona' => $nombres,
                'edad' => $item['persona']['edad'],
                'sexo' => $item['persona']['sexo'],
                'ciudad' => $item['persona']['ciudad'],
                'numero' => $item['habitacion']['numero'],
                'tipohabitacion' =>   $item['habitacion']['tipohabitacion']['nombre'],
            ];
        }

        return response()->json(array('data' => $data));
    }

    public function pdfProductos(Request $request)
    {

        $tipo = $request->tipo;
        $data = [];
        if ($tipo == 'producto') {
            $response = Producto::with('categoria', 'detallecaja', 'detallemovimiento', 'unidad')->get()->toArray();
            $data = [];
            foreach ($response as $item) {
                $cantidad = 0;
                if (count($item['detallecaja']) != 0) {
                    foreach ($item['detallecaja'] as $venta) {
                        $cantidad = $cantidad + $venta['cantidad'];
                    }
                }
                if (count($item['detallemovimiento']) != 0) {
                    foreach ($item['detallemovimiento'] as $movimiento) {
                        $cantidad = $cantidad + $movimiento['cantidad'];
                    }
                }
                $data[] = [
                    'nombre' => $item['nombre'],
                    'preciocompra' => $item['preciocompra'],
                    'precioventa' => $item['precioventa'],
                    'categoria' => $item['categoria']['nombre'],
                    'unidad' =>   $item['unidad']['nombre'],
                    'ventas' => $cantidad,
                ];
            }
        }
        if ($tipo == 'servicio') {
            $response = Servicios::with('detallecomprobante', 'detallemovimiento')
                ->get()->toArray();
            $data = [];
            foreach ($response as $item) {
                $cantidad = 0;
                if (count($item['detallecomprobante']) != 0) {
                    foreach ($item['detallecomprobante'] as $venta) {
                        $cantidad = $cantidad + $venta['cantidad'];
                    }
                }
                if (count($item['detallemovimiento']) != 0) {
                    foreach ($item['detallemovimiento'] as $movimiento) {
                        $cantidad = $cantidad + $movimiento['cantidad'];
                    }
                }

                $data[] = [
                    'nombre' => $item['nombre'],
                    'precio' => $item['precio'],
                    'cantidad' => $cantidad,
                ];
            }
        }
        return response()->json(array('data' => $data, 'tipo' => $tipo));
    }
    public function pdfVentas(Request $request)
    {
        $fechaInicio = $request->from;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $pago = $request->pago;
        $tipo = $request->tipoventa;

        if ($pago == 'habitacion') {
            $tipohabitacion = $request->tipohabitacion;
            $detallemovimiento = DetalleMovimiento::with('movimiento.habitacion.tipohabitacion', 'producto', 'servicios', 'movimiento.pasajero.persona')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->when($tipo, function ($q) use ($tipo) {
                    if ($tipo == 'productos') {
                        return $q->where('servicio_id', null);
                    } else if ($tipo == 'servicios') {
                        return $q->where('producto_id', null);
                    }
                })
                ->when($tipohabitacion, function ($q) use ($tipohabitacion) {
                    $q->whereHas('movimiento', function ($q2) use ($tipohabitacion) {
                        $q2->whereHas('habitacion', function ($q3) use ($tipohabitacion) {
                            return $q3->where('tipohabitacion_id', $tipohabitacion);
                        });
                    });
                })
                ->get()
                ->toArray();
            $data = [];
            foreach ($detallemovimiento as $item) {
                if ($item['movimiento']['pasajero'][0]['persona']['razonsocial'] && trim($item['movimiento']['pasajero'][0]['persona']['razonsocial']) != '') {
                    $nombres = $item['movimiento']['pasajero'][0]['persona']['razonsocial'];
                } else {
                    $nombres = !is_null($item['movimiento']['pasajero'][0]['persona']) ? $item['movimiento']['pasajero'][0]['persona']['nombres'] . ' ' . $item['movimiento']['pasajero'][0]['persona']['apellidos']  : '-';
                }
                $data[] = [
                    'fecha' => $item['created_at'],
                    'venta' => !is_null($item['producto_id']) ? $item['producto']['nombre'] : $item['servicios']['nombre'],
                    'cantidad' => $item['cantidad'],
                    'total' => $item['precioventa'],
                    'numero' => 'Habitacion Nro: ' . $item['movimiento']['habitacion']['numero'],
                    'tipo' => $item['movimiento']['habitacion']['tipohabitacion']['nombre'],
                    'comentario' => !is_null($item['comentario']) ? $item['comentario'] : '-',
                    'cliente' => $nombres,
                ];
            }
            return response()->json(array('data' => $data));
        }

        if ($pago == 'caja') {
            $usuario = $request->usuario;

            $detallecaja = DetalleCaja::with('producto', 'servicios', 'caja.persona', 'caja.usuario')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->when($tipo, function ($q) use ($tipo) {
                    if ($tipo == 'productos') {
                        return $q->where('servicio_id', null);
                    } else if ($tipo == 'servicios') {
                        return $q->where('producto_id', null);
                    }
                })
                ->when($usuario, function ($q) use ($usuario) {
                    $q->whereHas('caja', function ($q2) use ($usuario) {
                        return $q2->where('usuario_id', $usuario);
                    });
                })
                ->get()
                ->toArray();

            $data = [];
            foreach ($detallecaja as $item) {
                if ($item['caja']['persona']['razonsocial'] && trim($item['caja']['persona']['razonsocial']) != '') {
                    $nombres = $item['caja']['persona']['razonsocial'];
                } else {
                    $nombres = !is_null($item['caja']['persona']) ? $item['caja']['persona']['nombres'] . ' ' . $item['caja']['persona']['apellidos']  : '-';
                }
                switch ($item['caja']['modalidadpago']) {
                    case 'efectivo':
                        $modalidad = 'Efectivo';
                        break;
                    case 'tarjeta':
                        $modalidad = 'Tarjeta';                        
                        break;
                    case 'deposito':
                        $modalidad = 'Deposito';                        
                        break;
                    case 'efectivotarjeta':
                        $modalidad = 'Efectivo y Tarjeta';                       
                        break;
                    case 'depositoefectivo':
                        $modalidad = 'Depósito y Efectivo';               
                        break;
                    case 'depositotarjeta':
                        $modalidad = 'Depósito y Tarjeta'; 
                        break;
                    default:
                        $modalidad = '';
                        break;               
                }
                $data[] = [
                    'fecha' => $item['created_at'],
                    'venta' => !is_null($item['producto_id']) ? $item['producto']['nombre'] : $item['servicios']['nombre'],
                    'cantidad' => $item['cantidad'],
                    'total' => $item['precioventa'],
                    'caja' => 'Caja Nro: ' . $item['caja']['numero'],
                    'persona' => $nombres,
                    'usuario' => $item['caja']['usuario']['login'],
                    'comentario' => !is_null($item['comentario']) ? $item['comentario'] : '-',
                    'modalidad' => $modalidad,
                ];
            }
            return response()->json(array('data' => $data));
        }
    }
    public function pdfCaja(Request $request, $formato = null)
    {
        $fechaInicio = $request->from;
        $usuario = $request->usuario;
        $fechaInicio = Carbon::parse($fechaInicio)->toDateTimeString();
        $fechaFin = $request->to;
        $fechaFin = Carbon::parse($fechaFin)->addHours(23)->addMinutes(59)->toDateTimeString();
        $tipo = $request->tipo;
        $caja = Caja::with('usuario', 'movimiento', 'detallecaja', 'persona', 'concepto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('id', '!=', 1)
            ->when($usuario, function ($q) use ($usuario) {
                $q->whereHas('usuario', function ($q2) use ($usuario) {
                    return $q2->where('id', $usuario);
                });
            })
            ->when($tipo, function ($q) use ($tipo) {
                $q->where('tipo', $tipo);
            })
            ->get()
            ->toArray();
        if (!empty($formato)) {
            if ($formato == 'pdf') {
                $pdf = PDF::loadView('control.reportes.caja.pdf', compact('caja'))->setPaper('a4', 'landscape');
                return $pdf->download('caja' . Carbon::now()->toDateString() . '.pdf');
            } else {
                //excel actions
                dd($formato);
            }
        } else {
            $data = [];
            foreach ($caja as $item) {
                if ($item['persona']['razonsocial'] && trim($item['persona']['razonsocial']) != '') {
                    $nombres = $item['persona']['razonsocial'];
                } else {
                    $nombres = !is_null($item['persona']) ? $item['persona']['nombres'] . ' ' . $item['persona']['apellidos']  : '-';
                }

                switch ($item['modalidadpago']) {
                    case 'efectivo':
                        $modalidad = 'Efectivo';
                        break;
                    case 'tarjeta':
                        $modalidad = 'Tarjeta';                        
                        break;
                    case 'deposito':
                        $modalidad = 'Deposito';    
                        break;
                    case 'efectivotarjeta':
                        $modalidad = 'Efectivo y Tarjeta';                       
                        break;
                    case 'depositoefectivo':
                        $modalidad = 'Depósito y Efectivo';

                        break;
                    case 'depositotarjeta':
                        $modalidad = 'Depósito y Tarjeta';

                        break;
                    default:
                        $modalidad = '';
                        break;               
                }
                $data[] = [
                    'fecha' => $item['fecha'],
                    'numero' => $item['numero'],
                    'tipo' => $item['tipo'],
                    'persona' => $nombres,
                    'total' => $item['total'],
                    'concepto' => $item['concepto']['nombre'],
                    'comentario' => !is_null($item['comentario']) ? $item['comentario'] : '-',
                    'movimiento' => !is_null($item['movimiento']) ? 'Pago Servicio Hotel Nro.  000' . $item['movimiento']['id']  : '-',
                    'usuario' => $item['usuario']['login'],
                    'modalidad' => $modalidad,
                ];
            }
            return response()->json(array('data' => $data));
        }
    }
    public function indexHuespedes()
    {
        $today = Carbon::now()->toDateString();
        $habitaciones = Habitacion::with('tipohabitacion', 'piso')->get()->toArray();
        return view('control.reportes.huespedes.index', compact('today', 'habitaciones'));
    }
    public function indexCheckin()
    {
        $today = Carbon::now()->toDateString();
        $habitaciones = Habitacion::with('tipohabitacion', 'piso')->get()->toArray();
        return view('control.reportes.checkin.index', compact('today', 'habitaciones'));
    }
    public function indexCheckout()
    {
        $today = Carbon::now()->toDateString();
        $habitaciones = Habitacion::with('tipohabitacion', 'piso')->get()->toArray();
        return view('control.reportes.checkout.index', compact('today', 'habitaciones'));
    }
    public function indexReservas()
    {
        $today = Carbon::now()->toDateString();
        $habitaciones = Habitacion::with('tipohabitacion', 'piso')->get()->toArray();
        return view('control.reportes.reservas.index', compact('today', 'habitaciones'));
    }
    public function indexProductos()
    {
        return view('control.reportes.productos.index');
    }
    public function indexServicios()
    {
        return view('control.reportes.servicios.index');
    }
    public function indexVentas()
    {
        $usuarios = Usuario::with('persona')->get()->toArray();
        $today = Carbon::now()->toDateString();
        return view('control.reportes.ventas.index', compact('today', 'usuarios'));
    }
    public function indexVentasHabitacion()
    {
        $today = Carbon::now()->toDateString();
        $habitaciones = TipoHabitacion::with('habitacion')->get()->toArray();
        return view('control.reportes.ventashabitacion.index', compact('today', 'habitaciones'));
    }
    public function indexCaja()
    {
        $usuarios = Usuario::with('persona')->get()->toArray();
        $today = Carbon::now()->toDateString();
        return view('control.reportes.caja.index', compact('usuarios', 'today'));
    }
    public function movimientos()
    {
        $movimientos = Movimiento::with(
            'pasajero.persona.nacionalidad',
            'detallemovimiento.producto',
            'detallemovimiento.servicios',
            'caja',
            'habitacion.tipohabitacion',
            'habitacion.piso',
            'reserva.persona',
            'comprobante.detalleComprobante'
        )->get()->toArray();
        return response()->json($movimientos);
    }

    public function reservas()
    {
        $reservas = Reserva::with(
            'persona.nacionalidad',
            'habitacion.tipohabitacion',
            'habitacion.piso',
            'usuario.persona',
            'movimiento'

        )->get()->toArray();
        return response()->json($reservas);
    }
    public function caja()
    {
        $caja = Caja::with(
            'concepto',
            'persona',
            'movimiento.detallemovimiento',
            'usuario.persona',
            'detallecaja.producto',
            'detallecaja.servicios'

        )->get()->toArray();
        return response()->json($caja);
    }
    public function productos()
    {
        $productos = Producto::with('categoria', 'unidad')
            ->get()
            ->toArray();
        return response()->json($productos);
    }
    public function servicios()
    {
        $servicios = Servicios::get()
            ->toArray();
        return response()->json($servicios);
    }
    public function detallecaja()
    {
        $detalles = DetalleCaja::with('producto', 'servicios')
            ->get()
            ->toArray();
        return response()->json($detalles);
    }
    public function detallemovimiento()
    {
        $detalles = DetalleMovimiento::with('producto', 'servicios', 'movimiento.habitacion')
            ->get()
            ->toArray();
        return response()->json($detalles);
    }
}
