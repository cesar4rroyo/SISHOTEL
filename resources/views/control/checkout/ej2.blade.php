<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style>
    .title {
        background-color: rgb(226, 194, 9);
        color: white;
        font-weight: bold;
        padding: 4px;
        text-align: center
    }

    .col {
        width: 50%;
        margin: 10px;
    }

    .content {
        display: flex;
        text-align: center;
    }

    .group {
        display: flex;
    }

    .label {
        text-transform: uppercase;

    }

    .col-3 {
        width: 33%;
    }

    .col-100 {
        width: 100%;
    }

    .input {
        border: 1px solid black;
        padding: 2px;
        border-radius: 5px;
        width: 100%;
    }

    .main {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .img-container {
        position: absolute;
        top: 1;
        left: 1;
    }
</style>

<body>
    <div class="header">
        <div class="img-container">
            <img src="{{asset("assets/$theme/dist/img/logo.jpeg")}}" width="80px" alt="">
        </div>
        <div class="main">
            <h2>Ficha de Registro Nro. 1</h2>
        </div>
    </div>
    <div class="title">Información del Húesped</div>
    <div class="content">
        <div class="col">
            <div class="group">
                <p class="label">Nombres:</p>
                <p class="input">César David</p>
            </div>
        </div>
        <div class="col">
            <div class="group">
                <p class="label">Apellidos:</p>
                <p class="input">Arroyo Torres</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col">
            <div class="group">
                <p class="label">Empresa:</p>
                <p class="input">Dalas</p>
            </div>
        </div>
        <div class="col">
            <div class="group">
                <p class="label">RUC:</p>
                <p class="input">202015738787</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col">
            <div class="group">
                <p class="label">Nro Pasaporte:</p>
                <p class="input">4783874873093-232</p>
            </div>
        </div>
        <div class="col">
            <div class="group">
                <p class="label">Fecha Nac.</p>
                <p class="input">25-09-2019</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col-100">
            <div class="group">
                <p class="label">Direccion:</p>
                <p class="input">Av. Antenor Orrego Mz. B Lte 10</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col">
            <div class="group">
                <p class="label">Ciudad:</p>
                <p class="input">Chiclayo</p>
            </div>
        </div>
        <div class="col">
            <div class="group">
                <p class="label">Edad:</p>
                <p class="input">20</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col">
            <div class="group">
                <p class="label">Telefono:</p>
                <p class="input">9284738723</p>
            </div>
        </div>
        <div class="col">
            <div class="group">
                <p class="label">Pais:</p>
                <p class="input">Perú</p>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col-100">
            <div class="group">
                <p class="label">Email:</p>
                <p class="input">cesardavid_09@hotmail.com</p>
            </div>
        </div>
    </div>
    <div class="title">Información de la Habitación</div>
    <div class="content">
        <div class="col-100">
            <p>HABITACION MATRIMONIAL STD. SUPERIOR</p>
        </div>
    </div>
    <div class="title">Información de llegada y salida</div>
    <div class="content">
        <div class="col-3">
            <div class="group">
                <p class="label">Check-In:</p>
                <p class="input">31/04</p>
            </div>
        </div>
        <div class="col-3">
            <div class="group">
                <p class="label">Check-Out:</p>
                <p class="input">01/39</p>
            </div>
        </div>
        <div class="col-3">
            <div class="group">
                <p class="label">Nro Dias:</p>
                <p class="input">04</p>
            </div>
        </div>
    </div>


</body>

</html>