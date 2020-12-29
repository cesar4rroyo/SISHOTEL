@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Registro {{ $caja->id }}</div>
                <div class="card-body">
                    <a href="{{ route('caja') }}" title="Regresar"><button class="btn btn-outline-secondary btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_caja' , $caja->id ) }}" title="Edit caja"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button>
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $caja->id }}</td>
                                </tr>
                                <tr>
                                    <th> Fecha </th>
                                    <td> {{ $caja->fecha }} </td>
                                </tr>
                                <tr>
                                    <th> Tipo </th>
                                    @if (($caja->tipo)=='Ingreso')
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $caja->tipo }}
                                        </span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $caja->tipo }}
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Número</th>
                                    <td>
                                        {{$caja->numero}}
                                    </td>
                                </tr>
                                <tr>
                                    <th> Persona </th>
                                    <td> {{ $caja->persona->nombres ." ". $caja->persona->apellidos }} </td>
                                </tr>
                                <tr>
                                    <th> Total </th>
                                    <td> {{ $caja->total }} </td>
                                </tr>
                                <tr>
                                    <th> Concepto </th>
                                    <td> {{ $caja->concepto->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Comentario </th>
                                    <td> {{ $caja->comentario }} </td>
                                </tr>
                                <tr>
                                    <th> Movimiento </th>
                                    <td> {{ isset($caja->movimiento) ? $caja->movimiento->id : "-"}} </td>
                                </tr>
                                <tr>
                                    <th> Usuario </th>
                                    <td> {{ $caja->usuario->login }} </td>
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