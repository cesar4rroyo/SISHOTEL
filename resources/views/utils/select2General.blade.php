<select name="{{$name}}" id="{{$name}}" class="form-control">
    @foreach ($cbo as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
<script type="text/javascript">
    var name = '{{$name}}';
    $('#' + name).select2({
        theme: "bootstrap",
        width: '100%',
    });
</script>