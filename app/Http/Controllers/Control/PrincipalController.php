<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CajaRequest;
use App\Services\InitService;
use App\Services\PrincipalService;

class PrincipalController extends Controller
{
    protected $servce;

    public function __construct()
    {
        $this->service = new PrincipalService();
    }

    public function index()
    {
        try {
            return $this->service->indexService();
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function buscar(Request $request)
    {
        try {
           return $this->service->searchService($request);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function checkin(Request $request, $id)
    {
        dd($request->all());
        try {
            return $this->service->checkinService($request, $id);
        } catch (\Throwable $th) {
            return InitService::MessageResponse($th->getMessage(), 'danger');
        }
    }

    public function generarNumero(Request $request)
    {
        try {
            return $this->service->generarNumeroService($request->tipo);
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

    public function store(Request $request)
    {
        dd($request->all());
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


    public function update(CajaRequest $request, $id)
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
