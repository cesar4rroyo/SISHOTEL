<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Servicios;

class VentasController extends Controller
{
    public function indexProductos()
    {
        $productos = Producto::get()->toArray();
        return view('control.ventas.add', compact('productos'));
    }
    public function indexServicios()
    {
        $servicios = Servicios::get()->toArray();
        return view('control.ventas.addServicio', compact('servicios'));
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
