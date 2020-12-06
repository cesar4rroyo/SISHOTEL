<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateGrupoMenu;
use App\Models\GrupoMenu;
use Illuminate\Support\Facades\DB;

class GrupoMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $grupomenu = DB::table('grupomenu')->paginate($paginate_number);
        return view('admin.grupomenu.index', compact('grupomenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grupomenu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateGrupoMenu $request)
    {
        GrupoMenu::create($request->all());
        return redirect()
            ->route('grupomenu')
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
        $grupomenu = GrupoMenu::findOrFail($id);
        return view('admin.grupomenu.show', compact('grupomenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grupomenu = GrupoMenu::findOrFail($id);
        return view('admin.grupomenu.edit', compact('grupomenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateGrupoMenu $request, $id)
    {
        GrupoMenu::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('grupomenu')
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
        GrupoMenu::destroy($id);
        return redirect()
            ->route('grupomenu')
            ->with('success', 'Eliminado Correctamente');
    }
}
