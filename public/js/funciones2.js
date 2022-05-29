/**
* Funciones generales que serán usadas por la mayoria de las operaciones
*/

var IDFORMBUSQUEDA      = "#formBusqueda";
var IDFORMMANTENIMIENTO = "#formMantenimiento";
var MSJCBOBUSQUEDA      = "TODOS";
var MSJCBOMANTENIMIENTO = "SELECCIONE";
var modales             = new Array();
var IMAGENLOADING       = "";
var contadorModal       = 0;

/**
* Permite hacer un submit a un formulario y retorna la respuesta del envio, o el error que se produzca
* @param  {string} idformulario
* @return {string} respuesta
*/
function submitForm (idformulario) {
	var parametros = $(idformulario).serialize();
	var accion     = $(idformulario).attr('action');
	var metodo     = $(idformulario).attr('method');
	var respuesta  = $.ajax({
		url : accion,
		type: metodo,
		data: parametros
	});
	return respuesta;
}

/**
* Funcion para cargar la respuesta de la funcion 'submitForm', e incrustar en contenedor
* @param  {string} idformulario
* @param  {string} idContenedor
* @return {html}
*/
function cargarSubmitForm (idformulario, idContenedor) {
    var contenedor = '#' + idContenedor;
    $(contenedor).html(imgCargando());
    var respuesta;
    var data = submitForm(idformulario);
    data.done(function(msg) {
        respuesta = msg;
    }).fail(function(xhr, textStatus, errorThrown) {
        respuesta = 'ERROR';
    }).always(function() {
        if(respuesta === 'ERROR'){
            $(contenedor).html('<button type="button" onclick="cerrarModal('+(contadorModal-1)+');" class="btn btn-warning btn-sm"><i class="fa fa-exclamation fa-lg"></i> Cancelar</button>');
        }else{
            $(contenedor).html(respuesta);    
        }
    });
}

/**
* Enviar un direccion
* @param  {string} ruta
* @return {response}
*/
function sendRuta(ruta){
	var respuesta = $.ajax({
		url : ruta,
		type: 'GET'
	});
	return respuesta;
}

/**
* Incrustar respuesta de una ruta en un contenedor
* @param  {string} ruta
* @param  {string} idContenedor
* @return {html}
*/
function cargarRuta(ruta, idContenedor) {
    var contenedor = '#' + idContenedor;
    $(contenedor).html(imgCargando());
    var respuesta = '';
    var data = sendRuta(ruta);
    data.done(function(msg) {
        respuesta = msg;
    }).fail(function(xhr, textStatus, errorThrown) {
        respuesta = 'ERROR';
    }).always(function() {
        if(respuesta === 'ERROR'){
            $(contenedor).html('<button type="button" onclick="cerrarModal('+(contadorModal-1)+');" class="btn btn-warning btn-sm"><i class="fa fa-exclamation fa-lg"></i> Cancelar</button>');
        }else{
            $(contenedor).html(respuesta);    
        }
    }); 
}

/**
* Dar estilo a un error
* @param  {string} error
* @return {html}
*/
function estiloError (error) {
	return '<div class="bs-docs-section"><div class="row"><div class="page-header"><h2 id="forms">' + error + '</h2></div></div></div>';
}

/**
* Función para realizar busqueda e inscrustar el RESPONSE en un div, los parametros se envian por medio de 
* $.POST de jquery a una URL
* @param  {string} entidad     Nombre de la entidad donde se va a inscrustar. Ejm: 'Usuario', 'Area', ect.
* @return {html}               Se incrusta el codigo HTML en el DIV
*/
function buscar(entidad) {
	var formulario  = IDFORMBUSQUEDA + entidad;
	var contenedor  = 'listado' + entidad;
	$(formulario + ' :input[id = "page"]').val(1);
	cargarSubmitForm(formulario, contenedor);
}

/**
* Función para cargar imagen LOADING.GIF de espera al cargar contenido
* @return {html} Codigo HTML de imagen de carga
*/
function imgCargando () {
	var texto = "<br>&nbsp;&nbsp;&nbsp;&nbsp;<font style='color: #505053;'>Cargando, por favor espere...</font><br><br>&nbsp;&nbsp;&nbsp;&nbsp;<img src='"+IMAGENLOADING+"'>";
	return texto;
}

/**
* Función para realizar busqueda con paginación e inscrustar el RESPONSE en un div, 
* los parametros se envian por medio de $.POST de jquery a una URL
* @param  {string} pagina      Numero de pagina a mostrar
* @param  {string} mensaje     Mensajes luegos de INSERTAR, ACTUALIZAR y ELIMINAR un registro
* @param  {string} entidad     Nombre de la entidad donde se va a inscrustar. Ejm: 'Usuario', 'Area', ect.
* @return {html}               Se incrusta el codigo HTML en el DIV
*/
function buscarCompaginado(pagina, mensaje, entidad, tipomesaje) {
	var formulario  = IDFORMBUSQUEDA + entidad;
	var contenedor  = 'listado' + entidad;
	if (pagina !== '') {
		$(formulario + ' :input[id = "page"]').val(pagina);
	}
	cargarSubmitForm(formulario, contenedor);
	if(mensaje !== ''){
		mostrarMensaje(mensaje, tipomesaje);
	}
}

/**
* Función para generar ventanas modales
* @param  {string} divContenedor ID del DIV que se va a crear y donde se va a inscrutar el código HTML
* @param  {string} controlador   URL del controlador a donde se enviará el REQUEST
* @param  {string} titulo        Título que se colocará en la ventanada modal
* @param  {boolean} listar       TRUE si se va a listar luego de cerrar el modal, FALSE si despues de cerrar el modal no se ejecuta nada
* @return {html}                 Se genera un modal
*/
function modal (controlador, titulo) {
	var idContenedor = "divModal" + contadorModal;
	var divmodal     = "<div id=\"" + idContenedor + "\"></div>";
	var box          = bootbox.dialog({
		message: divmodal,
		className: 'modal' +  contadorModal,
		title: titulo,
		closeButton: false
	});
	box.prop('id', 'modal'+contadorModal);
	/*$('#modal'+contadorModal).draggable({
		handle: ".modal-header"
	});*/
	modales[contadorModal] = box;
	contadorModal          = contadorModal + 1;
	setTimeout(function(){
		cargarRuta(controlador, idContenedor);
	},400);
}

/**
* Registrar o modificar un recurso
* @param  {string} entidad
* @return {void}
*/
function guardar (entidad, idboton, entidad2) {
	var idformulario = IDFORMMANTENIMIENTO + entidad;
	var data         = submitForm(idformulario);
	var respuesta    = '';
	var listar       = 'NO';
	if ($(idformulario + ' :input[id = "listar"]').length) {
		var listar = $(idformulario + ' :input[id = "listar"]').val();
	};
	var btn = $(idboton);
	// btn.button('loading');
	data.done(function(msg) {
		respuesta = msg;
	}).fail(function(xhr, textStatus, errorThrown) {
		respuesta = xhr.responseText;
		if(JSON.parse(respuesta).message.trim() == 'The given data was invalid.'){
			mostrarErrores(xhr.responseText, idformulario, entidad, 1);
		}
		respuesta = 'ERROR';
	}).always(function() {
		if(respuesta.trim() === 'ERROR'){
		}else {
			if (respuesta.trim() === 'OK') {
				cerrarModal();
				Hotel.notificaciones("Accion realizada correctamente", "Realizado" , "success");
				if (listar.trim() === 'SI') {
					if(typeof entidad2 != 'undefined' && entidad2 !== ''){
						entidad = entidad2;
					}
					buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
				}  
				buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
			} else {
				mostrarErrores(respuesta, idformulario, entidad);
			}
		}
	});
}

function mostrarErrores (data, idformulario, entidad, type = null) {
	try {
		if(type != null){
			var mensajes = JSON.parse(data).errors;
		}else{
			var mensajes = JSON.parse(data);
		}
		var divError = '#divMensajeError' + entidad;
		$(divError).html('');
		var respuesta = true;
		$(idformulario).find(':input').each(function() {
			var elemento         = this;
			var cadena           = idformulario + " :input[id='" + elemento.id + "']";
			var elementoValidado = $(cadena);
			elementoValidado.parent().removeClass('has-error');
		});
		var cadenaError = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Por favor corrige los siguentes errores:</strong><ul>';
		for(var valor in mensajes){
			var cadena           = idformulario + " :input[id='" + valor + "']";
			var elementoValidado = $(cadena);
			elementoValidado.parent().addClass('has-error');
			var cantidad = mensajes[valor].length;
			for (var i = 0; i < cantidad; i++) {
				if (mensajes[valor][i] != '') {
					cadenaError += ' <li>' + mensajes[valor][i] + '</li>';
				}
			};
		}
		cadenaError += '</ul></div>';
		$(divError).html(cadenaError);
	} catch (e) {
		$('#divMensajeError'+(contadorModal-1)).html(data);
	}
}

/**
* Eliminar recurso
* @param  {string} idformulario
* @param  {string} entidad
* @return {html}
*/
function eliminar (idformulario, entidad, mensajepersonalizado) {
	var mensaje = '¿Está seguro de eliminar el registro?';
	if (typeof mensajepersonalizado != 'undefined' && mensajepersonalizado !== '') {
		mensaje = mensajepersonalizado;
	}
	bootbox.confirm({
		message : mensaje,
		buttons: {
			'cancel': {
				label: 'Cancelar',
				className: 'btn btn-default btn-sm'
			},
			'confirm':{
				label: 'Eliminar',
				className: 'btn btn-danger btn-sm'
			}
		}, 
		callback: function(result) {
			if (result) {
				var respuesta = '';
				var data      = submitForm('#'+idformulario);
				data.done(function(msg) {
					respuesta = msg;
				}).fail(function(xhr, textStatus, errorThrown) {
					respuesta = 'ERROR';
				}).always(function() {
					if (respuesta === 'OK') {
						buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
					} else if(respuesta === 'ERROR') {
						mostrarMensaje('Error procesando la eliminacion', 'ERROR');
					} else{
						var mensajes = JSON.parse(respuesta);
						var cadenaError = '';
						for(var valor in mensajes){
							var cantidad = mensajes[valor].length;
							for (var i = 0; i < cantidad; i++) {
								if (mensajes[valor][i] != '') {
									cadenaError += '- ' + mensajes[valor][i] + '\n';
								}
							};
						}
						alert(cadenaError);
					}
				});
			};
		}            
	}).find("div.modal-content").addClass("bootboxConfirmWidth");
	setTimeout(function () {
		if (contadorModal !== 0) {
			$('.modal' + (contadorModal-1)).css('pointer-events','auto');
			$('body').addClass('modal-open');
		}
	},2000);
}


/**
* Funcion para inicar un formulario de mantenimiento
* @param  {[type]} entidad
* @return {[type]}
*/
function init(idformulario, tipoformulario) {
	$(idformulario).submit(function( event ) {
		event.preventDefault();
	});
	$('label').click(function(event) {
		event.preventDefault();
		var a = $(this).attr("for");
		var b = $(idformulario + ' :input[id="' + a + '"]');
		var tipo = b.attr('type');
		if (tipo === 'checkbox') {
			if (b.is(':checked')) {
				b.prop( "checked", false );
			} else{
				b.prop( "checked", true );
			};
			b.trigger('onchange');
		} else{
			b.focus();
		};
	});
	if(tipoformulario === 'M'){
		$(idformulario + ' input, ' + idformulario + ' select, ' + idformulario + ' .calendar').keydown( function(e) {
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			if(key == 13) {
				e.preventDefault();
				var inputs = $(this).closest('form').find(':input:visible:not([disabled]):not([readonly])');
				inputs.eq( inputs.index(this)+ 1 ).focus();
			}
		});
	}
}




/**
* Función para cerrar el último modal generado
* @return {void} Se ejecuta la acción de cerrar el último modal generado
*/
function cerrarModal() {
	contadorModal = contadorModal - 1;
	modales[contadorModal].modal('hide');
	if (contadorModal !== 0) {
		$('.modal' + (contadorModal-1)).css('pointer-events','auto');
		$('body').addClass('modal-open');
	}
}

/**
* Función para cerrar el último modal generado mediante confirmacion
* @return {void} Se ejecuta la acción de cerrar el último modal generado
*/
function cerrarModalConfirm() {
	bootbox.confirm({
		message : '¿Está seguro de cerrar la ventana?',
		buttons: {
			'cancel': {
				label: 'Cancelar',
				className: 'btn btn-default btn-sm'
			},
			'confirm':{
				label: 'Cerrar',
				className: 'btn btn-danger btn-sm'
			}
		}, 
		callback: function(result) {
			if (result) {
				contadorModal = contadorModal - 1;
				modales[contadorModal].modal('hide');
			}
		}
	}).find("div.modal-content").addClass("bootboxConfirmWidth");
	setTimeout(function () {
		if (contadorModal !== 0) {
			$('.modal' + (contadorModal-1)).css('pointer-events','auto');
			$('body').addClass('modal-open');
		}
	},2000);
}
/**
* Generar mensaje que aparece a la derecha de la pantalla
* @param  {string} mensaje
* @return {html}
*/
function mostrarMensaje (mensaje, tipo) {
	var divMensaje = $('#divMensaje');
	divMensaje.removeClass('alert-danger');
	divMensaje.removeClass('alert-success');
	if (tipo === 'ERROR') {
		divMensaje.addClass('alert-danger');
	} else if(tipo === 'OK'){
		divMensaje.addClass('alert-success');
	};
	divMensaje.html('<span>' + mensaje + '</span>');
	divMensaje.show('slow');
	setTimeout(function(){
		divMensaje.html('');
		divMensaje.hide("slow");
	},3000);
}

function mostrarProvincias(ruta, entidad, tipo) {
	var iddepartamento;
	if (tipo === 'B') {
		iddepartamento = $(IDFORMBUSQUEDA + entidad + " :input[id='departamento_id']").val();
	}
	if (tipo === 'M') {
		iddepartamento = $(IDFORMMANTENIMIENTO + entidad + " :input[id='departamento_id']").val();
	}
	if (iddepartamento !== '') {
		ruta = ruta + '/' + iddepartamento;
	};    
	var respuesta = '';
	var data = sendRuta(ruta);
	data.done(function(msg) {
		respuesta = msg;
	}).fail(function(xhr, textStatus, errorThrown) {
		respuesta = estiloError('Error en el procesamiento de la ruta');
	}).always(function() {
		if (tipo === 'B') {
			$(IDFORMBUSQUEDA + entidad + " :input[id='provincia_id']").html("'<option value=''>Todas</option>");
			$(IDFORMBUSQUEDA + entidad + " :input[id='provincia_id']").append(respuesta);
			$(IDFORMBUSQUEDA + entidad + " :input[id='distrito_id']").html("'<option value=''>Todas</option>");
		}
		if (tipo === 'M') {
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='provincia_id']").html("'<option value=''>Seleccione provincia</option>");
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='provincia_id']").append(respuesta);
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='distrito_id']").html("'<option value=''>Seleccione distrito</option>");
		}
	});
}

function mostrarDistritos(ruta, entidad, tipo) {
	var idprovincia;
	if (tipo === 'B') {
		idprovincia = $(IDFORMBUSQUEDA + entidad + " :input[id='provincia_id']").val();
	}
	if (tipo === 'M') {
		idprovincia = $(IDFORMMANTENIMIENTO + entidad + " :input[id='provincia_id']").val();
	}
	if (idprovincia !== '') {
		ruta = ruta + '/' + idprovincia;
	};    
	var respuesta = '';
	var data = sendRuta(ruta);
	data.done(function(msg) {
		respuesta = msg;
	}).fail(function(xhr, textStatus, errorThrown) {
		respuesta = estiloError('Error en el procesamiento de la ruta');
	}).always(function() {
		if (tipo === 'B') {
			$(IDFORMBUSQUEDA + entidad + " :input[id='distrito_id']").html("'<option value=''>Todas</option>");
			$(IDFORMBUSQUEDA + entidad + " :input[id='distrito_id']").append(respuesta);
		}
		if (tipo === 'M') {
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='distrito_id']").html("'<option value=''>Seleccione distrito</option>");
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='distrito_id']").append(respuesta);
		}
	});
}

function completarCeros(numero, length) {
	var resultado = "";
	var ceros     = "0";
	var lengthAux = numero.length;
	if (lengthAux === length) {
		resultado = numero;
	} else if (lengthAux < length) {
		for (i = 0; i < (length - lengthAux); i++) {
			resultado = resultado + ceros;
		}
		resultado = resultado + numero;
	} else if (lengthAux > length) {
		resultado = "NUMERO MAXIMO ALCANZADO";
	}
	return resultado;
}

function solo_decimal(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ((charCode > 31 && (charCode < 46 || charCode > 57)) || charCode === 47) {
		return false;
	}
	return true;
}
function solo_numero(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		return false;
	}
	return true;
}

function configurarAnchoModal (ancho) {
	var nuevoancho = ancho + 'px';
	if (contadorModal === 1) {
		var divModal = '.modal' + (contadorModal - 1);
		$(divModal).children('.modal-dialog').css('width','auto');
		$(divModal).children('.modal-dialog').css('max-width', nuevoancho);
		$(divModal).children('.modal-dialog').css('margin-left','auto');
		$(divModal).children('.modal-dialog').css('margin-right','auto');
	}else{
		var divModal = '.modal' + (contadorModal - 1);
		var divModal2 = '.modal' + (contadorModal - 2);
		$(divModal).children('.modal-dialog').css('width','auto');
		$(divModal).children('.modal-dialog').css('max-width',nuevoancho);
		$(divModal).children('.modal-dialog').css('margin-left','auto');
		$(divModal).children('.modal-dialog').css('margin-right','auto');
		$(divModal2).css('pointer-events','none');
	}
}

function nuevaVentana (URL, tipo) {
	window.open(URL, tipo);
}


function confirmarpermiso (idformulario, idboton) {
	var data      = submitForm('#' + idformulario);
	var respuesta = '';
	var btn       = $(idboton);
	var url       = $('#' + idformulario + ' :input[id="url"]').val();
	btn.button('loading');
	data.done(function(msg) {
		respuesta = msg;
	}).fail(function(xhr, textStatus, errorThrown) {
		respuesta = 'ERROR';
	}).always(function() {
		btn.button('reset');
		if(respuesta === 'ERROR'){
		}else{
			if (respuesta === 'OK') {
				var divModal = 'divModal' + (contadorModal - 1);
				cargarRuta(url, divModal);
			} else{
				alert(respuesta);
			}
		}
	});
}

/**
 * cargar facultades en un select, enviando el id de la universidad
 * @param  {string} ruta    ruta del generador del combo
 * @param  {string} entidad para identificar en que formulario se va a cargar
 * @param  {string} tipo    B: para formulario de búsqueda, M: Para formulario de mantenimiento
 * @return {string}         contenido que se cargará en el select
 */
function mostrarFacultades(ruta, entidad, tipo) {
 	var iduniversidad;
 	if (tipo === 'B') {
 		iduniversidad = $(IDFORMBUSQUEDA + entidad + " :input[id='universidad_id']").val();
 	}
 	if (tipo === 'M') {
 		iduniversidad = $(IDFORMMANTENIMIENTO + entidad + " :input[id='universidad_id']").val();
 	}
 	if (iduniversidad !== '') {
 		ruta = ruta + '/' + iduniversidad;
 		var respuesta = '';
 		var data = sendRuta(ruta);
 		data.done(function(msg) {
 			respuesta = msg;
 		}).fail(function(xhr, textStatus, errorThrown) {
 			respuesta = estiloError('Error en el procesamiento de la ruta');
 		}).always(function() {
 			if (tipo === 'B') {
 				$(IDFORMBUSQUEDA + entidad + " :input[id='facultad_id']").html("'<option value=''>Todas</option>");
 				$(IDFORMBUSQUEDA + entidad + " :input[id='facultad_id']").append(respuesta);
 			}
 			if (tipo === 'M') {
 				$(IDFORMMANTENIMIENTO + entidad + " :input[id='facultad_id']").html("'<option value=''>Seleccione facultad</option>");
 				$(IDFORMMANTENIMIENTO + entidad + " :input[id='facultad_id']").append(respuesta);
 			}
 		});
 	}else{
 		$(IDFORMMANTENIMIENTO + entidad + " :input[id='facultad_id']").html("'<option value=''>Seleccione facultad</option>");
 	}
 }

/**
 * cargar escuelas en un select, enviando el id de la facultad
 * @param  {string} ruta    ruta del generador del combo
 * @param  {string} entidad para identificar en que formulario se va a cargar
 * @param  {string} tipo    B: para formulario de búsqueda, M: Para formulario de mantenimiento
 * @return {string}         contenido que se cargará en el select
 */
function mostrarEscuelas(ruta, entidad, tipo) {
	var idfacultad;
	if (tipo === 'B') {
		idfacultad = $(IDFORMBUSQUEDA + entidad + " :input[id='facultad_id']").val();
	}
	if (tipo === 'M') {
		idfacultad = $(IDFORMMANTENIMIENTO + entidad + " :input[id='facultad_id']").val();
	}
	if (idfacultad !== '') {
		ruta = ruta + '/' + idfacultad;
	};    
	var respuesta = '';
	var data = sendRuta(ruta);
	data.done(function(msg) {
		respuesta = msg;
	}).fail(function(xhr, textStatus, errorThrown) {
		respuesta = estiloError('Error en el procesamiento de la ruta');
	}).always(function() {
		if (tipo === 'B') {
			$(IDFORMBUSQUEDA + entidad + " :input[id='escuela_id']").html("'<option value=''>Todas</option>");
			$(IDFORMBUSQUEDA + entidad + " :input[id='escuela_id']").append(respuesta);
		}
		if (tipo === 'M') {
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='escuela_id']").html("'<option value=''>Seleccione distrito</option>");
			$(IDFORMMANTENIMIENTO + entidad + " :input[id='escuela_id']").append(respuesta);
		}
	});
}

function filter(__val__){
	var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
	if(preg.test(__val__) === true){
		return true;
	}else{
	return false;
	}
}

function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 48 && key <= 57) {
        if (filter(tempValue) === false) {
            return false;
        } else {
            return true;
        }
    } else {
        if (key == 8 || key == 13 || key == 0) {
            return true;
        } else if (key == 46) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}