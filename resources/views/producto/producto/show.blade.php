@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Producto {{ $producto->id }}</div>
                <div class="card-body">

                    <a href="{{ route('producto') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_producto' , $producto->id ) }}" title="Editar producto"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button></a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table" id="tabla-data">
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