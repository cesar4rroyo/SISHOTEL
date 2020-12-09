@extends("theme.$theme.layout")
@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ADMIN PRINCIPAL</div>
                <div class="card-body">
                    <h3>Links</h3>
                    <ul>
                        <li>
                            <a href="{{route('tipohabitacion')}}">tipohabitacion</a>
                        </li>
                        <li>
                            <a href="{{route('piso')}}">piso</a>
                        </li>
                        <li>
                            <a href="{{route('habitacion')}}">habitacion</a>
                        </li>
                        <li>
                            <a href="{{route('concepto')}}">concepto</a>
                        </li>
                        <li>
                            <a href="{{route('servicios')}}">servicios</a>
                        </li>
                        <li>
                            <a href="{{route('categoria')}}">categoria</a>
                        </li>
                        <li>
                            <a href="{{route('producto')}}">producto</a>
                        </li>
                        <li>
                            <a href="{{route('unidad')}}">unidad</a>
                        </li>
                        <li>
                            <a href="{{route('grupomenu')}}">grupomenu</a>
                        </li>
                        <li>
                            <a href="{{route('opcionmenu')}}">opcionmenu</a>
                        </li>
                        <li>
                            <a href="{{route('acceso')}}">acceso</a>
                        </li>
                        <li>
                            <a href="{{route('tipousuario')}}">tipousuario</a>
                        </li>
                        <li>
                            <a href="{{route('rol')}}">rol</a>
                        </li>
                        <li>
                            <a href="{{route('rolpersona')}}">rolpersona</a>
                        </li>
                        <li>
                            <a href="{{route('persona')}}">persona</a>
                        </li>
                        <li>
                            <a href="{{route('nacionalidad')}}">nacionalidad</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection