@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Confirmar Check-In</div>
            <div class="card-body">
                {{-- <a href="{{ route('habitaciones') }}" title="Regresar"><button
                    class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Regresar</button></a> --}}
                <div class="container">
                    <div class="row text-center m-auto">
                        <p class="font-weight-bold text-center">¿Desea continuar con el proceso?</p>
                    </div>
                    <div class="container text-center">
                        <form method="POST" action="{{route('update_movimiento', $habitacion)}}">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <input type="text" id="movimiento" name="movimiento" hidden>
                            <button type="submit" class="btn btn-outline-success col-sm-6">
                                Continuar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
       
        getMovimiento();
        function getMovimiento(){
            $.ajax({
                    url: 'show',
                    type: 'GET',
                    success: function (respuesta) {
                        console.log(respuesta['id']); 
                        $('#movimiento').val(respuesta['id']);                    
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });   
        }
    });
</script>