<?php

namespace App\Http\Controllers\Habitacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Habitacion\ValidatePiso;
use App\Models\Piso;
use Illuminate\Support\Facades\DB;

class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate_number = 10;
        $search = $request->get('search');
        if (!empty($search)) {
            $piso = Piso::where('nombre', 'LIKE', '%' . $search . '%')
                ->paginate($paginate_number);
        } else {
            $piso = Piso::orderBy('id')
                ->paginate($paginate_number);
        }

        return view('habitacion.piso.index', compact('piso'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('habitacion.piso.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatePiso $request)
    {
        Piso::create($request->all());
        return redirect()
            ->route('piso')
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
        $piso = Piso::findOrFail($id);
        return view('habitacion.piso.show', compact('piso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $piso = Piso::findOrFail($id);
        return view('habitacion.piso.edit', compact('piso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidatePiso $request, $id)
    {
        Piso::findOrFail($id)
            ->update($request->all());
        return redirect()
            ->route('piso')
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
            Piso::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
