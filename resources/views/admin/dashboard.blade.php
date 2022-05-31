<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Personas</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <a 
                                    href="#"
                                    class="small-box-footer"
                                    onclick="cargarRuta('{{URL::to('admin/persona')}}', 'container');"
                                >
                                    Mas información <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Productos</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <a 
                                    href="#"
                                    class="small-box-footer"
                                    onclick="cargarRuta('{{URL::to('admin/producto')}}', 'container');"
                                >
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Habitaciones</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <a 
                                    href="#"
                                    class="small-box-footer"
                                    onclick="cargarRuta('{{URL::to('admin/habitacion')}}', 'container');"
                                >
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Servicios</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-server"></i>
                                </div>
                                <a 
                                    href="#"
                                    class="small-box-footer"
                                    onclick="cargarRuta('{{URL::to('admin/servicios')}}', 'container');"
                                >
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>