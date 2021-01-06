<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procesos\Comprobante;
use Barryvdh\DomPDF\Facade as PDF;


class ComprobanteController extends Controller
{
    public function exportPdf($id)
    {
        $comprobante =
            Comprobante::with('movimiento.pasajero.persona', 'detallecomprobante.producto', 'detallecomprobante.servicios')
            ->findOrFail($id)->get();
        $pdf = PDF::loadView('pdf.caja', compact('cajas'))->setPaper('a4', 'landscape');;
        return $pdf->download('registros-list.pdf');
    }
}
