<html>

<head>
    <meta charset='utf-8' />
    <link href="{{asset('assets/fullcalendar/lib/main.css')}}" rel='stylesheet' />
    <script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
       
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          initialDate: {!! json_encode($initialDate) !!},
          locale:'es',
          timeZone: 'local',
          dateClick:function(info){
              $('#txtFecha').val(info.dateStr);
              $('#modal-default').modal();
              console.log(info);
             
          },
          events:"{{route('show_reserva')}}",
        });
        calendar.render();
        $('#btnAgregar').click(function(){
            event = getDatosForm('POST');
            postDatos('', event );
        })
        function getDatosForm(method){
            newEvent={
                fecha:$('#txtFecha').val(),
                observacion:$('#observacion').val(),
                persona_id:$('#persona').val(),
                habitacion_id:$('#habitacion').val(),
                '_token': $('input[name=_token]').val(),
                '_method':method
            }
            return newEvent;
        }
        function postDatos(action, event){
            $.ajax(
                {
                    type:'POST',
                    url:'reserva',
                    data: event,
                    success: function (respuesta) {
                        Hotel.notificaciones(respuesta.respuesta, 'Reserva', 'success');
                        $('#modal-default').modal('hide');
                    },
                    error: function (e) {
                        console.log(e);
                    },
                }
            )
        }
      });

    </script>
</head>
<style>
    .fc-toolbar-title {
        text-transform: capitalize;
        font-size: 1.5rem
    }

    .fc-today-button {
        text-transform: capitalize;
    }

    #calendar {
        width: 70%;
        margin: auto;
    }
</style>

<body>
    <div class="container m-3">
        <div id='calendar'></div>
    </div>

</body>

</html>