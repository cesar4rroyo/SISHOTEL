@extends("theme.$theme.layout")

@section('content')
@if ($message = Session::get('warning'))
<div class="alert alert-warning">
    <p>{{ $message }}</p>
</div>
@endif
@endsection