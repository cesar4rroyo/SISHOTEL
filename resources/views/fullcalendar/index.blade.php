<html>

<head>
    <meta charset='utf-8' />
    <link href='{{asset('assets/fullcalendar/packages/core/main.css')}}' rel='stylesheet' />
    <link href='{{asset('assets/fullcalendar/packages/daygrid/main.css')}}' rel='stylesheet' />
    <script src='{{asset('assets/fullcalendar/packages/core/main.js')}}'></script>
    <script src='{{asset('assets/fullcalendar/packages/daygrid/main.js')}}'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
           plugins:['dayGrid']
          
        });
        calendar.setOption('locale','Es');
        calendar.render();
      });

    </script>
</head>

<body>
    <div class="container">
        <div id='calendar'></div>
    </div>

</body>

</html>