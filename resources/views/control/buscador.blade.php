@if (count($personas))
@foreach ($personas as $item)
<option value={{$item->id }}>{{ $item->nombres}}</option>
@endforeach
@endif