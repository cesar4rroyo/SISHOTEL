<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Procesos\Motivonotacredito;
use App\Models\Procesos\NotaCredito;

class NotacreditoController extends Controller
{
    protected $folderview      = 'app.notacredito';
    protected $tituloAdmin     = 'Nota de crédito';
    protected $tituloRegistrar = 'Registrar Nota de crédito';
    protected $tituloModificar = 'Modificar Nota de crédito';
    protected $tituloEliminar  = 'Eliminar Nota de crédito';
    protected $rutas           = array('create' => 'notacredito.create',
            'edit'   => 'notacredito.edit',
            'delete' => 'notacredito.eliminar',
            'search' => 'notacredito.buscar',
            'index'  => 'notacredito.index',
        );


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Mostrar el resultado de búsquedas
     *
     * @return Response
     */
    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Notacredito';
        $nombre             = Libreria::getParam($request->input('cliente'));
        $sucursal         = Libreria::getParam($request->input('sucursal_id'));
        $numero        = Libreria::getParam($request->input('numero'));
        $fechainicio        = Libreria::getParam($request->input('fechainicio'));
        $fechafin       = Libreria::getParam($request->input('fechafin'));
        // $resultado        = Category::where('nombre', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('nombre', 'ASC');
        $resultado        = NotaCredito::listarNota($sucursal,$fechainicio,$fechafin,null , $numero, $nombre);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Doc.Ref', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cliente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Usuario', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Total', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '3');

        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'NotaCredito';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;

        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'NotaCredito';
        $numero = $this->generarNumero();

        $formData = array('notacredito.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview.'.mant')->with(compact('numero','formData', 'entidad', 'boton', 'listar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'motivo' => 'required',
            'comentario' => 'required',
            'documento' => 'required|exists:movimiento,id',
            'sucursal_id' => 'required|exists:sucursal,id',
        );
        $mensajes = array(
            'motivo.required'         => 'Seleccione el motivo',
            'comentario.required'         => 'Ingrese un comentario',
            'documento.required'         => 'Seleccione un documento de referencia',
            'sucursal.required'         => 'Seleccione una sucursal',
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $user = Auth::user();
        $dat = array();

        $caja_sesion_id     = session('caja_sesion_id', '0');
        $caja_sesion        = Caja::where('id', $caja_sesion_id)->first();
        $estado_caja        = $caja_sesion->estado;

        try {
            if ($estado_caja == 'CERRADA') {
                $dat[0] = array("respuesta" => "ERROR", "msg" => "CAJA CERRADA");
                throw new \Exception(json_encode($dat));
            }
            $error = DB::transaction(function () use ($request, $user, &$dat , $caja_sesion) {
                $venta = Movimiento::find($request->input('documento'));
                if(!$venta){
                    $dat[0] = array("respuesta" => "ERROR", "msg" => "DOCUMENTO NO VÁLIDO");
                    throw new \Exception(json_encode($dat));
                }

                //-------------------CREAR VENTA------------------------
                    $notacredito = new NotaCredito();
                    $notacredito->numero = $request->input('numeronota');
                    $notacredito->fecha = $request->input('fecha');

                    $notacredito->persona_id = $venta->persona_id;
                    $notacredito->responsable_id = $user->person_id;
                    // $notacredito->concepto_id = ;
                    // $notacredito->tipomovimiento_id = $user->person_id;
                    // $notacredito->tipodocumento_id = $user->person_id;
                    $notacredito->total = $request->input('totalnotacredito');
                    $notacredito->igv = round( ($request->input('totalnotacredito')*0.18) , 2);
                    $notacredito->subtotal =    round( ($notacredito->total - $notacredito->igv) , 2);
                    $notacredito->comentario = Libreria::getParam($request->input('comentario'));
                    $notacredito->situacion = 'C';
                    $notacredito->movimiento_id = $venta->id;
                    $notacredito->motivo_id = $request->input('motivo');
                    $notacredito->caja_id = $caja_sesion->id;
                    $notacredito->sucursal_id = $request->input('sucursal_id');
                    $notacredito->save();
                //---------------------FIN CREAR VENTA------------------------

                //---------------------DETALLES VENTA------------------------------
                $arr = explode(",", $request->input('listDetalles'));
                //dd($request);
                for ($c = 0; $c < count($arr); $c++) {
                    $detalleventa = Detallemovimiento::find($arr[$c]);
                    $detallenota = new Detallenotacredito();
                    $detallenota->producto_id = $detalleventa->producto_id;
                    $detallenota->cantidad      = $detalleventa->cantidad;
                    $detallenota->precioventa = $detalleventa->precioventa;
                    $detallenota->preciocompra = $detalleventa->preciocompra;
                    $detallenota->movimiento_id = $notacredito->id;
                    $detallenota->save();
                }
                //-----------------------FIN DETALLES VENTA------------------------------


                $dat[0] = array("respuesta" => "OK", "venta_id" => $notacredito->id, "tipodocumento_id" => "0");
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return is_null($error) ? json_encode($dat) : $error;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'notacredito');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $notacredito = NotaCredito::find($id);
        $detalles = Detallenotacredito::where('movimiento_id',$id)->get();
        $entidad  = 'NotaCredito';
        $conf_codigobarra = CODIGO_BARRAS;
        // $formData = array('notacredito.update', $id);
        // $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $formData = array('class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mantview')->with(compact('conf_codigobarra','notacredito','detalles' , 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'category');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array('nombre' => 'required|max:50');
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $id){
            $category = Category::find($id);
            $category->nombre = strtoupper($request->input('nombre'));
            $category->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'notacredito');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $marca= NotaCredito::find($id);
            $marca->situacion = 'A';
            $marca->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'notacredito');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = NotaCredito::find($id);
        $entidad  = 'NotaCredito';
        $formData = array('route' => array('notacredito.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function documentoautocompletar(Request $request)
    {

        $term = trim($request->q);
        $fecha = date('Y-m-d');
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        $resultado        = Category::where('category.nombre', 'like', '%' . strtoupper($term) . '%');
        $resultado        = Movimiento::where('tipomovimiento_id',2)
                            ->where('tipodocumento_id','<>',5) // TICKET
                            ->where('situacion','<>', 'A')
                            ->where('fecha', '<' , $nuevafecha)
                            ->where('movimiento.numero', 'like', '%' . strtoupper($term) . '%');

        $tags = $resultado->orderBy('movimiento.numero', 'ASC')->get();
        // $tags     = $resultado->select('category.*')->get();
        $formatted_tags = [];
        // $formatted_tags[] = ['id' => '0', 'text' => 'Todos'];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->numero];
        }
        return \Response::json($formatted_tags);
    }
    public function obtenerCliente(Request $request)
    {
        $idmov = $request->input('idmovimiento');

        $resultado  = Movimiento::find($idmov);
        $detalles = [];
        if($resultado){
            $cliente = $resultado->persona->apellidopaterno.' '.$resultado->persona->apellidomaterno.' '.$resultado->persona->nombres;

            $detalles = Detallemovimiento::where('movimiento_id', $idmov)->get();
            foreach ($detalles as $key => $detalle) {
                $detalle->producto;
            }
        }else{
            $cliente = '';
        }
        return \Response::json(['id'=>$idmov,'cliente'=>$cliente , 'detalles' => $detalles , 'total' => $resultado->total] );
    }

    public function generarNumero(){
        $caja_sesion_id     = session('caja_sesion_id', '0');
        $caja_sesion        = Caja::where('id', $caja_sesion_id)->first();
        $serie = str_pad($caja_sesion->serie , 2 , '0', STR_PAD_LEFT);

        $ultimaNota = NotaCredito::orderBy('numero','DESC')->first();
        if($ultimaNota){
            $numero = intval( substr($ultimaNota->numero , -8) ) +1;
        }else{
            $numero = '1';
        }
        $numero =  str_pad(''.$numero , 8 , '0', STR_PAD_LEFT);
        $numero = 'C'. $serie .'-'. $numero;
        return $numero;
    }
}
