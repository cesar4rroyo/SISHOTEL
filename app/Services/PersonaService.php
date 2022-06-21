<?php

namespace App\Services;

use App\Interfaces\CRUDInterfaceService;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class PersonaService extends InitService implements CRUDInterfaceService

{
    public function __construct()
    {
        $this->modelo = new Persona();
        $this->entity = 'persona';
        $this->folderview = 'admin.persona';
        $this->tituloAdmin = 'Persona';
        $this->tituloRegistrar = 'Registrar Persona';
        $this->tituloModificar = 'Modificar Persona';
        $this->tituloEliminar = 'Eliminar Persona';
        $this->rutas = [
            'search' => 'persona.buscar',
            'index' => 'persona.index',
            'store' => 'persona.store',
            'storeFromModal' => 'persona.store.modal',
            'delete' => 'persona.eliminar',
            'create' => 'persona.create',
            'edit' => 'persona.edit',
            'update' => 'persona.update',
            'destroy' => 'persona.destroy',
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
                'valor' => 'Cliente',
                'numero' => '1',
            ],
            [
                'valor' => 'Nro. Documento', 
                'numero' => '1',
            ],
            [
                'valor' => 'Dirección',
                'numero' => '1',
            ],
            [
                'valor' => 'Teléfono',
                'numero' => '1',
            ],
            [
                'valor' => 'Email',
                'numero' => '1',
            ],
            [
                'valor' => 'Operaciones',
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
        if($request->from == 'MODAL'){
            $ruta = array($this->rutas['storeFromModal'], ['type' => 'MODAL']);
        }else{
            $ruta = $this->rutas['store'];
        }
        $formData = [
            'route' => $ruta,
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

    public function storeService(Request $request, $type = null)
    {
        $idCreated = null;
        $error = DB::transaction(function () use ($request, &$idCreated) {
            $model = $this->modelo->create($request->all());
            $model->roles()->sync(2);
            $idCreated = $model->id;
        });
        if(isset($type)){
            $data = [
                'case' => 'storePersonFromModal',
                'id' => 'persona_id',
                'id2' => 'persona_id_comprobante',
                'persona' => $request->nombres,
                'persona_id' => $idCreated,
            ];
            $data = json_encode($data);
            return is_null($error) ? $data : $error;
        }
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
            $model = $this->modelo->find($id);
            $model->roles()->detach();
            $model->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

}
