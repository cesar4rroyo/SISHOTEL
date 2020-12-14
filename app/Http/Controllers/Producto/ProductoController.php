<?php

namespace App\Http\Controllers\Producto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producto\ValidateProducto;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Unidad;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate_number = 10;
        $producto =
            Producto::with('categoria', 'unidad')
            ->orderBy('nombre')
            ->paginate($paginate_number);
        return view('producto.producto.index', compact('producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::with('producto')->get();
        $unidades = Unidad::with('producto')->get();
        return view('producto.producto.create', compact('categorias', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProducto $request)
    {
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precioventa' => $request->precioventa,
            'preciocompra' => $request->preciocompra,
            'categoria_id' => $request->categoria_id,
            'unidad_id' => $request->unidad_id
        ]);

        return redirect()
            ->route('producto')
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
        $producto = Producto::findOrFail($id);
        return view('producto.producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::with('producto')->get();
        $unidades = Unidad::with('producto')->get();
        return view('producto.producto.edit', compact('producto', 'categorias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateProducto $request, $id)
    {
        $producto = Producto::findOrFail($id)
            ->update([
                'nombre' => $request->nombre,
                'precioventa' => $request->precioventa,
                'preciocompra' => $request->preciocompra,
                'categoria_id' => $request->categoria_id,
                'unidad_id' => $request->unidad_id
            ]);

        return redirect()
            ->route('producto')
            ->with('success', 'Actualizado correctamente');
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
            Producto::destroy($id);
            return response()->json(['mensaje' => 'ok']);
        } else {
            abort(404);
        }
    }
}
