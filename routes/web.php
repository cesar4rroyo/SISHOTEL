<?php


use Illuminate\Support\Facades\Route;


Route::get('/', 'InicioController@index');




//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'root']], function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/', 'AdminController@index')->name('admin');
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::post('grupomenu/buscar', 'GrupoMenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupoMenuController@eliminar')->name('grupomenu.eliminar');
    Route::resource('grupomenu', 'GrupoMenuController', array('except' => array('show')));
    /* Rutas de OPCIONMENU */
    Route::post('opcionmenu/buscar', 'OpcionMenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionMenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionMenuController', array('except' => array('show')));
    /* Rutas de ROL */
    Route::post('rol/buscar', 'RolController@buscar')->name('rol.buscar');
    Route::get('rol/eliminar/{id}/{listarluego}', 'RolController@eliminar')->name('rol.eliminar');
    Route::resource('rol', 'RolController', array('except' => array('show')));
    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonaController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonaController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::post('tipousuario/buscar', 'TipoUserController@buscar')->name('tipousuario.buscar');
    Route::get('tipousuario/eliminar/{id}/{listarluego}', 'TipoUserController@eliminar')->name('tipousuario.eliminar');
    Route::resource('tipousuario', 'TipoUserController', array('except' => array('show')));
    /* Rutas de USUARIO */
    Route::post('usuario/buscar', 'UsuarioController@buscar')->name('usuario.buscar');
    Route::get('usuario/eliminar/{id}/{listarluego}', 'UsuarioController@eliminar')->name('usuario.eliminar');
    Route::resource('usuario', 'UsuarioController', array('except' => array('show')));

});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'acceso']], function () {
    // /* Rutas de PERSONA */
    Route::post('persona/buscar', 'PersonaController@buscar')->name('persona.buscar');
    Route::get('persona/eliminar/{id}/{listarluego}', 'PersonaController@eliminar')->name('persona.eliminar');
    Route::resource('persona', 'PersonaController', array('except' => array('show')));
    // Route::get('persona/create', 'PersonaController@create')->name('create_persona');
    // Route::get('persona', 'PersonaController@index')->name('persona');
    // Route::get('persona/{id}', 'PersonaController@show')->name('show_persona');
    // Route::post('persona', 'PersonaController@store')->name('store_persona');
    // Route::post('persona/checkin', 'PersonaController@store_checkin')->name('store_persona_checkin');
    // Route::post('persona/checkin/reserva/{id}', 'PersonaController@store_checkin_reserva')->name('store_persona_checkin_reserva');
    // Route::get('persona/{id}/edit', 'PersonaController@edit')->name('edit_persona');
    // Route::put('persona/{id}', 'PersonaController@update')->name('update_persona');
    // Route::delete('persona/{id}/destroy', 'PersonaController@destroy')->name('destroy_persona');
    // Route::post('persona/pasajero/destroy', 'PersonaController@pasajeroDestroy')->name('destroy_pasajero');

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
    Route::post('nacionalidad/buscar', 'NacionalidadController@buscar')->name('nacionalidad.buscar');
    Route::get('nacionalidad/eliminar/{id}/{listarluego}', 'NacionalidadController@eliminar')->name('nacionalidad.eliminar');
    Route::resource('nacionalidad', 'NacionalidadController', array('except' => array('show')));

});

Route::group(['prefix' => 'admin', 'namespace' => 'Habitacion', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de TIPOHABITACION */
    Route::post('tipohabitacion/buscar', 'TipoHabitacionController@buscar')->name('tipohabitacion.buscar');
    Route::get('tipohabitacion/eliminar/{id}/{listarluego}', 'TipoHabitacionController@eliminar')->name('tipohabitacion.eliminar');
    Route::resource('tipohabitacion', 'TipoHabitacionController', array('except' => array('show')));
    /* Rutas de PISO */
    Route::post('piso/buscar', 'PisoController@buscar')->name('piso.buscar');
    Route::get('piso/eliminar/{id}/{listarluego}', 'PisoController@eliminar')->name('piso.eliminar');
    Route::resource('piso', 'PisoController', array('except' => array('show')));
    /* Rutas de HABITACION */
    Route::post('habitacion/buscar', 'HabitacionController@buscar')->name('habitacion.buscar');
    Route::get('habitacion/eliminar/{id}/{listarluego}', 'HabitacionController@eliminar')->name('habitacion.eliminar');
    Route::resource('habitacion', 'HabitacionController', array('except' => array('show')));
});
Route::group(['prefix' => 'admin', 'namespace' => 'Producto', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de UNIDAD */
    Route::post('unidad/buscar', 'UnidadController@buscar')->name('unidad.buscar');
    Route::get('unidad/eliminar/{id}/{listarluego}', 'UnidadController@eliminar')->name('unidad.eliminar');
    Route::resource('unidad', 'UnidadController', array('except' => array('show')));
    /* Rutas de PRODUCTO */
    Route::post('producto/buscar', 'ProductoController@buscar')->name('producto.buscar');
    Route::get('producto/eliminar/{id}/{listarluego}', 'ProductoController@eliminar')->name('producto.eliminar');
    Route::resource('producto', 'ProductoController', array('except' => array('show')));
    /* Rutas de CATEGORIA */
    Route::post('categoria/buscar', 'CategoriaController@buscar')->name('categoria.buscar');
    Route::get('categoria/eliminar/{id}/{listarluego}', 'CategoriaController@eliminar')->name('categoria.eliminar');
    Route::resource('categoria', 'CategoriaController', array('except' => array('show')));
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'acceso']], function () {
    /* Rutas de CONCEPTO */
    Route::post('concepto/buscar', 'ConceptoController@buscar')->name('concepto.buscar');
    Route::get('concepto/eliminar/{id}/{listarluego}', 'ConceptoController@eliminar')->name('concepto.eliminar');
    Route::resource('concepto', 'ConceptoController', array('except' => array('show')));
    /* Rutas de SERVICIOS */
    Route::post('servicios/buscar', 'ServiciosController@buscar')->name('servicios.buscar');
    Route::get('servicios/eliminar/{id}/{listarluego}', 'ServiciosController@eliminar')->name('servicios.eliminar');
    Route::resource('servicios', 'ServiciosController', array('except' => array('show')));
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
Route::group(['prefix' => 'admin', 'namespace' => 'Control', 'middleware' => ['auth']], function () {
    /* Rutas de COMPROBANTE */
    Route::get('comprobantes', 'ComprobanteController@index')->name('comprobantes');
    Route::get('comprobantes/pdf/{id}', 'ComprobanteController@exportPDF')->name('comprobante_pdf');
    Route::get('comprobantes/{id}', 'ComprobanteController@show')->name('show_comprobante');

    /* Rutas de HABITACIONES */
    Route::post('habitaciones/buscar', 'PrincipalController@buscar')->name('habitaciones.buscar');
    Route::get('habitaciones/eliminar/{id}/{listarluego}', 'PrincipalController@eliminar')->name('habitaciones.eliminar');
    Route::resource('habitaciones', 'PrincipalController', array('except' => array('show')));
    // Route::get('habitaciones/create', 'HabitacionesController@create')->name('create_habitaciones');
    // Route::get('habitaciones', 'HabitacionesController@index')->name('habitaciones');
    // Route::get('habitaciones/{id}', 'HabitacionesController@show')->name('show_habitaciones');
    // Route::post('habitaciones', 'HabitacionesController@store')->name('store_habitaciones');
    // Route::get('habitaciones/{id}/edit', 'HabitacionesController@edit')->name('edit_habitaciones');
    // Route::put('habitaciones/{id}', 'HabitacionesController@update')->name('update_habitaciones');
    // Route::delete('habitaciones/{id}/destroy', 'HabitacionesController@destroy')->name('destroy_habitaciones');

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
    //TERMINAR HABITACION
    Route::get('movimiento/finish/{id}/edit/{id_reserva?}', 'MovimientoController@terminar')->name('terminar_movimiento');
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
    Route::get('movimiento/pdf/nota/{id}', 'MovimientoController@exportNota')->name('nota_pdf');
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
    /* Rutas de CAJA */
    Route::post('caja/buscar', 'CajaController@buscar')->name('caja.buscar');
    Route::get('caja/eliminar/{id}/{listarluego}', 'CajaController@eliminar')->name('caja.eliminar');
    Route::get('caja/print', 'CajaController@print')->name('caja.print');
    Route::get('caja/printA4', 'CajaController@printA4')->name('caja.printA4');
    Route::resource('caja', 'CajaController', array('except' => array('show')));


    // Route::get('caja/create/apertura', 'CajaController@create_apertura')->name('apertura_caja');
    // Route::get('caja/create', 'CajaController@create')->name('create_caja');
    // Route::get('caja/create/cierre', 'CajaController@create_cierre')->name('cierre_caja');
    // Route::get('caja', 'CajaController@index')->name('caja');
    // Route::get('caja/pdf', 'CajaController@exportPdf')->name('caja_pdf');
    // Route::get('caja/lista', 'CajaController@indexLista')->name('caja_lista');
    // Route::get('caja/{id}', 'CajaController@show')->name('show_caja');
    // Route::post('caja', 'CajaController@store')->name('store_caja');
    // Route::get('caja/{id}/edit', 'CajaController@edit')->name('edit_caja');
    // Route::put('caja/{id}', 'CajaController@update')->name('update_caja');
    // Route::delete('caja/{id}/destroy', 'CajaController@destroy')->name('destroy_caja');
    // //caja desde movimientos detalle
    // Route::post('caja/{id}/addDetalle/producto', 'CajaController@addFromDetallePdto')->name('add_detail_producto');
    // Route::post('caja/{id}/addDetalle/servicio', 'CajaController@addFromDetalleService')->name('add_detail_servicio');
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
    Route::post('reportes/documentosventas/pdf', 'ReportesController@documentosventas')->name('reportes_documentosventas');
    Route::get('reportes/documentosventas', 'ReportesController@indexDocVentas')->name('index_documentosventas');
    Route::post('reportes/caja/pdf/{formato?}', 'ReportesController@pdfCaja')->name('reportes_caja_pdf');
    Route::get('data/movimientos', 'ReportesController@movimientos')->name('data_movimientos');
    Route::get('data/reservas', 'ReportesController@reservas')->name('data_reservas');
    Route::get('data/caja', 'ReportesController@caja')->name('data_caja');
    Route::get('data/productos', 'ReportesController@productos')->name('data_productos');
    Route::get('data/servicios', 'ReportesController@servicios')->name('data_servicios');
    Route::get('data/detallecaja', 'ReportesController@detallecaja')->name('data_detallecaja');
    Route::get('data/detallemovimiento', 'ReportesController@detallemovimiento')->name('data_detallemovimiento');
});
