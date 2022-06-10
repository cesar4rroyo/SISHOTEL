@if (count($lista) == 0)
    @include('utils.noresult')
@else
    <div class="card alert alert-warning mt-4">
        <div class="card-header text-uppercase font-weight-bold">{{ $pisoModel->nombre }}</div>
        <div class="card-body card-group">
            @foreach ($lista as $key => $value)
                @include('principal.habitacion', ['habitacion' => $value])
            @endforeach
        </div>
    </div>
@endif
