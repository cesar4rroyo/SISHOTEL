<button class="btn btn-warning" onclick="modal('{{URL::route($ruta['edit'], array($id, 'listar'=>'SI'))}}', '{{$titulo_modificar}}', this);" >
    <i class="fa fa-edit"></i>
</button>
<button class=" btn btn-danger"  onclick="modal('{{URL::route($ruta['delete'], array($id, 'listar'=>'SI'))}}', '{{$titulo_eliminar}}', this);">
    <i class="fa fa-trash"></i>
</button>