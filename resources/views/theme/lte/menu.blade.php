@if ($item["opcionmenu"]!=[])
<li class="nav-item has-treeview">
    <a href="javascript:;" class="nav-link">
        <i class="nav-icon fa {{$item["icono"]}}"></i>
        <p>
            {{$item["nombre"]}}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview grupomenu">
        @foreach ($item["opcionmenu"] as $opcion)
        <li class="nav-item pl-2">
            <a href="{{url($opcion["link"])}}" class="nav-link {{getMenuActivo($opcion["link"])}}">
                <i class="nav-icon fa {{$opcion["icono"]}}"></i>
                <p>
                    {{$opcion["nombre"]}}
                </p>
            </a>
        </li>
        @endforeach
    </ul>
</li>
@endif