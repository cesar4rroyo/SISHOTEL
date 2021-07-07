<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SYS|Hotel Adrian</title>
    <link rel="shortcut icon" href="{{asset("assets/$theme/dist/img/AdminLTELogo.png")}}" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <link rel="stylesheet" href="{{asset("select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
</head>
<style>
    .buttons-excel {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
        box-shadow: none;
        display: inline-block;
        font-weight: 400;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
    }

    .buttons-pdf {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
        box-shadow: none;
        display: inline-block;
        font-weight: 400;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
    }

    .buttons-print {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        box-shadow: none;
        display: inline-block;
        font-weight: 400;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include("theme/$theme/header")
        @include("theme/$theme/aside")
        <div class="content-wrapper">
            <section class="content p-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        {{-- @include("theme/$theme/footer") --}}
    </div>

    <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset("assets/$theme/dist/js/adminlte.min.js")}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset("assets/$theme/dist/js/demo.js")}}"></script>
    <script src="{{asset("assets/$theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    <script src="{{asset("js/admin/rolpersona/index.js")}}"></script>
    <script src="{{asset("js/admin/acceso/index.js")}}"></script>
    <script src="{{asset("js/admin/scripts.js")}}"></script>
    <script src="{{asset("js/funciones.js")}}"></script>
    <script src="{{asset("js/bootbox.min.js")}}"></script>
    <script src="{{asset("js/funciones2.js")}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset("select2/js/select2.min.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" />
    @yield('scripts')



</body>

</html>