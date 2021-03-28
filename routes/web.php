<?php


use Illuminate\Support\Facades\Route;


Route::get('/', 'InicioController@index');




//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'root']], function () {
    Route::get('/', 'AdminController@index')->name('admin');
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

    /* Rutas de OPCIONMENU */
    Route::get('opcionmenu/create', 'OpcionMenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'OpcionMenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/{id}', 'OpcionMenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'OpcionMenuController@store')->name('store_opcionmenu');
    Route::get('opcionmenu/{id}/edit', 'OpcionMenuController@edit')->name('edit_opcionmenu');
    Route::put('opcionmenu/{id}', 'OpcionMenuController@update')->name('update_opcionmenu');
    Route::delete('opcionmenu/{id}/destroy', 'OpcionMenuController@destroy')->name('destroy_opcionmenu');
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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de PERSONA */
    Route::get('persona/create', 'PersonaController@create')->name('create_persona');
    Route::get('persona', 'PersonaController@index')->name('persona');
    Route::get('persona/{id}', 'PersonaController@show')->name('show_persona');
    Route::post('persona', 'PersonaController@store')->name('store_persona');
    Route::post('persona/checkin', 'PersonaController@store_checkin')->name('store_persona_checkin');
    Route::post('persona/checkin/reserva/{id}', 'PersonaController@store_checkin_reserva')->name('store_persona_checkin_reserva');
    Route::get('persona/{id}/edit', 'PersonaController@edit')->name('edit_persona');
    Route::put('persona/{id}', 'PersonaController@update')->name('update_persona');
    Route::delete('persona/{id}/destroy', 'PersonaController@destroy')->name('destroy_persona');
    Route::post('persona/pasajero/destroy', 'PersonaController@pasajeroDestroy')->name('destroy_pasajero');

    //store in checkout
    Route::post('persona/checkout/store', 'PersonaController@store_checkout')->name('store_persona_checkout');
    //obetener solo los clientes con RUC para combobox
    Route::get('persona/clientes/ruc', 'PersonaController@getClientesRuc')->name('getClientesRuc');
    //obetner todos los clientes
    Route::get('persona/clientes/generales', 'PersonaController@getClientesSinRuc')->name('getTodosClientes');
    //agregar persona RUC desde el checkout
    Route::post('persona/store/checkout', 'PersonaController@storeClienteRuc')->name('storeClienteRuc');
    //buscar persona por DNI en BD
    Route::get('persona/dni/buscar', 'PersonaController@getPersonaDNI')->name('getPersonaDni');
    //agregar nuevo pasajero a la habitación
    Route::post('persona/huesped/habitacion', 'PersonaController@addHuespedHabitacion')->name('add_huesped_habitacion');
    /* Rutas de NACIONALIDAD */
    Route::get('nacionalidad/create', 'NacionalidadController@create')->name('create_nacionalidad');
    Route::get('nacionalidad', 'NacionalidadController@index')->name('nacionalidad');
    Route::get('nacionalidad/{id}', 'NacionalidadController@show')->name('show_nacionalidad');
    Route::post('nacionalidad', 'NacionalidadController@store')->name('store_nacionalidad');
    Route::get('nacionalidad/{id}/edit', 'NacionalidadController@edit')->name('edit_nacionalidad');
    Route::put('nacionalidad/{id}', 'NacionalidadController@update')->name('update_nacionalidad');
    Route::delete('nacionalidad/{id}/destroy', 'NacionalidadController@destroy')->name('destroy_nacionalidad');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Habitacion', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de TIPOHABITACION */
    Route::get("tipohabitacion/create", 'TipoHabitacionController@create')->name('create_tipohabitacion');
    Route::get("tipohabitacion", 'TipoHabitacionController@index')->name('tipohabitacion');
    Route::get("tipohabitacion/{id}", 'TipoHabitacionController@show')->name('show_tipohabitacion');
    Route::post("tipohabitacion", 'TipoHabitacionController@store')->name('store_tipohabitacion');
    Route::get("tipohabitacion/{id}/edit", 'TipoHabitacionController@edit')->name('edit_tipohabitacion');
    Route::put("tipohabitacion/{id}", 'TipoHabitacionController@update')->name('update_tipohabitacion');
    Route::delete("tipohabitacion/{id}/destroy", 'TipoHabitacionController@destroy')->name('destroy_tipohabitacion');
    /* Rutas de PISO */
    Route::get('piso/create', 'PisoController@create')->name('create_piso');
    Route::get('piso', 'PisoController@index')->name('piso');
    Route::get('piso/{id}', 'PisoController@show')->name('show_piso');
    Route::post('piso', 'PisoController@store')->name('store_piso');
    Route::get('piso/{id}/edit', 'PisoController@edit')->name('edit_piso');
    Route::put('piso/{id}', 'PisoController@update')->name('update_piso');
    Route::delete('piso/{id}/destroy', 'PisoController@destroy')->name('destroy_piso');
    /* Rutas de HABITACION */
    Route::get('habitacion/create', 'HabitacionController@create')->name('create_habitacion');
    Route::get('habitacion', 'HabitacionController@index')->name('habitacion');
    Route::get('habitacion/{id}', 'HabitacionController@show')->name('show_habitacion');
    Route::post('habitacion', 'HabitacionController@store')->name('store_habitacion');
    Route::get('habitacion/{id}/edit', 'HabitacionController@edit')->name('edit_habitacion');
    Route::put('habitacion/{id}', 'HabitacionController@update')->name('update_habitacion');
    Route::delete('habitacion/{id}/destroy', 'HabitacionController@destroy')->name('destroy_habitacion');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Producto', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de CATEGORIA */
    Route::get('categoria/create', 'CategoriaController@create')->name('create_categoria');
    Route::get('categoria', 'CategoriaController@index')->name('categoria');
    Route::get('categoria/{id}', 'CategoriaController@show')->name('show_categoria');
    Route::post('categoria', 'CategoriaController@store')->name('store_categoria');
    Route::get('categoria/{id}/edit', 'CategoriaController@edit')->name('edit_categoria');
    Route::put('categoria/{id}', 'CategoriaController@update')->name('update_categoria');
    Route::delete('categoria/{id}/destroy', 'CategoriaController@destroy')->name('destroy_categoria');
    /* Rutas de UNIDAD */
    Route::get('unidad/create', 'UnidadController@create')->name('create_unidad');
    Route::get('unidad', 'UnidadController@index')->name('unidad');
    Route::get('unidad/{id}', 'UnidadController@show')->name('show_unidad');
    Route::post('unidad', 'UnidadController@store')->name('store_unidad');
    Route::get('unidad/{id}/edit', 'UnidadController@edit')->name('edit_unidad');
    Route::put('unidad/{id}', 'UnidadController@update')->name('update_unidad');
    Route::delete('unidad/{id}/destroy', 'UnidadController@destroy')->name('destroy_unidad');
    /* Rutas de PRODUCTO */
    Route::get('producto/create', 'ProductoController@create')->name('create_producto');
    Route::get('producto', 'ProductoController@index')->name('producto');
    Route::get('producto/{id}', 'ProductoController@show')->name('show_producto');
    Route::post('producto', 'ProductoController@store')->name('store_producto');
    Route::get('producto/{id}/edit', 'ProductoController@edit')->name('edit_producto');
    Route::put('producto/{id}', 'ProductoController@update')->name('update_producto');
    Route::delete('producto/{id}/destroy', 'ProductoController@destroy')->name('destroy_producto');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de CONCEPTO */
    Route::get('concepto/create', 'ConceptoController@create')->name('create_concepto');
    Route::get('concepto', 'ConceptoController@index')->name('concepto');
    Route::get('concepto/{id}', 'ConceptoController@show')->name('show_concepto');
    Route::post('concepto', 'ConceptoController@store')->name('store_concepto');
    Route::get('concepto/{id}/edit', 'ConceptoController@edit')->name('edit_concepto');
    Route::put('concepto/{id}', 'ConceptoController@update')->name('update_concepto');
    Route::delete('concepto/{id}/destroy', 'ConceptoController@destroy')->name('destroy_concepto');
    /* Rutas de SERVICIOS */
    Route::get('servicios/create', 'ServiciosController@create')->name('create_servicios');
    Route::get('servicios', 'ServiciosController@index')->name('servicios');
    Route::get('servicios/{id}', 'ServiciosController@show')->name('show_servicios');
    Route::post('servicios', 'ServiciosController@store')->name('store_servicios');
    Route::get('servicios/{id}/edit', 'ServiciosController@edit')->name('edit_servicios');
    Route::put('servicios/{id}', 'ServiciosController@update')->name('update_servicios');
    Route::delete('servicios/{id}/destroy', 'ServiciosController@destroy')->name('destroy_servicios');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Reservas', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de RESERVAS */
    Route::get('reserva/create', 'ReservaController@create')->name('create_reserva');
    Route::get('reserva', 'ReservaController@index')->name('reserva');
    Route::get('reserva/todas/list', 'ReservaController@listarReservas')->name('reserva_lista_todas');
    // Route::get('reserva/{id}', 'ReservaController@show')->name('show_reserva');
    Route::get('reserva/show', 'ReservaController@show')->name('show_reserva');
    Route::post('reserva', 'ReservaController@store')->name('store_reserva');
    Route::get('reserva/{id}/edit', 'ReservaController@edit')->name('edit_reserva');
    Route::put('reserva/{id}', 'ReservaController@update')->name('update_reserva');
    Route::delete('reserva/{id}/destroy', 'ReservaController@destroy')->name('destroy_reserva');
    /* //reserva buscador
    Route::get('nombres/buscador', 'PersonaController@buscador'); */
});
Route::group(['prefix' => 'admin', 'namespace' => 'Control', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de COMPROBANTE */
    Route::get('comprobantes', 'ComprobanteController@index')->name('comprobantes');
    Route::get('comprobantes/pdf/{id}', 'ComprobanteController@exportPDF')->name('comprobante_pdf');
    Route::get('comprobantes/{id}', 'ComprobanteController@show')->name('show_comprobante');

    /* Rutas de HABITACIONES */
    Route::get('habitaciones/create', 'HabitacionesController@create')->name('create_habitaciones');
    Route::get('habitaciones', 'HabitacionesController@index')->name('habitaciones');
    Route::get('habitaciones/{id}', 'HabitacionesController@show')->name('show_habitaciones');
    Route::post('habitaciones', 'HabitacionesController@store')->name('store_habitaciones');
    Route::get('habitaciones/{id}/edit', 'HabitacionesController@edit')->name('edit_habitaciones');
    Route::put('habitaciones/{id}', 'HabitacionesController@update')->name('update_habitaciones');
    Route::delete('habitaciones/{id}/destroy', 'HabitacionesController@destroy')->name('destroy_habitaciones');

     /* NotaCredito  */
     Route::post('notacredito/buscar', 'NotacreditoController@buscar')->name('notacredito.buscar');
     Route::get('notacredito/eliminar/{id}/{listarluego}', 'NotacreditoController@eliminar')->name('notacredito.eliminar');
     Route::resource('notacredito', 'NotacreditoController', array('except' => array('show')));
     Route::get('notacredito/documentoautocompletar', 'NotacreditoController@documentoautocompletar')->name('notacredito.documentoautocompletar');
     Route::get('notacredito/obtenerCliente', 'NotacreditoController@obtenerCliente')->name('notacredito.obtenerCliente');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Control', 'middleware' => ['auth']], function () {
    /* Rutas de Movimientos */
    Route::get('movimiento/create', 'MovimientoController@create')->name('create_movimiento');
    Route::get('movimiento', 'MovimientoController@index')->name('movimiento');
    Route::get('movimiento/show', 'MovimientoController@show')->name('show_movimiento');
    Route::post('movimiento/{id_reserva?}', 'MovimientoController@store')->name('store_movimiento');
    Route::get('movimiento/{id}/edit/{id_reserva?}', 'MovimientoController@edit')->name('edit_movimiento');
    //con reserva
    Route::get('movimiento/reserva/{id_habitacion}/{id_reserva}', 'MovimientoController@editConReserva')->name('edit_movimiento_reserva');
    Route::put('movimiento/{id}', 'MovimientoController@update')->name('update_movimiento');
    Route::delete('movimiento/{id}/destroy', 'MovimientoController@destroy')->name('destroy_movimiento');

    //carrito productos
    Route::get('addToCart/{id}', 'CartController@addToCart')->name('addToCart');
    Route::patch('updateCart', 'CartController@update')->name('updateCart');
    Route::delete('removeFromCart', 'CartController@remove')->name('removeFromCart');
    //carrito servicios
    Route::get('addServicioCart/{id}', 'CartController@addServiceToCart')->name('addServicioToCart');
    Route::patch('updateServicioCart', 'CartController@updateServicioCart')->name('updateServicioCart');
    Route::delete('removeServicioCart', 'CartController@removeServicoCart')->name('removeServicioFromCart');
    /* Rutas de DetalleMovimientos */
    Route::get('consultarServicio/{id?}', 'DetalleMovimientoController@servicios')->name('consultarServicio');
    Route::get('consultarProducto/{id?}', 'DetalleMovimientoController@productos')->name('consultarProducto');
    Route::get('detallemovimiento/create', 'DetalleMovimientoController@create')->name('create_detallemovimiento');
    Route::get('detallemovimiento/{id}/{movimiento?}', 'DetalleMovimientoController@movimiento')->name('add_movimieto');
    Route::get('detallemovimiento', 'DetalleMovimientoController@index')->name('detallemovimiento');
    Route::get('detallemovimiento/{id}', 'DetalleMovimientoController@show')->name('show_detallemovimiento');
    Route::post('detallemovimiento', 'DetalleMovimientoController@store')->name('store_detallemovimiento');
    Route::post('detallemovimientoServicio', 'DetalleMovimientoController@storeServicio')->name('store_detallemovimientoServicio');
    Route::get('detallemovimiento/{id}/edit', 'DetalleMovimientoController@edit')->name('edit_detallemovimiento');
    Route::put('detallemovimiento/{id}', 'DetalleMovimientoController@update')->name('update_detallemovimiento');
    Route::delete('detallemovimiento/{id}/destroy', 'DetalleMovimientoController@destroy')->name('destroy_detallemovimiento');

    //cheak-out
    Route::post('movimiento/checkout/{id}', 'CajaController@checkout')->name('checkout');
    Route::post('movimiento/{id}/checkout', 'CajaController@createCheckout')->name('add_checkout');
    Route::post('movimiento/{id}/cobrar', 'CajaController@cobrarMovimiento')->name('cobrar_movimiento');
    Route::get('movimiento/checkouts/lista', 'MovimientoController@listarCheckOuts')->name('checkouts_lista');
    Route::get('movimiento/pdf/out/{id}', 'MovimientoController@exportPdf')->name('check_out_pdf');
    Route::get('movimiento/pdf/in/{id}', 'MovimientoController@exportPdfCheckIn')->name('check_in_pdf');

    Route::delete('movimiento/{id}/eliminar', 'MovimientoController@eliminar_checkout')->name('eliminar_checkout_lista');


    Route::post('detallemovimiento/elimar/habitacion', 'DetalleMovimientoController@eliminarMovimiento')->name('eliminar_producto_from_habitacion');

    //actualizar habitacion
    Route::get('caja/habitacion/actualizar/{id}', 'CajaController@updateHabitacion')->name('actualizarHabitacion');
    //ventas de Productos
    Route::get('ventas/productos', 'VentasController@indexProductos')->name('ventas_productos');
    Route::get('ventas/servicios', 'VentasController@indexServicios')->name('ventas_servicios');
    //carrito productos
    Route::get('ventas/productos/addToCart/{id}', 'VentasController@addToCart')->name('ventas_addToCart');
    Route::patch('ventas/productos/updateCart', 'VentasController@update')->name('ventas_updateCart');
    Route::delete('ventas/productos/removeFromCart', 'VentasController@remove')->name('ventas_removeFromCart');
    //carrito servicios
    Route::get('ventas/servicios/addServicioCart/{id}', 'VentasController@addServiceToCart')->name('ventas_addServicioToCart');
    Route::patch('ventas/servicios/updateServicioCart', 'VentasController@updateServicioCart')->name('ventas_updateServicioCart');
    Route::delete('ventas/servicios/removeServicioCart', 'VentasController@removeServicoCart')->name('ventas_removeServicioFromCart');
    Route::post('ventas/caja/addDetalle/producto', 'VentasController@addFromDetallePdto')->name('add_detail_producto_ventas');
    Route::post('ventas/addDetalle/producto', 'VentasController@storeProducto')->name('store_caja_producto_ventas');
    Route::post('ventas/addServicio/servicio', 'VentasController@storeServicio')->name('store_caja_servicio_ventas');
    Route::post('ventas/caja/addDetalle/servicio', 'VentasController@addFromDetalleService')->name('add_detail_servicio_ventas');

    //caja desde movimientos detalle
    Route::post('addDetalle/producto', 'CajaController@storeProducto')->name('store_caja_producto');
    Route::post('addServicio/servicio', 'CajaController@storeServicio')->name('store_caja_servicio');

    Route::get('ventas/{id}', 'VentasController@getComprobanteNumero')->name('getComprobanteNumero');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Control', 'middleware' => ['auth', 'acceso']], function () {
    //Routas caja
    Route::get('caja/create/apertura', 'CajaController@create_apertura')->name('apertura_caja');
    Route::get('caja/create', 'CajaController@create')->name('create_caja');
    Route::get('caja/create/cierre', 'CajaController@create_cierre')->name('cierre_caja');
    Route::get('caja', 'CajaController@index')->name('caja');
    Route::get('caja/pdf', 'CajaController@exportPdf')->name('caja_pdf');
    Route::get('caja/lista', 'CajaController@indexLista')->name('caja_lista');
    Route::get('caja/{id}', 'CajaController@show')->name('show_caja');
    Route::post('caja', 'CajaController@store')->name('store_caja');
    Route::get('caja/{id}/edit', 'CajaController@edit')->name('edit_caja');
    Route::put('caja/{id}', 'CajaController@update')->name('update_caja');
    Route::delete('caja/{id}/destroy', 'CajaController@destroy')->name('destroy_caja');
    //caja desde movimientos detalle
    Route::post('caja/{id}/addDetalle/producto', 'CajaController@addFromDetallePdto')->name('add_detail_producto');
    Route::post('caja/{id}/addDetalle/servicio', 'CajaController@addFromDetalleService')->name('add_detail_servicio');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Control', 'middleware' => ['auth']], function () {
    Route::get('reportes/huespedes', 'ReportesController@indexHuespedes')->name('reportes_huespedes');
    Route::post('reportes/huespedes/pdf/{formato?}', 'ReportesController@pdfHuespedes')->name('reportes_huespedes_pdf');
    Route::get('reportes/checkout', 'ReportesController@indexCheckout')->name('reportes_checkout');
    Route::post('reportes/checkout/pdf/{formato?}', 'ReportesController@pdfCheckout')->name('reportes_checkout_pdf');
    Route::get('reportes/checkin', 'ReportesController@indexCheckin')->name('reportes_checkin');
    Route::post('reportes/checkin/pdf/{formato?}', 'ReportesController@pdfCheckin')->name('reportes_checkin_pdf');
    Route::get('reportes/reservas', 'ReportesController@indexReservas')->name('reportes_reservas');
    Route::post('reportes/reservas/pdf/{formato?}', 'ReportesController@pdfReservas')->name('reportes_reservas_pdf');
    Route::get('reportes/productos', 'ReportesController@indexProductos')->name('reportes_productos');
    Route::get('reportes/servicios', 'ReportesController@indexServicios')->name('reportes_servicios');
    Route::post('reportes/productos/pdf/{formato?}', 'ReportesController@pdfProductos')->name('reportes_productos_pdf');
    Route::get('reportes/ventas', 'ReportesController@indexVentas')->name('reportes_ventas');
    Route::get('reportes/ventas/habitacion', 'ReportesController@indexVentasHabitacion')->name('reportes_ventas_habitacion');
    Route::post('reportes/ventas/pdf/{formato?}', 'ReportesController@pdfVentas')->name('reportes_ventas_pdf');
    Route::get('reportes/caja', 'ReportesController@indexCaja')->name('reportes_caja');
    Route::post('reportes/caja/pdf/{formato?}', 'ReportesController@pdfCaja')->name('reportes_caja_pdf');
    Route::get('data/movimientos', 'ReportesController@movimientos')->name('data_movimientos');
    Route::get('data/reservas', 'ReportesController@reservas')->name('data_reservas');
    Route::get('data/caja', 'ReportesController@caja')->name('data_caja');
    Route::get('data/productos', 'ReportesController@productos')->name('data_productos');
    Route::get('data/servicios', 'ReportesController@servicios')->name('data_servicios');
    Route::get('data/detallecaja', 'ReportesController@detallecaja')->name('data_detallecaja');
    Route::get('data/detallemovimiento', 'ReportesController@detallemovimiento')->name('data_detallemovimiento');
});
