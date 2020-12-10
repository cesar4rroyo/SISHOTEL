@extends("theme.$theme.layout")

@section('content')
@if ($message = Session::get('warning'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
@endsection