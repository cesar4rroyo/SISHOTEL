<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateConcepto;
use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConceptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $concepto = DB::table('concepto')->paginate($paginate_number);
        return view('general.concepto.index', compact('concepto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.concepto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateConcepto $request)
    {
        Concepto::create($request->all());
        return redirect()
            ->route('concepto')
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
        $concepto = Concepto::findOrFail($id);
        return view('general.concepto.show', compact('concepto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $concepto = Concepto::findOrFail($id);
        return view('general.concepto.edit', compact('concepto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateConcepto $request, $id)
    {
        Concepto::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('concepto')
            ->with('success', 'Menú actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            Concepto::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
