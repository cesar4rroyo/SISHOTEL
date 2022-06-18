// FUNCIONES GENERALES

var Hotel = (function () {
    return {
        notificaciones: function (mensaje, titulo, tipo) {
            toastr.options = {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                timeOut: "5000",
            };
            if (tipo == "error") {
                toastr.error(mensaje, titulo);
            } else if (tipo == "success") {
                toastr.success(mensaje, titulo);
            } else if (tipo == "info") {
                toastr.info(mensaje, titulo);
            } else if (tipo == "warning") {
                toastr.warning(mensaje, titulo);
            }
        },
    };
})();

function toggleDivCheckBox(id, div){
    var e =  $('#' + id).prop('checked');
    if(e){
        $('#' + div).show();
    }else{
        $('#' + div).hide();
    }
}


//FUNCIONES ESPECIFICAS

function validarCaja(){
    var montocierre = $('#total_cierre').val();
    var total = $('#total').val();
    var desbalance = montocierre - total;
    if (desbalance !=0) {
        if(!confirm('El monto de la caja esta con un desbalance de S/.'+ desbalance +', desea continuar?')){
            return false;
        }
    }
}

function buscarPersona(dni) {
    $.ajax({
        type: "GET",
        url:
            "http://facturae-garzasoft.com/facturacion/buscaCliente/BuscaCliente2.php?" +
            "dni=" +
            dni +
            "&fe=N&token=qusEj_w7aHEpX",
        success: function (r) {
            var data = JSON.parse(r);
            if (data.code == 0) {
                $("#nombres").val(
                    data.nombres + " " + data.apepat + " " + data.apemat
                );
            }
        },
        error: function (r) {
            Hotel.notificaciones(
                "Error, DNI Incorrecto",
                "Operación no realizada",
                "danger"
            );
        },
    });
}

function buscarPersonaRuc(ruc) {
    $.ajax({
        type: "GET",
        url: "http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N",
        data: "&token=qusEj_w7aHEpX" + "&ruc=" + ruc,
        success: function (r) {
            var data = JSON.parse(r);
            if (data.code == 0) {
                $("#nombres").val(data.RazonSocial);
                $("#direccion").val(data.Direccion);
            }
        },
        error: function (e) {
            Hotel.notificaciones(
                "Error, RUC Incorrecto",
                "Operación no realizada",
                "danger"
            );
        },
    });
}

function BuscarNroDocumento(nrodoc=null) {
    if(!nrodoc){
        var nrodoc = $("#documento").val();
    }
    if (nrodoc.trim().length == 8) {
        buscarPersona(nrodoc);
    } else if (nrodoc.trim().length == 11) {
        buscarPersonaRuc(nrodoc);
    } else {
        Hotel.notificaciones(
            "Error número de documento no valido",
            "Operación no realizada",
            "error"
        );
        $("#nombres").val("");
        $("#direccion").val("");
        $("#telefono").val("");
        $("#email").val("");
    }
}


function handleChangeTipoDocumento(id, url, input){
    var e = $('#' + id).val();
    $.ajax({
        type: "GET",
        url: url,
        data: "&" + id + "=" + e,
        success: function (r) {
            $('#' + input).val(r);
        },
        error: function (e) {
            Hotel.notificaciones(
                "Ha ocurrido un error en el servidor",
                "Operación no realizada",
                "danger"
            );
        },
    });
}
