document.addEventListener("DOMContentLoaded", function () {

    const grupos = document.getElementsByClassName('grupomenu');
    for (i = 0; i < grupos.length; i++) {
        if (grupos[i].children.length === 0) {
            var grupomenu = grupos[i].parentElement;
            grupomenu.classList.add('d-none');
        }
    }

    var menu = $('ul.nav-sidebar').find('a.active').parents('li.has-treeview');
    menu.addClass('menu-open');
    menu.children('a').addClass('active');


    $("#tabla-data").on('submit', '.form-eliminar', function (event) {
        event.preventDefault();
        const form = $(this);
        swal({
            title: '¿ Está seguro que desea eliminar el registro ?',
            text: "Si lo elimina ahora ya no lo podrá usar despues!",
            icon: 'warning',
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar"
            },
        }).then((value) => {
            if (value) {
                ajaxRequest(form);
            }
        });
    });

    function ajaxRequest(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    form.parents('tr').remove();
                    Hotel.notificaciones('El registro fue eliminado correctamente', 'Hotel', 'success');
                } else {
                    Hotel.notificaciones('El registro no pudo ser eliminado, hay recursos usandolo', 'Hotel', 'error');
                }
            },
            error: function (e) {
                console.log('Error: ', e);
            }
        });
    }


    $('.select2').select2();

    $('.clientes-select2').select2();

    $(".clientes-select2").select2({
        theme: "classic",
        width: '100%',
    });
    $(".habitacion-select2").select2({
        theme: "classic",
        width: '100%',
        height: '100px'
    })

});