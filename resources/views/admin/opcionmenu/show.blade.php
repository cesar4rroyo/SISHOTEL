@extends("theme.$theme.layout")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Opción de Menú {{ $opcionmenu->id }}</div>
                <div class="card-body">

                    <a href="{{ route('opcionmenu') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_opcionmenu' , $opcionmenu->id ) }}" title="Editar opcionmenu"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button></a>

                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $opcionmenu->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $opcionmenu->nombre}} </td>
                                </tr>
                                <tr>
                                    <th> Link </th>
                                    <td> {{ $opcionmenu->link }} </td>
                                </tr>
                                <tr>
                                    <th> Icono </th>
                                    <td>
                                        <span>
                                            <i style="color: rgb(14, 0, 0);font-size:20px"
                                                class="{{ $opcionmenu->icono}}"></i>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th> Orden </th>
                                    <td> {{ $opcionmenu->orden }} </td>
                                </tr>
                                <tr>
                                    <th> Grupo Menu </th>
                                    <td> {{ $opcionmenu->grupomenu->nombre }} </td>
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