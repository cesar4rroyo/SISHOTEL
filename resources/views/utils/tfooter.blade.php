<tfoot>
    <tr>
        @foreach($cabecera as $key => $value)
            <th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
        @endforeach
    </tr>
</tfoot>