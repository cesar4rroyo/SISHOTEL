<?php

namespace App\Services;

use App\Interfaces\CRUDInterfaceService;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\DB;

class TipoHabitacionService extends InitService implements CRUDInterfaceService

{
    public function __construct()
    {
        $this->modelo = new TipoHabitacion();
        $this->entity = 'tipohabitacion';
        $this->folderview = 'habitacion.tipohabitacion';
        $this->tituloAdmin = 'Tipo de Habitación';
        $this->tituloRegistrar = 'Registrar Tipo de Habitación';
        $this->tituloModificar = 'Modificar Tipo de Habitación';
        $this->tituloEliminar = 'Eliminar Tipo de Habitación';
        $this->rutas = [
            'search' => 'tipohabitacion.buscar',
            'index' => 'tipohabitacion.index',
            'store' => 'tipohabitacion.store',
            'delete' => 'tipohabitacion.eliminar',
            'create' => 'tipohabitacion.create',
            'edit' => 'tipohabitacion.edit',
            'update' => 'tipohabitacion.update',
            'destroy' => 'tipohabitacion.destroy',
        ];
        $this->idForm = 'formMantenimiento' . $this->entity;
        //INSTACIA DE LIBRERIA
        $this->clsLibreria = new Libreria();
        //LLENAR CABECERAS DE LA TABLA
        $this->cabecera = [
            [
                'valor' => '#',
                'numero' => '1',
            ],
            [
                'valor' => 'Nombre',
                'numero' => '1',
            ],
            [
                'valor' => 'Capacidad',
                'numero' => '1',
            ],
            [
                'valor' => 'Precio',
                'numero' => '1',
            ],
        ];
    }

    public function searchService(Request $request)
    {
        //AMBAS OPCIONES LLEGAN DESDE LA VISTA

        $paginas = $request->get('page');
        $filas = $request->get('filas');

        //AQUI OBTENER LOS DATOS QUE VIENEN DEL BUSCADOR DETERMINADO EN LA VISTA
        $nombre = Libreria::getParam($request->get('nombre'));

        //BUSCAR EN EL MODELOS
        $resultado = $this->modelo::listar($nombre);
        $lista = $resultado->get();

        //SETEAR VALORES PARA LA VISTA
        $entidad = $this->entity;
        $titulo_eliminar = $this->tituloEliminar;
        $titulo_modificar = $this->tituloModificar;
        $titulo_admin = $this->tituloAdmin;
        $cabecera = $this->cabecera;
        $ruta = $this->rutas;

        if (count($lista) > 0) {
            $paramPaginacion = $this->clsLibreria->generarPaginacion($lista, $paginas, $filas, $this->entity);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paramPaginacion['nuevapagina']));

            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'titulo_admin'));
        }

        return view($this->folderview . '.list')->with('lista', $lista)->with('entidad', $this->entity);
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
            'entidad' => $this->entity,
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
