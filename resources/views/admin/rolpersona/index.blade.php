<div class="container" id="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if (session("mensaje"))
    <div class="alert alert-success alert-dismissible" data-auto-dismiss="3000">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Mensaje sistema Biblioteca</h4>
        <ul>
            <li>{{ session("mensaje") }}</li>
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Rol Persona</div>
                <div class="card-body">
                    <div class="card-body table-responsive p-0">
                        @csrf
                        <table class="table table-striped table-bordered table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Personas</th>
                                    @foreach ($roles as $id => $nombre)
                                    <th class="text-center">{{$nombre}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personas as $key=>$persona)
                                <tr>
                                    <td>
                                        @if (trim($persona['razonsocial'])=='' || is_null($persona['razonsocial']))
                                        {{$persona["nombres"] }}{{" "}}{{$persona["apellidos"]}}
                                        @else
                                        {{$persona['razonsocial']}}
                                        @endif
                                    </td>
                                    @foreach ($roles as $id=>$nombre)
                                    <td class="text-center">
                                        <input type="checkbox" class="rol_persona" name="personarol[]"
                                            data-personaid={{$persona["id"]}} value="{{$id}}"
                                            {{in_array($id, array_column($personasroles[$persona["id"]], "id"))? "checked" : ""}}>
                                    </td>
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
<script>
    $(document).ready(function () {
        $('.rol_persona').on('change', function () {
            var data = {
                persona_id: $(this).data('personaid'),
                rol_id: $(this).val(),
                _token: $('input[name=_token]').val()
            };
            if ($(this).is(':checked')) {
                data.estado = 1
            } else {
                data.estado = 0
            }
            ajaxRequest('admin/rolpersona', data);
        });
        function ajaxRequest(url, data) {
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (respuesta) {
                    Hotel.notificaciones(respuesta.respuesta, 'Hotel', 'success');
                },
                error: function (e) {
                    console.log(e);
                }

            });
        }
    });
</script>