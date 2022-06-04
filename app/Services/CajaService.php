<?php

namespace App\Services;

use App\Interfaces\CRUDInterfaceService;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\Concepto;
use App\Models\Procesos\Caja;
use Illuminate\Support\Facades\DB;

class CajaService extends InitService implements CRUDInterfaceService
{

    protected $idApertura = 0;
    protected $idCierre = 0;
    protected $status = 0; // 0 = Cerrado, 1 = Abierto
    protected $ingresos = 0;
    protected $egresos = 0;
    protected $saldo = 0;
    protected $montoefectivo = 0;
    protected $montovisa = 0;
    protected $montomastercard = 0;
    protected $montoamex = 0;
    protected $montoyape = 0;
    protected $montoplin = 0;
    protected $montodeposito = 0;
    protected $totaltarjetas = 0;
    protected $totaltransferencias = 0;
    
    public function __construct()
    {
        $this->modelo = new Caja();
        $this->idApertura = $this->modelo->idUltimaApertura();
        $this->ingresos = $this->modelo->generarTotalIngresos();
        $this->egresos = $this->modelo->generarTotalEgresos();
        $this->saldo = $this->ingresos - $this->egresos;
        $this->montoefectivo = $this->modelo->generarTotalEfectivo();
        $this->montovisa = $this->modelo->generarTotalVisa();
        $this->montomastercard = $this->modelo->generarTotalMastercard();
        $this->montoamex = $this->modelo->generarTotalAmex();
        $this->montoyape = $this->modelo->generarTotalYape();
        $this->montoplin = $this->modelo->generarTotalPlin();
        $this->montodeposito = $this->modelo->generarTotalDeposito();
        $this->totaltarjetas = $this->modelo->generarTotalTarjetas();
        $this->totaltransferencias = $this->modelo->generarTotalTransferencias();

        if ($this->modelo->cajaAbierta()) {
            $this->status = 1;
        }

        $this->entity = 'caja';
        $this->folderview = 'control.caja2';
        $this->tituloAdmin = 'Caja';
        $this->tituloRegistrar = 'Registrar Caja';
        $this->tituloModificar = 'Modificar Caja';
        $this->tituloEliminar = 'Eliminar Caja';
        $this->rutas = [
            'search' => 'caja.buscar',
            'index' => 'caja.index',
            'store' => 'caja.store',
            'delete' => 'caja.eliminar',
            'create' => 'caja.create',
            'edit' => 'caja.edit',
            'update' => 'caja.update',
            'destroy' => 'caja.destroy',
        ];
        $this->idForm = 'formMantenimiento' . $this->entity;
        //INSTACIA DE LIBRERIA
        $this->clsLibreria = new Libreria();
        //LLENAR CABECERAS DE LA TABLA
        $this->cabecera = [
            [
                'valor' => 'Fecha',
                'numero' => '1',
            ],
            [
                'valor' => 'Tipo',
                'numero' => '1',
            ],
            [
                'valor' => 'Persona',
                'numero' => '1',
            ],
            [
                'valor' => 'Total',
                'numero' => '1',
            ],
            [
                'valor' => 'Concepto',
                'numero' => '1',
            ],
            [
                'valor' => 'Comentario',
                'numero' => '1',
            ],
            [
                'valor' => 'Movimiento',
                'numero' => '1',
            ],
            [
                'valor' => 'Usuario',
                'numero' => '1',
            ],
            [
                'valor' => 'Acciones',
                'numero' => '1',
            ]
        ];
    }

    public function searchService(Request $request)
    {
        //AMBAS OPCIONES LLEGAN DESDE LA VISTA

        $paginas = $request->get('page');
        $filas = $request->get('filas');

        //AQUI OBTENER LOS DATOS QUE VIENEN DEL BUSCADOR DETERMINADO EN LA VISTA
        $tipo = Libreria::getParam($request->get('tipo'));

        //BUSCAR EN EL MODELOS
        $resultado = $this->modelo::listar($tipo, $this->idApertura);
        $lista = $resultado->get();

        //SETEAR VALORES PARA LA VISTA
        $entidad = $this->entity;
        $titulo_eliminar = $this->tituloEliminar;
        $titulo_modificar = $this->tituloModificar;
        $titulo_admin = $this->tituloAdmin;
        $cabecera = $this->cabecera;
        $ruta = $this->rutas;
        $status = $this->status;

        $totales = [
            'ingresos' => $this->ingresos,
            'egresos' => $this->egresos,
            'saldo' => $this->saldo,
            'montoefectivo' => $this->montoefectivo,
            'montovisa' => $this->montovisa,
            'montomastercard' => $this->montomastercard,
            'montoamex' => $this->montoamex,
            'montoyape' => $this->montoyape,
            'montoplin' => $this->montoplin,
            'montodeposito' => $this->montodeposito,
            'totaltarjetas' => $this->totaltarjetas,
            'totaltransferencias' => $this->totaltransferencias,
        ];

        if (count($lista) > 0) {
            $paramPaginacion = $this->clsLibreria->generarPaginacion($lista, $paginas, $filas, $this->entity);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paramPaginacion['nuevapagina']));

            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'titulo_admin', 'status', 'totales')); 
        }

        return view($this->folderview . '.list')->with('lista', $lista)->with('entidad', $this->entity)->with('status', $this->status)->with('ruta', $this->rutas)->with('totales', $totales);
    }

    public function indexService()
    {
        return view($this->folderview . '.index')->with([
            'entidad' => $this->entity,
            'titulo_modificar' => $this->tituloModificar,
            'titulo_eliminar' => $this->tituloEliminar,
            'titulo_admin' => $this->tituloAdmin,
            'titulo_registrar' => $this->tituloRegistrar,
            'ruta' => $this->rutas,
            'cboRangeFilas' => $this->clsLibreria->cboRangeFilas(),
            'cboTipo' => $this->clsLibreria->generateCboGeneral(Concepto::class, 'nombre', 'id', 'Todos'),
            'status' => $this->status,
        ]);
    }

    public function createService(Request $request)
    {
        switch ($request->get('option')) {
            case 'APERTURA':
                $selectedTipo = 'INGRESO';
                $selectedConcepto = 1;
                break;
            case 'CIERRE':
                $selectedTipo = 'EGRESO';
                $selectedConcepto = 2;
                break;
            case 'NEW':
                $selectedTipo = '';
                $selectedConcepto = '';
                break;
            default:
                InitService::MessageResponse('warning', 'Operación no permitida');
                break;
        }
        $numero  = $this->modelo->generarNumero();
        $formData = [
            'route' => $this->rutas['store'],
            'method' => 'POST',
            'class' => 'form-horizontal',
            'id' => $this->idForm,
            'autocomplete' => 'off',
            'entidad' => $this->entity,
            'listar' => Libreria::getParam($request->input('listar'), 'NO'),
            'boton' => 'Registrar',
            'cboTipo' => ['' => 'Seleccione una opción', 'INGRESO' => 'INGRESO', 'EGRESO' => 'EGRESO'],
            'fecha' => date('Y-m-d'),
            'numero' => $numero,
            'opcion' => $request->get('option'),
            'selectedTipo' => $selectedTipo,
            'selectedConcepto' => $selectedConcepto,
            'cboConcepto' => $this->clsLibreria->generateCboGeneral(Concepto::class, 'nombre', 'id', 'Seleccione una opción'),
        ];
        return view($this->folderview . '.create')->with(compact('formData'));
    }

    public function storeService(Request $request)
    {
        $error = DB::transaction(function () use ($request) {
            $model = $this->modelo->create($request->all());
        });
        return is_null($error) ? "OK" : $error;
    }

    public function editService($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if ($existe !== true) {
            return $existe;
        }
        $formData = [
            'route' => array($this->rutas['update'], ['id' => $id]),
            'method' => 'PUT',
            'class' => 'form-horizontal',
            'id' => $this->idForm,
            'autocomplete' => 'off',
            'model' => $this->modelo->find($id),
            'listar' => Libreria::getParam($request->input('listar'), 'NO'),
            'boton' => 'Modificar',
            'cboCategorias' => $this->clsLibreria->cboCategorias(),
            'cboUnidades' => $this->clsLibreria->cboUnidades(),
            'entidad' => $this->entity,
        ];
        return view($this->folderview . '.create')->with(compact('formData'));
    }

    public function updateService(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if (!$existe) {
            return $existe;
        }
        $error = DB::transaction(function () use ($request, $id) {
            $this->modelo->find($id)->update($request->all());
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminarService($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if (!$existe) {
            return $existe;
        }
        $listar = 'NO';
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $formData = [
            'route' => array($this->rutas['destroy'], ['model' => $this->modelo->find($id)]),
            'method' => 'DELETE',
            'class' => 'form-horizontal',
            'id' => $this->idForm,
            'autocomplete' => 'off',
            'boton' => 'Eliminar',
            'entidad' => $this->entity,
            'listar' => $listar,
            'modelo' => $this->modelo->find($id),
        ];
        return view('utils.confirmDelete')->with(compact('formData'));
    }

    public function destroyService($id)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if (!$existe) {
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $this->modelo->find($id)->delete();
        });
        return is_null($error) ? "OK" : $error;
    }
}
