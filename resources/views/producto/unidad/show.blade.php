@extends("theme.$theme.layout")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Unidad {{ $unidad->id }}</div>
                <div class="card-body">

                    <a href="{{ route('unidad') }}" title="Regresar"><button class="btn btn-outline-secondary btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_unidad',  $unidad->id) }}" title="Editar unidad"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $unidad->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $unidad->nombre }} </td>
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