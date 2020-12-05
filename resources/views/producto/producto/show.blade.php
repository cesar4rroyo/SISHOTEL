@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Producto {{ $producto->id }}</div>
                <div class="card-body">

                    <a href="{{ route('producto') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_producto' , $producto->id ) }}" title="Edit producto"><button
                            class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Editar</button></a>

                    <form method="POST" action="{{ route('destroy_producto' , $producto->id) }}" accept-charset="UTF-8"
                        style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete producto"
                            onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                aria-hidden="true"></i> Eliminar</button>
                    </form>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $producto->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $producto->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Precio de Venta </th>
                                    <td> {{ $producto->precioventa }} </td>
                                </tr>
                                <tr>
                                    <th> Precio de Compra </th>
                                    <td> {{ $producto->preciocompra }} </td>
                                </tr>
                                <tr>
                                    <th> Categoria </th>
                                    <td> {{ $producto->categoria->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Unidad </th>
                                    <td> {{ $producto->unidad->nombre }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection