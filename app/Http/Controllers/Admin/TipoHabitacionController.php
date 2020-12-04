<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\DB;

class TipoHabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $tipohabitacion = DB::table('tipohabitacion')->paginate($paginate_number);
        return view('admin.tipohabitacion.index', compact('tipohabitacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipohabitacion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TipoHabitacion::create($request->all());
        return redirect()
            ->route('tipohabitacion')
            ->with('success', 'Agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipohabitacion = Tipohabitacion::findOrFail($id);
        return view('admin.tipohabitacion.show', compact('tipohabitacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipohabitacion = Tipohabitacion::findOrFail($id);
        return view('admin.tipohabitacion.edit', compact('tipohabitacion'));
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
        Tipohabitacion::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('tipohabitacion')
            ->with('sussess', 'Menú actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tipohabitacion::destroy($id);
        return redirect()
            ->route('tipohabitacion')
            ->with('success', 'Eliminado Correctamente');
    }
}
