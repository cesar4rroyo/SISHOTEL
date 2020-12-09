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

//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::get('grupomenu/create', 'GrupoMenuController@create')->name('create_grupomenu');
    Route::get('grupomenu', 'GrupoMenuController@index')->name('grupomenu');
    Route::get('grupomenu/{id}', 'GrupoMenuController@show')->name('show_grupomenu');
    Route::post('grupomenu', 'GrupoMenuController@store')->name('store_grupomenu');
    Route::get('grupomenu/{id}/edit', 'GrupoMenuController@edit')->name('edit_grupomenu');
    Route::put('grupomenu/{id}', 'GrupoMenuController@update')->name('update_grupomenu');
    Route::delete('grupomenu/{id}/destroy', 'GrupoMenuController@destroy')->name('destroy_grupomenu');
    /* Rutas de NACIONALIDAD */
    Route::get('nacionalidad/create', 'NacionalidadController@create')->name('create_nacionalidad');
    Route::get('nacionalidad', 'NacionalidadController@index')->name('nacionalidad');
    Route::get('nacionalidad/{id}', 'NacionalidadController@show')->name('show_nacionalidad');
    Route::post('nacionalidad', 'NacionalidadController@store')->name('store_nacionalidad');
    Route::get('nacionalidad/{id}/edit', 'NacionalidadController@edit')->name('edit_nacionalidad');
    Route::put('nacionalidad/{id}', 'NacionalidadController@update')->name('update_nacionalidad');
    Route::delete('nacionalidad/{id}/destroy', 'NacionalidadController@destroy')->name('destroy_nacionalidad');
    /* Rutas de OPCIONMENU */
    Route::get('opcionmenu/create', 'OpcionMenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'OpcionMenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/{id}', 'OpcionMenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'OpcionMenuController@store')->name('store_opcionmenu');
    Route::get('opcionmenu/{id}/edit', 'OpcionMenuController@edit')->name('edit_opcionmenu');
    Route::put('opcionmenu/{id}', 'OpcionMenuController@update')->name('update_opcionmenu');
    Route::delete('opcionmenu/{id}/destroy', 'OpcionMenuController@destroy')->name('destroy_opcionmenu');
    /* Rutas de PERSONA */
    Route::get('persona/create', 'PersonaController@create')->name('create_persona');
    Route::get('persona', 'PersonaController@index')->name('persona');
    Route::get('persona/{id}', 'PersonaController@show')->name('show_persona');
    Route::post('persona', 'PersonaController@store')->name('store_persona');
    Route::get('persona/{id}/edit', 'PersonaController@edit')->name('edit_persona');
    Route::put('persona/{id}', 'PersonaController@update')->name('update_persona');
    Route::delete('persona/{id}/destroy', 'PersonaController@destroy')->name('destroy_persona');
    /* Rutas de ROL */
    Route::get('rol/create', 'RolController@create')->name('create_rol');
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/{id}', 'RolController@show')->name('show_rol');
    Route::post('rol', 'RolController@store')->name('store_rol');
    Route::get('rol/{id}/edit', 'RolController@edit')->name('edit_rol');
    Route::put('rol/{id}', 'RolController@update')->name('update_rol');
    Route::delete('rol/{id}/destroy', 'RolController@destroy')->name('destroy_rol');
    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonaController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonaController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::get('tipousuario/create', 'TipoUserController@create')->name('create_tipousuario');
    Route::get('tipousuario', 'TipoUserController@index')->name('tipousuario');
    Route::get('tipousuario/{id}', 'TipoUserController@show')->name('show_tipousuario');
    Route::post('tipousuario', 'TipoUserController@store')->name('store_tipousuario');
    Route::get('tipousuario/{id}/edit', 'TipoUserController@edit')->name('edit_tipousuario');
    Route::put('tipousuario/{id}', 'TipoUserController@update')->name('update_tipousuario');
    Route::delete('tipousuario/{id}/destroy', 'TipoUserController@destroy')->name('destroy_tipousuario');
    /* Rutas de USUARIO */
    Route::get('usuario/create', 'UsuarioController@create')->name('create_usuario');
    Route::get('usuario', 'UsuarioController@index')->name('usuario');
    Route::get('usuario/{id}', 'UsuarioController@show')->name('show_usuario');
    Route::post('usuario', 'UsuarioController@store')->name('store_usuario');
    Route::get('usuario/{id}/edit', 'UsuarioController@edit')->name('edit_usuario');
    Route::put('usuario/{id}', 'UsuarioController@update')->name('update_usuario');
    Route::delete('usuario/{id}/destroy', 'UsuarioController@destroy')->name('destroy_usuario');
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
