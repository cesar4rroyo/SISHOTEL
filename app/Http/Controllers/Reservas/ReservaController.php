<?php

namespace App\Http\Controllers\Reservas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Piso;

class ReservaController extends Controller
{

    public function index()
    {
        $habitacion =
            Habitacion::with('piso', 'tipohabitacion')
            ->orderBy('id')
            ->get()
            ->toArray();
        $pisos = Piso::with('habitacion')->paginate(1, ['*'], 'piso');
        return view('reservas.index', compact('habitacion', 'pisos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
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
