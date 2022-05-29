<?php

namespace App\Services;

class InitService
{
    protected $folderview;     
    protected $tituloAdmin;    
    protected $tituloRegistrar; 
    protected $tituloModificar; 
    protected $tituloEliminar; 
    protected $rutas;
    protected $cabecera;
    protected $entity;
    protected $clsLibreria;
    protected $idForm;
    protected $autocomplete;
    protected $modelo;

    public static function MessageResponse($message, $class)
    {
        return "<alert class='mt-5 alert alert-". $class ."'> Ha ocurrido un error: " . $message . "</alert>";
    }
    
    
    
}