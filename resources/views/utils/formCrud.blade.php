<form action="{{ ($method=='PUT' || $method=='DELETE') ? route($route[0], $route[1]) : route($route)  }}" method="{{ $method }}" class=" {{ $formData['class'] }}"
id="{{ $formData['id'] }}" autocomplete="off">
    @csrf
    <input type="hidden" name="accion" id="accion" value="listar">
    <input type="hidden" name="id" id="id" value="{{ isset($model) ? $model->id : null }}">