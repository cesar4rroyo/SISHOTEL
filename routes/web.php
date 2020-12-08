<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;


Route::get('/', 'InicioController@index');


Route::group(['prefix' => 'admin', 'namespace'], function () {
    /* Rutas de ACCESO */
    Route::get('acceso/create', 'Admin\AccesoController@create')->name('create_acceso');
    Route::get('acceso', 'Admin\AccesoController@index')->name('acceso');
    Route::get('acceso/{id}', 'Admin\AccesoController@show')->name('show_acceso');
    Route::post('acceso', 'Admin\AccesoController@store')->name('store_acceso');
    Route::get('acceso/{id}/edit', 'Admin\AccesoController@edit')->name('edit_acceso');
    Route::put('acceso/{id}', 'Admin\AccesoController@update')->name('update_acceso');
    Route::delete('acceso/{id}/destroy', 'Admin\AccesoController@destroy')->name('destroy_acceso');
    /* Rutas de GRUPOMENU */
    Route::get('grupomenu/create', 'Admin\GrupoMenuController@create')->name('create_grupomenu');
    Route::get('grupomenu', 'Admin\GrupoMenuController@index')->name('grupomenu');
    Route::get('grupomenu/{id}', 'Admin\GrupoMenuController@show')->name('show_grupomenu');
    Route::post('grupomenu', 'Admin\GrupoMenuController@store')->name('store_grupomenu');
    Route::get('grupomenu/{id}/edit', 'Admin\GrupoMenuController@edit')->name('edit_grupomenu');
    Route::put('grupomenu/{id}', 'Admin\GrupoMenuController@update')->name('update_grupomenu');
    Route::delete('grupomenu/{id}/destroy', 'Admin\GrupoMenuController@destroy')->name('destroy_grupomenu');
    /* Rutas de NACIONALIDAD */
    Route::get('nacionalidad/create', 'Admin\NacionalidadController@create')->name('create_nacionalidad');
    Route::get('nacionalidad', 'Admin\NacionalidadController@index')->name('nacionalidad');
    Route::get('nacionalidad/{id}', 'Admin\NacionalidadController@show')->name('show_nacionalidad');
    Route::post('nacionalidad', 'Admin\NacionalidadController@store')->name('store_nacionalidad');
    Route::get('nacionalidad/{id}/edit', 'Admin\NacionalidadController@edit')->name('edit_nacionalidad');
    Route::put('nacionalidad/{id}', 'Admin\NacionalidadController@update')->name('update_nacionalidad');
    Route::delete('nacionalidad/{id}/destroy', 'Admin\NacionalidadController@destroy')->name('destroy_nacionalidad');
    /* Rutas de OPCIONMENU */
    Route::get('opcionmenu/create', 'Admin\OpcionMenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'Admin\OpcionMenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/{id}', 'Admin\OpcionMenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'Admin\OpcionMenuController@store')->name('store_opcionmenu');
    Route::get('opcionmenu/{id}/edit', 'Admin\OpcionMenuController@edit')->name('edit_opcionmenu');
    Route::put('opcionmenu/{id}', 'Admin\OpcionMenuController@update')->name('update_opcionmenu');
    Route::delete('opcionmenu/{id}/destroy', 'Admin\OpcionMenuController@destroy')->name('destroy_opcionmenu');
    /* Rutas de PERSONA */
    Route::get('persona/create', 'Admin\PersonaController@create')->name('create_persona');
    Route::get('persona', 'Admin\PersonaController@index')->name('persona');
    Route::get('persona/{id}', 'Admin\PersonaController@show')->name('show_persona');
    Route::post('persona', 'Admin\PersonaController@store')->name('store_persona');
    Route::get('persona/{id}/edit', 'Admin\PersonaController@edit')->name('edit_persona');
    Route::put('persona/{id}', 'Admin\PersonaController@update')->name('update_persona');
    Route::delete('persona/{id}/destroy', 'Admin\PersonaController@destroy')->name('destroy_persona');
    /* Rutas de ROL */
    Route::get('rol/create', 'Admin\RolController@create')->name('create_rol');
    Route::get('rol', 'Admin\RolController@index')->name('rol');
    Route::get('rol/{id}', 'Admin\RolController@show')->name('show_rol');
    Route::post('rol', 'Admin\RolController@store')->name('store_rol');
    Route::get('rol/{id}/edit', 'Admin\RolController@edit')->name('edit_rol');
    Route::put('rol/{id}', 'Admin\RolController@update')->name('update_rol');
    Route::delete('rol/{id}/destroy', 'Admin\RolController@destroy')->name('destroy_rol');
    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'Admin\RolPersonaController@index')->name('rolpersona');
    Route::post('rolpersona', 'Admin\RolPersonaController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::get('tipousuario/create', 'Admin\TipoUserController@create')->name('create_tipousuario');
    Route::get('tipousuario', 'Admin\TipoUserController@index')->name('tipousuario');
    Route::get('tipousuario/{id}', 'Admin\TipoUserController@show')->name('show_tipousuario');
    Route::post('tipousuario', 'Admin\TipoUserController@store')->name('store_tipousuario');
    Route::get('tipousuario/{id}/edit', 'Admin\TipoUserController@edit')->name('edit_tipousuario');
    Route::put('tipousuario/{id}', 'Admin\TipoUserController@update')->name('update_tipousuario');
    Route::delete('tipousuario/{id}/destroy', 'Admin\TipoUserController@destroy')->name('destroy_tipousuario');
    /* Rutas de USUARIO */
    Route::get('usuario/create', 'Admin\UsuarioController@create')->name('create_usuario');
    Route::get('usuario', 'Admin\UsuarioController@index')->name('usuario');
    Route::get('usuario/{id}', 'Admin\UsuarioController@show')->name('show_usuario');
    Route::post('usuario', 'Admin\UsuarioController@store')->name('store_usuario');
    Route::get('usuario/{id}/edit', 'Admin\UsuarioController@edit')->name('edit_usuario');
    Route::put('usuario/{id}', 'Admin\UsuarioController@update')->name('update_usuario');
    Route::delete('usuario/{id}/destroy', 'Admin\UsuarioController@destroy')->name('destroy_usuario');
});

/* Rutas de CATEGORIA */
Route::get('categoria/create', 'Producto\CategoriaController@create')->name('create_categoria');
Route::get('categoria', 'Producto\CategoriaController@index')->name('categoria');
Route::get('categoria/{id}', 'Producto\CategoriaController@show')->name('show_categoria');
Route::post('categoria', 'Producto\CategoriaController@store')->name('store_categoria');
Route::get('categoria/{id}/edit', 'Producto\CategoriaController@edit')->name('edit_categoria');
Route::put('categoria/{id}', 'Producto\CategoriaController@update')->name('update_categoria');
Route::delete('categoria/{id}/destroy', 'Producto\CategoriaController@destroy')->name('destroy_categoria');
/* Rutas de UNIDAD */
Route::get('unidad/create', 'Producto\UnidadController@create')->name('create_unidad');
Route::get('unidad', 'Producto\UnidadController@index')->name('unidad');
Route::get('unidad/{id}', 'Producto\UnidadController@show')->name('show_unidad');
Route::post('unidad', 'Producto\UnidadController@store')->name('store_unidad');
Route::get('unidad/{id}/edit', 'Producto\UnidadController@edit')->name('edit_unidad');
Route::put('unidad/{id}', 'Producto\UnidadController@update')->name('update_unidad');
Route::delete('unidad/{id}/destroy', 'Producto\UnidadController@destroy')->name('destroy_unidad');
/* Rutas de PRODUCTO */
Route::get('producto/create', 'Producto\ProductoController@create')->name('create_producto');
Route::get('producto', 'Producto\ProductoController@index')->name('producto');
Route::get('producto/{id}', 'Producto\ProductoController@show')->name('show_producto');
Route::post('producto', 'Producto\ProductoController@store')->name('store_producto');
Route::get('producto/{id}/edit', 'Producto\ProductoController@edit')->name('edit_producto');
Route::put('producto/{id}', 'Producto\ProductoController@update')->name('update_producto');
Route::delete('producto/{id}/destroy', 'Producto\ProductoController@destroy')->name('destroy_producto');


/* Rutas de TIPOHABITACION */
Route::get("tipohabitacion/create", 'Habitacion\TipoHabitacionController@create')->name('create_tipohabitacion');
Route::get("tipohabitacion", 'Habitacion\TipoHabitacionController@index')->name('tipohabitacion');
Route::get("tipohabitacion/{id}", 'Habitacion\TipoHabitacionController@show')->name('show_tipohabitacion');
Route::post("tipohabitacion", 'Habitacion\TipoHabitacionController@store')->name('store_tipohabitacion');
Route::get("tipohabitacion/{id}/edit", 'Habitacion\TipoHabitacionController@edit')->name('edit_tipohabitacion');
Route::put("tipohabitacion/{id}", 'Habitacion\TipoHabitacionController@update')->name('update_tipohabitacion');
Route::delete("tipohabitacion/{id}/destroy", 'Habitacion\TipoHabitacionController@destroy')->name('destroy_tipohabitacion');
/* Rutas de PISO */
Route::get('piso/create', 'Habitacion\PisoController@create')->name('create_piso');
Route::get('piso', 'Habitacion\PisoController@index')->name('piso');
Route::get('piso/{id}', 'Habitacion\PisoController@show')->name('show_piso');
Route::post('piso', 'Habitacion\PisoController@store')->name('store_piso');
Route::get('piso/{id}/edit', 'Habitacion\PisoController@edit')->name('edit_piso');
Route::put('piso/{id}', 'Habitacion\PisoController@update')->name('update_piso');
Route::delete('piso/{id}/destroy', 'Habitacion\PisoController@destroy')->name('destroy_piso');

/* Rutas de HABITACION */
Route::get('habitacion/create', 'Habitacion\HabitacionController@create')->name('create_habitacion');
Route::get('habitacion', 'Habitacion\HabitacionController@index')->name('habitacion');
Route::get('habitacion/{id}', 'Habitacion\HabitacionController@show')->name('show_habitacion');
Route::post('habitacion', 'Habitacion\HabitacionController@store')->name('store_habitacion');
Route::get('habitacion/{id}/edit', 'Habitacion\HabitacionController@edit')->name('edit_habitacion');
Route::put('habitacion/{id}', 'Habitacion\HabitacionController@update')->name('update_habitacion');
Route::delete('habitacion/{id}/destroy', 'Habitacion\HabitacionController@destroy')->name('destroy_habitacion');

/* Rutas de CONCEPTO */
Route::get('general/concepto/create', 'ConceptoController@create')->name('create_concepto');
Route::get('general/concepto', 'ConceptoController@index')->name('concepto');
Route::get('general/concepto/{id}', 'ConceptoController@show')->name('show_concepto');
Route::post('general/concepto', 'ConceptoController@store')->name('store_concepto');
Route::get('general/concepto/{id}/edit', 'ConceptoController@edit')->name('edit_concepto');
Route::put('general/concepto/{id}', 'ConceptoController@update')->name('update_concepto');
Route::delete('general/concepto/{id}/destroy', 'ConceptoController@destroy')->name('destroy_concepto');
/* Rutas de SERVICIOS */
Route::get('general/servicios/create', 'ServiciosController@create')->name('create_servicios');
Route::get('general/servicios', 'ServiciosController@index')->name('servicios');
Route::get('general/servicios/{id}', 'ServiciosController@show')->name('show_servicios');
Route::post('general/servicios', 'ServiciosController@store')->name('store_servicios');
Route::get('general/servicios/{id}/edit', 'ServiciosController@edit')->name('edit_servicios');
Route::put('general/servicios/{id}', 'ServiciosController@update')->name('update_servicios');
Route::delete('general/servicios/{id}/destroy', 'ServiciosController@destroy')->name('destroy_servicios');
