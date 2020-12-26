<html>

<head>
    <meta charset='utf-8' />
    <link href="{{asset('assets/fullcalendar/lib/main.css')}}" rel='stylesheet' />
    <script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
</head>
<style>
    /* .fc-left h2 {
        text-transform: capitalize;
        font-size: 1.5rem
    }

    .fc-today-button {
        text-transform: capitalize;
    } */
</style>

<body>
    <div class="container m-3">
        <div id='calendar'></div>
    </div>

</body>

</html>