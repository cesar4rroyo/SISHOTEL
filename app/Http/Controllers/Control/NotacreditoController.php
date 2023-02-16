<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Procesos\Caja;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\DetalleCaja;
use App\Models\Procesos\DetalleComprobante;
use App\Models\Procesos\Detallenotacredito;
use App\Models\Procesos\Motivonotacredito;
use App\Models\Procesos\Movimiento;
use App\Models\Procesos\NotaCredito;
use Illuminate\Support\Facades\DB;
use Validator;

class NotacreditoController extends Controller
{
    protected $folderview      = 'control.notacredito';
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
        $resultado        = NotaCredito::with('usuario', 'persona', 'comprobante')->listarNota($fechainicio,$fechafin,$numero, $nombre);
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
        $entidad  = 'notacredito';
        $numero = $this->generarNumero(1);
        $venta = null;
        $formData = array('notacredito.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview.'.mant')->with(compact('numero','formData', 'entidad', 'boton', 'listar', 'venta'));
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
        if(($request->total) < ($request->totalnotacredito)){
            return 1;
        }
        $reglas     = array(
            'motivo' => 'required',
            'comentario' => 'required',
            'documento' => 'required|exists:comprobante,id',
            'totalnotacredito'=>'required'
        );
        $mensajes = array(
            'motivo.required'         => 'Seleccione el motivo',
            'comentario.required'         => 'Ingrese un comentario',
            'documento.required'         => 'Seleccione un documento de referencia',
            'totalnotacredito.required' =>'El total es requerido'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $user_id = session()->all()['usuario_id'];
        $dat = array();

        $cajaApertura =
            Caja::with('movimiento', 'persona', 'concepto')
            ->latest('created_at')->first()->toArray();
            

        try {
           /*  if ($cajaApertura['concepto_id'] == '2') {
                $dat[0] = array("respuesta" => "ERROR", "msg" => "CAJA CERRADA");
                throw new \Exception(json_encode($dat));
            } */
            $error = DB::transaction(function () use ($request, $user_id, &$dat) {
                $venta = Comprobante::find($request->input('documento'));
                if(!$venta){
                    $dat[0] = array("respuesta" => "ERROR", "msg" => "DOCUMENTO NO VÁLIDO");
                    throw new \Exception(json_encode($dat));
                }

                //-------------------CREAR VENTA------------------------
                    $notacredito = NotaCredito::create([
                        'numero'=>$request->numeronota,
                        'fecha'=>$request->fecha,
                        'persona_id'=>$venta->persona_id,
                        'total'=>$request->totalnotacredito,
                        'igv'=>round(($request->totalnotacredito*0.18) , 2),
                        'subtotal'=>round($request->totalnotacredito - round(($request->totalnotacredito*0.18) , 2), 2),
                        'usuario_id'=>session()->all()['usuario_id'],
                        'observacion'=>$request->comentario,
                        'motivo'=>$request->motivo,
                        'concepto_id'=>3,
                        'comprobante_id'=>$venta->id,
                    ]);
                //---------------------FIN CREAR VENTA------------------------

                //---------------------DETALLES VENTA------------------------------
                $arr = explode(",", $request->input('listDetalles'));
                //dd($request);
                if(count($arr)>=2){
                    for ($c = 0; $c < count($arr); $c++) {
                        $detalleventa = DetalleComprobante::find($arr[$c]);
                        $detallenota = new Detallenotacredito();
                        if(!is_null($detalleventa->producto_id)){
                            $detallenota->producto_id = $detalleventa->producto_id;
                        }else{
                            $detallenota->servicio_id = $detalleventa->servicio_id;
                        }
                        $detallenota->cantidad    = $detalleventa->cantidad;
                        $detallenota->precioventa = $detalleventa->precioventa;
                        $detallenota->preciocompra = $detalleventa->preciocompra;
                        $detallenota->notacredito_id = $notacredito->id;
                        $detallenota->comprobante_id = $venta->id;
                        $detallenota->save();
                    }
                }else{
                    $detalleventa = DetalleComprobante::find($arr[0]);
                    $detallenota = new Detallenotacredito();
                    if(!is_null($detalleventa->producto_id)){
                        $detallenota->producto_id = $detalleventa->producto_id;
                    }else{
                        $detallenota->servicio_id = $detalleventa->servicio_id;
                    }
                    $detallenota->cantidad    = $detalleventa->cantidad;
                    $detallenota->precioventa = $request->totalnotacredito;
                    $detallenota->preciocompra = $detalleventa->preciocompra;
                    $detallenota->notacredito_id = $notacredito->id;
                    $detallenota->comprobante_id = $venta->id;
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
        $notacredito = NotaCredito::with('comprobante', 'persona')->find($id);
        $cliente='';
        if((($notacredito->persona->razonsocial)!=null || ($notacredito->persona->razonsocial)!='')&&($notacredito->persona->ruc!='' || $notacredito->persona->ruc!=null)){
            $cliente = $notacredito->persona->razonsocial;
        }else{
            $cliente = $notacredito->persona->nombres . ' ' . $notacredito->persona->apellidos;
        }
        $detalles = Detallenotacredito::with('producto', 'servicio')->where('notacredito_id',$id)->get();
        $entidad  = 'notacredito';
        // $formData = array('notacredito.update', $id);
        // $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $formData = array('class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mantview')->with(compact('notacredito','detalles' , 'formData', 'entidad', 'boton', 'listar', 'cliente'));
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
        $resultado        = Comprobante::with('detallecomprobante.producto', 'detallecomprobante.servicios')
                            ->where('tipodocumento','!=', 'Ticket')
                            ->where('numero', 'like', '%' . strtoupper($term) . '%');
        $tags = $resultado->orderBy('numero', 'ASC')->get();
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
        $resultado  = Comprobante::find($idmov);
        $detalles = [];
        if($resultado){
            if($resultado->tipodocumento=='boleta'){
                $numero = $this->generarNumero(1);
                //1 ->>>boleta
            }else if($resultado->tipodocumento=='factura'){
                $numero = $this->generarNumero(2);
                //2 ->>>factura
            }
            $cliente = $resultado->persona->apellidos.' '.$resultado->persona->nombres;
            $detalles = DetalleComprobante::where('comprobante_id', $idmov)->get();
            foreach ($detalles as $key => $detalle) {
                if(!is_null($detalle->producto)){
                    $detalle->producto;
                }else{
                    $detalle->servicios;
                }
            }
        }else{
            $cliente = '';
        }
        return \Response::json(['id'=>$idmov,'cliente'=>$cliente , 'detalles' => $detalles , 'total' => $resultado->total, 'numero'=>$numero] );
    }

    public function generarNumero($tipo=null){               
        $serie = str_pad(63 , 2 , '0', STR_PAD_LEFT);
        if($tipo==1){
            $ultimaNota = NotaCredito::where('numero', 'like', '%'.'BC'.'%')->orderBy('numero','DESC')->first();
            if($ultimaNota){
                $numero = intval( substr($ultimaNota->numero , -8) ) +1;
            }else{
                $numero = '1';
            }
            $numero =  str_pad(''.$numero , 8 , '0', STR_PAD_LEFT);
            $numero = 'BC'. $serie .'-'. $numero;
        }else if($tipo==2){
            $ultimaNota = NotaCredito::where('numero', 'like', '%'.'FC'.'%')->orderBy('numero','DESC')->first();
            if($ultimaNota){
                $numero = intval( substr($ultimaNota->numero , -8) ) +1;
            }else{
                $numero = '1';
            }
            $numero =  str_pad(''.$numero , 8 , '0', STR_PAD_LEFT);
            $numero = 'FC'. $serie .'-'. $numero;
        }
        
        return $numero;
    }
}
