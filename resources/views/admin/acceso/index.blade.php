@extends("theme.$theme.layout")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold ">Accesos</div>
                <div class="card-body">
                    <div class="card-body table-responsive p-0">
                        @csrf
                        <table class="table table-striped table-bordered table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Tipos de Usuario</th>
                                    @foreach ($tipousuarios as $id => $nombre)
                                    <th class="text-center">{{$nombre}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupomenus as $key=>$grupomenu)
                                <tr>
                                    <td class="font-weight-bold"><i
                                            class="fa fa-arrows-alt"></i>{{$grupomenu["nombre"]}}</td>
                                    @foreach ($tipousuarios as $id=>$nombre)

                                    @endforeach
                                </tr>
                                @foreach ($grupomenu["opcionmenu"] as $key => $opcion)
                                <tr>
                                    <td style="padding-left: 50px" class="pl-40"><i
                                            class="fa fa-arrow-right"></i>{{ $opcion["nombre"] }}</td>
                                    @foreach ($tipousuarios as $id => $nombre)
                                    <td class="text-center">
                                        <input type="checkbox" class="acceso" name="acceso[]"
                                            data-opcionid={{$opcion["id"]}} value="{{$id}}"
                                            {{in_array($id, array_column($opcionmenus[$opcion["id"]], "id"))? "checked" : ""}}>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection