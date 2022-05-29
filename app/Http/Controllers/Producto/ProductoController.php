<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Categoria;
use App\Models\OpcionMenu;
use App\Models\Producto;
use App\Models\Unidad;
use App\Services\InitService;
use App\Services\ProductoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProductoController extends Controller
{

    private $service;

    public function __construct()
    {   
        $this->service = new ProductoService();
    }


    public function buscar(Request $request)
    {
        try {
           return $this->service->searchService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function index(Request $request)
    {
        try {
            return $this->service->indexService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function create(Request $request)
    {
        try {
            return $this->service->createService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function store(ProductRequest $request)
    {
        try {
            return $this->service->storeService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function edit($id, Request $request)
    {
        try {
            return $this->service->editService($id, $request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function update(ProductRequest $request, $id)
    {
        try {
            return $this->service->updateService($request, $id);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        } 
    }

    public function eliminar($id, $listarLuego)
    {
        try {
            return $this->service->eliminarService($id, $listarLuego);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function destroy()
    {
        // try {
        //     return $this->service->destroyService($producto->id);
        // } catch (\Throwable $th) {
        //     return InitService::MessageResponse($th->getMessage(), 'danger');
        // }
    }
}
