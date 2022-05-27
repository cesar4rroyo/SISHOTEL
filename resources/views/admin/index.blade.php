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
                <div class="card-header text-uppercase">Bienvenido, {{session()->get('usuario') ?? 'Invitado'}}</div>
                <div class="card-body">
                    
                </div>
            </div>

        </div>

    </div>
</div>
@endsection