@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Nueva Venta</div>
            <div class="card-body">
                <a href="{{ route('habitaciones') }}" title="Regresar"><button
                        class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Regresar</button></a>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <p class="font-weight-bold ">Productos</p>
                            <div class="container">
                                <form action="{{route('ventas_productos')}}">
                                    <div class="input-group">
                                        <input type="search" name="search" placeholder="Buscar Producto"
                                            class="form-control">
                                        <span class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="container" style="height: 300px; overflow:auto">
                                <table class="table text-center table-hover table-fixed" id="tabla-data">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productos as $item)
                                        <tr>
                                            <td>{{ $item['nombre'] }}</td>
                                            <td>{{'S/. '}}{{ $item['precioventa'] }}</td>
                                            <td>
                                                <button data-id="{{$item['id']}}" type="button"
                                                    class="addToCart btn btn-outline-success">
                                                    <i class="fas fa-plus-circle"></i>
                                                    Agregar
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm">
                            <p class="font-weight-bold ">Productos Seleccionados</p>
                            <div class="container" style="height: 300px; overflow:auto">
                                <table class="table text-center table-hover" id="tabla-data">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php $total = 0 ?>
                                        @if (session('cart_ventas'))
                                        @foreach (session('cart_ventas') as $id=>$details)
                                        <?php $total += $details['precio'] * $details['cantidad'] ?>
                                        <tr>
                                            <td>
                                                {{ $details['nombre']}}
                                            </td>
                                            <td data-th="Quantity" style="width: 20%">
                                                <input type="number" class="form-control text-center quantity"
                                                    value="{{$details['cantidad']}}">
                                            </td>
                                            <td>
                                                {{ $details['precio'] * $details['cantidad']}}
                                            </td>
                                            <td>

                                                <button data-id="{{$id}}" type="button"
                                                    class="addToCart btn btn-outline-success">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                                <button data-id="{{$id}}" type="button"
                                                    class="removeFromCart btn btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button data-id="{{$id}}" type="button"
                                                    class="btn btn-outline-secondary updateCart">
                                                    <i class="fas fa-save"></i>
                                                </button>

                                                {{-- @csrf --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="container">
                                <p class="font-weight-bold ">Total: </p>
                                <input class="form-control" readonly type="number" value="{{$total}}">
                            </div>
                        </div>
                    </div>
                    <form action="{{route('add_detail_producto_ventas')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="comentario">{{'Comentario'}}</label>
                            <textarea class="form-control" name="comentario" id="comentario" cols="10"
                                rows="5"></textarea>
                        </div>
                        <div class="container text-center">
                            <button type="submit" class="btn btn-outline-success col-6">
                                Pago a caja
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {  
    
    $('.addToCart').on('click', function(){

            var id = $(this).data('id');
            if(id){
                $.ajax({
                    url:"{{url('admin/ventas/productos/addToCart')}}"+'/'+id,
                    type:'GET',
                    success:function(respuesta){
                        Hotel.notificaciones(respuesta.respuesta, 'Hotel', 'success');
                        location.reload();                         
                    },
                    error: function(e){
                        console.log(e);
                    }
                })
            }

        })
    $(".removeFromCart").on('click',function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Desea Eliminar")) {
            $.ajax({
                url: "{{url('admin/ventas/productos/removeFromCart')}}",
                method: "DELETE",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                success: function (respuesta) {
                    Hotel.notificaciones(respuesta.respuesta, 'Hotel', 'success');
                    location.reload();
                }
            });
        }
    });
    $(".updateCart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: "{{ url('admin/ventas/productos/updateCart') }}",
               method: "PATCH",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), cantidad: ele.parents("tr").find(".quantity").val()},
               success: function (respuesta) {
                    Hotel.notificaciones(respuesta.respuesta, 'Hotel', 'success');
                    location.reload();
            }
        });
    });

    });

</script>