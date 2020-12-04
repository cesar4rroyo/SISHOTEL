@extends("theme.$theme.layout")

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Unidad</div>
                <div class="card-body">
                    <a href="{{ route('create_unidad') }}" class="btn btn-success btn-sm" title="Add New unidad">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agrear Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unidad as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <a href="{{ route('show_unidad' , $item->id) }}" title="View unidad"><button
                                                class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                Ver</button></a>
                                        <a href="{{ route('edit_unidad' , $item->id ) }}" title="Edit unidad"><button
                                                class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                    aria-hidden="true"></i>
                                                Editar</button></a>

                                        <form method="POST" action="{{ route('destroy_unidad' , $item->id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete unidad"
                                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $unidad->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection