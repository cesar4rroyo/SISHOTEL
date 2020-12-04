<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\DB;

class TipoUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $tipousuario = DB::table('tipousuario')->paginate($paginate_number);
        return view('admin.tipousuario.index', compact('tipousuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipousuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TipoUsuario::create($request->all());
        return redirect()
            ->route('tipousuario')
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
        $tipousuario = TipoUsuario::findOrFail($id);
        return view('admin.tipousuario.show', compact('tipousuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipousuario = TipoUsuario::findOrFail($id);
        return view('admin.tipousuario.edit', compact('tipousuario'));
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
        TipoUsuario::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('tipousuario')
            ->with('success', 'Menú actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipoUsuario::destroy($id);
        return redirect()
            ->route('tipousuario')
            ->with('success', 'Eliminado Correctamente');
    }
}
