@extends("theme.$theme.layout")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuario {{ $usuario->id }}</div>
                <div class="card-body">

                    <a href="{{ route('usuario') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_usuario',$usuario->id) }}" title="Edit usuario"><button
                            class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Editar</button></a>

                    <form method="POST" action="{{ route('destroy_usuario',$usuario->id) }}" accept-charset="UTF-8"
                        style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete usuario"
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
                                    <td>{{ $usuario->id }}</td>
                                </tr>
                                <tr>
                                    <th> Login </th>
                                    <td> {{ $usuario->login }} </td>
                                </tr>
                                {{-- <tr>
                                    <th> Password </th>
                                    <td> {{ $usuario->password }} </td>
                                </tr> --}}
                                <tr>
                                    <th> Tipo Usuario </th>
                                    <td> {{ $usuario->tipousuario->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Tipo Usuario </th>
                                    <td> {{ $usuario->persona->nombres ?? '-' }} </td>
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