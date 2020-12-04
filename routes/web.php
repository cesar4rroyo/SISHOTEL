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
    Route::get('opcionmenu/create', 'Admin\OpcionmenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'Admin\OpcionmenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/{id}', 'Admin\OpcionmenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'Admin\OpcionmenuController@store')->name('store_opcionmenu');
    Route::get('opcionmenu/{id}/edit', 'Admin\OpcionmenuController@edit')->name('edit_opcionmenu');
    Route::put('opcionmenu/{id}', 'Admin\OpcionmenuController@update')->name('update_opcionmenu');
    Route::delete('opcionmenu/{id}/destroy', 'Admin\OpcionmenuController@destroy')->name('destroy_opcionmenu');
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
    Route::get('rolpersona/create', 'Admin\RolpersonaController@create')->name('create_rolpersona');
    Route::get('rolpersona', 'Admin\RolpersonaController@index')->name('rolpersona');
    Route::get('rolpersona/{id}', 'Admin\RolpersonaController@show')->name('show_rolpersona');
    Route::post('rolpersona', 'Admin\RolpersonaController@store')->name('store_rolpersona');
    Route::get('rolpersona/{id}/edit', 'Admin\RolpersonaController@edit')->name('edit_rolpersona');
    Route::put('rolpersona/{id}', 'Admin\RolpersonaController@update')->name('update_rolpersona');
    Route::delete('rolpersona/{id}/destroy', 'Admin\RolpersonaController@destroy')->name('destroy_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::get('tipoUser/create', 'Admin\TipoUserController@create')->name('create_tipoUser');
    Route::get('tipoUser', 'Admin\TipoUserController@index')->name('tipoUser');
    Route::get('tipoUser/{id}', 'Admin\TipoUserController@show')->name('show_tipoUser');
    Route::post('tipoUser', 'Admin\TipoUserController@store')->name('store_tipoUser');
    Route::get('tipoUser/{id}/edit', 'Admin\TipoUserController@edit')->name('edit_tipoUser');
    Route::put('tipoUser/{id}', 'Admin\TipoUserController@update')->name('update_tipoUser');
    Route::delete('tipoUser/{id}/destroy', 'Admin\TipoUserController@destroy')->name('destroy_tipoUser');
    /* Rutas de USUARIO */
    Route::get('usuario/create', 'Admin\UsuarioController@create')->name('create_usuario');
    Route::get('usuario', 'Admin\UsuarioController@index')->name('usuario');
    Route::get('usuario/{id}', 'Admin\UsuarioController@show')->name('show_usuario');
    Route::post('usuario', 'Admin\UsuarioController@store')->name('store_usuario');
    Route::get('usuario/{id}/edit', 'Admin\UsuarioController@edit')->name('edit_usuario');
    Route::put('usuario/{id}', 'Admin\UsuarioController@update')->name('update_usuario');
    Route::delete('usuario/{id}/destroy', 'Admin\UsuarioController@destroy')->name('destroy_usuario');
});
/* Rutas de SERVICIOS */
Route::get('servicios/create', 'Admin\ServiciosController@create')->name('create_servicios');
Route::get('servicios', 'Admin\ServiciosController@index')->name('servicios');
Route::get('servicios/{id}', 'Admin\ServiciosController@show')->name('show_servicios');
Route::post('servicios', 'Admin\ServiciosController@store')->name('store_servicios');
Route::get('servicios/{id}/edit', 'Admin\ServiciosController@edit')->name('edit_servicios');
Route::put('servicios/{id}', 'Admin\ServiciosController@update')->name('update_servicios');
Route::delete('servicios/{id}/destroy', 'Admin\ServiciosController@destroy')->name('destroy_servicios');

/* Rutas de CATEGORIA */
Route::get('categoria/create', 'Admin\CategoriaController@create')->name('create_categoria');
Route::get('categoria', 'Admin\CategoriaController@index')->name('categoria');
Route::get('categoria/{id}', 'Admin\CategoriaController@show')->name('show_categoria');
Route::post('categoria', 'Admin\CategoriaController@store')->name('store_categoria');
Route::get('categoria/{id}/edit', 'Admin\CategoriaController@edit')->name('edit_categoria');
Route::put('categoria/{id}', 'Admin\CategoriaController@update')->name('update_categoria');
Route::delete('categoria/{id}/destroy', 'Admin\CategoriaController@destroy')->name('destroy_categoria');
/* Rutas de UNIDAD */
Route::get('unidad/create', 'Admin\UnidadController@create')->name('create_unidad');
Route::get('unidad', 'Admin\UnidadController@index')->name('unidad');
Route::get('unidad/{id}', 'Admin\UnidadController@show')->name('show_unidad');
Route::post('unidad', 'Admin\UnidadController@store')->name('store_unidad');
Route::get('unidad/{id}/edit', 'Admin\UnidadController@edit')->name('edit_unidad');
Route::put('unidad/{id}', 'Admin\UnidadController@update')->name('update_unidad');
Route::delete('unidad/{id}/destroy', 'Admin\UnidadController@destroy')->name('destroy_unidad');
/* Rutas de PRODUCTO */
Route::get('producto/create', 'Admin\ProductoController@create')->name('create_producto');
Route::get('producto', 'Admin\ProductoController@index')->name('producto');
Route::get('producto/{id}', 'Admin\ProductoController@show')->name('show_producto');
Route::post('producto', 'Admin\ProductoController@store')->name('store_producto');
Route::get('producto/{id}/edit', 'Admin\ProductoController@edit')->name('edit_producto');
Route::put('producto/{id}', 'Admin\ProductoController@update')->name('update_producto');
Route::delete('producto/{id}/destroy', 'Admin\ProductoController@destroy')->name('destroy_producto');


/* Rutas de TIPOHABITACION */
Route::get("tipohabitacion/create", 'Admin\TipoHabitacionController@create')->name('create_tipohabitacion');
Route::get("tipohabitacion", 'Admin\TipoHabitacionController@index')->name('tipohabitacion');
Route::get("tipohabitacion/{id}", 'Admin\TipoHabitacionController@show')->name('show_tipohabitacion');
Route::post("tipohabitacion", 'Admin\TipoHabitacionController@store')->name('store_tipohabitacion');
Route::get("tipohabitacion/{id}/edit", 'Admin\TipoHabitacionController@edit')->name('edit_tipohabitacion');
Route::put("tipohabitacion/{id}", 'Admin\TipoHabitacionController@update')->name('update_tipohabitacion');
Route::delete("tipohabitacion/{id}/destroy", 'Admin\TipoHabitacionController@destroy')->name('destroy_tipohabitacion');
/* Rutas de PISO */
Route::get('piso/create', 'Admin\PisoController@create')->name('create_piso');
Route::get('piso', 'Admin\PisoController@index')->name('piso');
Route::get('piso/{id}', 'Admin\PisoController@show')->name('show_piso');
Route::post('piso', 'Admin\PisoController@store')->name('store_piso');
Route::get('piso/{id}/edit', 'Admin\PisoController@edit')->name('edit_piso');
Route::put('piso/{id}', 'Admin\PisoController@update')->name('update_piso');
Route::delete('piso/{id}/destroy', 'Admin\PisoController@destroy')->name('destroy_piso');

/* Rutas de HBAITACION */
Route::get('habitacion/create', 'Admin\HabitacionController@create')->name('create_habitacion');
Route::get('habitacion', 'Admin\HabitacionController@index')->name('habitacion');
Route::get('habitacion/{id}', 'Admin\HabitacionController@show')->name('show_habitacion');
Route::post('habitacion', 'Admin\HabitacionController@store')->name('store_habitacion');
Route::get('habitacion/{id}/edit', 'Admin\HabitacionController@edit')->name('edit_habitacion');
Route::put('habitacion/{id}', 'Admin\HabitacionController@update')->name('update_habitacion');
Route::delete('habitacion/{id}/destroy', 'Admin\HabitacionController@destroy')->name('destroy_habitacion');

/* Rutas de CONCEPTO */
Route::get('concepto/create', 'Admin\ConceptoController@create')->name('create_concepto');
Route::get('concepto', 'Admin\ConceptoController@index')->name('concepto');
Route::get('concepto/{id}', 'Admin\ConceptoController@show')->name('show_concepto');
Route::post('concepto', 'Admin\ConceptoController@store')->name('store_concepto');
Route::get('concepto/{id}/edit', 'Admin\ConceptoController@edit')->name('edit_concepto');
Route::put('concepto/{id}', 'Admin\ConceptoController@update')->name('update_concepto');
Route::delete('concepto/{id}/destroy', 'Admin\ConceptoController@destroy')->name('destroy_concepto');
