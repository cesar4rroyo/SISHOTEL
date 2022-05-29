<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface CRUDInterfaceService
{
    public function searchService(Request $request);
    public function indexService();
    public function createService(Request $request);
    public function storeService(Request $request);
    public function editService($id, Request $request);
    public function updateService(Request $request, $id);
    public function destroyService($id);
    public function eliminarService($id, $listarLuego);
}