<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nacionalidad;
use Illuminate\Support\Facades\DB;

class NacionalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $nacionalidad = DB::table('nacionalidad')->paginate($paginate_number);
        return view('admin.nacionalidad.index', compact('nacionalidad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nacionalidad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Nacionalidad::create($request->all());
        return redirect()
            ->route('nacionalidad')
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
        $nacionalidad = Nacionalidad::findOrFail($id);
        return view('admin.nacionalidad.show', compact('nacionalidad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nacionalidad = Nacionalidad::findOrFail($id);
        return view('admin.nacionalidad.edit', compact('nacionalidad'));
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
        Nacionalidad::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('nacionalidad')
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
        Nacionalidad::destroy($id);
        return redirect()
            ->route('nacionalidad')
            ->with('success', 'Eliminado Correctamente');
    }
}
