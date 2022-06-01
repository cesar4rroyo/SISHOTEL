<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoUsuarioRequest;
use App\Services\InitService;
use App\Services\TipoUsuarioService;

class TipoUserController extends Controller
{
    private $service;

    public function __construct()
    {   
        $this->service = new TipoUsuarioService();
    }


    public function buscar(Request $request)
    {
        try {
           return $this->service->searchService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }


    public function index()
    {
        try {
            return $this->service->indexService();
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

    public function store(TipoUsuarioRequest $request)
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


    public function update(TipoUsuarioRequest $request, $id)
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


    public function destroy($id)
    {
        try {
            return $this->service->destroyService($id);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

   
}
