<?php

namespace App\Services;

use App\Interfaces\CRUDInterfaceService;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\Habitacion;
use App\Models\Piso;
use App\Models\Procesos\Comprobante;
use App\Models\Procesos\Movimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrincipalService extends InitService implements CRUDInterfaceService

{
    protected $PISO_SELECTED = 1;

    public function __construct()
    {
        $this->modelo = new Habitacion();
        $this->entity = 'movimiento';
        $this->folderview = 'principal';
        $this->tituloAdmin = 'Habitaciones';
        $this->tituloRegistrar = 'Registrar Habitación';
        $this->tituloModificar = 'Modificar Habitación';
        $this->tituloEliminar = 'Eliminar Habitación';
        $this->rutas = [
            'search' => 'habitaciones.buscar',
            'index' => 'habitaciones.index',
            'store' => 'habitaciones.store',
            'delete' => 'habitaciones.eliminar',
            'create' => 'habitaciones.create',
            'edit' => 'habitaciones.edit',
            'update' => 'habitaciones.update',
            'destroy' => 'habitaciones.destroy',
            'checkin' => 'habitaciones.checkin',
            'addmovimiento' => 'habitaciones.addmovimiento',
            'generarNumero'=> 'habitaciones.generarNumero',
        ];
        $this->idForm = 'formMantenimiento' . $this->entity;
        $this->clsLibreria = new Libreria();
    }

    public function searchService(Request $request)
    {
        $piso = Libreria::getParam($request->get('piso'), 1);
        $pisoModel = Piso::find($piso);
        $resultado = $this->modelo::listar(null, $piso, null);
        $lista = $resultado->get();
        $entidad = $this->entity;
        $titulo_eliminar = $this->tituloEliminar;
        $titulo_modificar = $this->tituloModificar;
        $titulo_admin = $this->tituloAdmin;
        $ruta = $this->rutas;
        if (count($lista) > 0) {
            return view($this->folderview . '.list')->with(compact('lista', 'entidad', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'titulo_admin', 'pisoModel'));
        }
        return view($this->folderview . '.list')->with('lista', $lista)->with('entidad', $this->entity)->with('pisoModel', $pisoModel);
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
            'cboPisos' => $this->clsLibreria->generateCboGeneral(Piso::class, 'nombre', 'id', 'Seleccione un piso'),
            'pisoSelected'=> $this->PISO_SELECTED
        ]);
    }

    public function createService(Request $request)
    {
        $formData = [
            'route' => $this->rutas['store'],
            'method' => 'POST',
            'class' => 'form-horizontal',
            'id' => $this->idForm,
            'autocomplete' => 'off',
            'entidad' => $this->entity,
            'listar' => Libreria::getParam($request->input('listar'), 'NO'),
            'boton' => 'Registrar',
            'habitacion' => $request->id,
            'startDate' => date('Y-m-d H:i:s'),
            'endDate' => date('Y-m-d H:i:s') . ' + 1 day',
            'cboDocumentos' => ['Ticket' => 'Ticket', 'Boleta'=>'Boleta', 'Factura'=>'Factura'],
            'rutaTipoDoc' => $this->rutas['generarNumero'],
        ];
        return view($this->folderview . '.checkin')->with(compact('formData'));
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
            'entidad' => $this->entity,
            'cboPisos' => $this->clsLibreria->generateCboGeneral(Piso::class, 'nombre', 'id', 'Seleccione una Opción'),
            'cboTiposHabitacion' => $this->clsLibreria->generateCboGeneral(TipoHabitacion::class, 'nombre', 'id', 'Seleccione una Opción'),
        ];
        return view($this->folderview . '.create')->with(compact('formData'));
    }

    public function updateService(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if(!$existe){
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
        if(!$existe){
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
            'entidad'=> $this->entity,
            'listar' => $listar,
            'modelo' => $this->modelo->find($id),
        ];
        return view('utils.confirmDelete')->with(compact('formData'));

    }

    public function generarNumeroService($tipo)
    {
        return Comprobante::generarNumero($tipo);
    }

    public function destroyService($id)
    {
        $existe = Libreria::verificarExistencia($id, $this->entity);
        if(!$existe){
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $this->modelo->find($id)->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

}
