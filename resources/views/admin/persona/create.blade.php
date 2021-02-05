@extends("theme.$theme.layout")
{{-- {{dd($roles)}} --}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Crear Nueva persona</div>
                <div class="card-body">
                    <a href="{{ route('persona') }}" title="Regresar"><button class="btn btn-outline-info btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <form method="POST" action="{{ route('store_persona') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('admin.persona.form', ['formMode' => 'create'])

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        $("#btnBuscarRuc").on('click', function(){
            var ruc = $('#ruc').val();
            $.ajax({
                type:'GET',
                url: 'http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N',
                data:"&token=qusEj_w7aHEpX"+"&ruc="+ruc,
                success:function(r){
                    var data = JSON.parse(r);
                    if(data.code == 0){
                        $('#razonsocial').val(data.RazonSocial);
                        $('#direccion').val(data.Direccion);
                        $('#nombres').val('-');
                        $('#apellidos').val('-');
                    }
                }
            });
        });  
    });
</script>