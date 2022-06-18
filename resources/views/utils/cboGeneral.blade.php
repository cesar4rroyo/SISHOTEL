<select name="{{$name}}" id="{{$id}}" class="{{$class}}" {{ ($disabled) ? 'disabled' : null }} {{($required) ? 'required' : null}} onchange="{{$onchange}}">
    @foreach ($cbo as $key => $value)
        @if ($selected == $key)
            <option value="{{ $key }}" selected>{{ $value }}</option>
        @else
            <option value="{{ $key }}">{{ $value }}</option>
        @endif
    @endforeach
</select>
