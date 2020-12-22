{{-- {{dd($opciones)}} --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route("admin")}}" class="brand-link">
        <img src="{{asset("assets/$theme/dist/img/admin.jpg")}}" alt="Hotel Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sistema Hotel</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset("assets/$theme/dist/img/adminPic.png")}}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{session()->get('usuario') ?? 'Invitado'}}</a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($opciones as $key=>$item)
                @include("theme.lte.menu",["item"=>$item])
                @endforeach
            </ul>
        </nav>
    </div>
</aside>