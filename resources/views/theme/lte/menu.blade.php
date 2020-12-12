{{-- {{dd($item)}} --}}
<li class="nav-item has-treeview">
    <a href="javascript:;" class="nav-link">
        <i class="nav-icon fa {{$item["icono"]}}"></i>
        <p>
            {{$item["nombre"]}}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview grupomenu">
        @foreach ($opciones as $key=>$opcion)
        @if ($item["id"]==$opcion["grupomenu_id"])
        <li class="nav-item pl-2">
            <a href="{{url($opcion['link'])}}" class="nav-link {{getMenuActivo($opcion["link"])}}">
                <i class="nav-icon fa {{$opcion["icono"]}}"></i>
                <p>
                    {{$opcion["nombre"]}}
                </p>
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</li>