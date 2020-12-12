$('.rol_persona').on('change', function () {
    var data = {
        persona_id: $(this).data('personaid'),
        rol_id: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    ajaxRequest('rolpersona', data);
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