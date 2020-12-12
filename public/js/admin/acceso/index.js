$('.acceso').on('change', function () {
    var data = {
        opcionmenu_id: $(this).data('opcionid'),
        tipousuario_id: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    ajaxRequest('acceso', data);
});

function ajaxRequest(url, data) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (respuesta) {
            Hotel.notificaciones(respuesta.respuesta, 'Hotel', 'success');
        },
        error: function (e) {
            console.log(e);
        }

    });
}