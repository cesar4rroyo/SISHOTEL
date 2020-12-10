@if ($item["opciones"] == [])
<li class="nav-item">
    <a href="{{url($item['link'])}}" class="nav-link {{getMenuActivo($item["link"])}}">
        <i class="nav-icon fa {{$item["icono"]}}"></i>
        <p>
            {{$item["nombre"]}}
        </p>
    </a>
</li>
@else
<li class="nav-item has-treeview">
    <a href="javascript:;" class="nav-link">
        <i class="nav-icon fa {{$item["icono"]}}"></i>
        <p>
            {{$item["nombre"]}}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach ($item["opciones"] as $submenu)
        <li class="nav-item">
            <a href="{{url($submenu['link'])}}" class="nav-link {{getMenuActivo($submenu["link"])}}">
                <i class="nav-icon fa {{$submenu["icono"]}}"></i>
                <p>
                    {{$submenu["nombre"]}}
                </p>
            </a>
        </li>
        @endforeach
    </ul>
</li>
@endif