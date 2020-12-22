@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Grupomenu {{ $grupomenu->id }}</div>
                <div class="card-body">

                    <a href="{{ route('grupomenu') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_grupomenu', $grupomenu->id ) }}" title="Editar grupomenu"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $grupomenu->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $grupomenu->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Icono </th>
                                    <td> {{ $grupomenu->icono }} </td>
                                </tr>
                                <tr>
                                    <th> Orden </th>
                                    <td> {{ $grupomenu->orden }} </td>
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