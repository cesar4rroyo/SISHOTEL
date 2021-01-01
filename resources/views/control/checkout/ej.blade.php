<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .header {
        display: flex;
    }

    .title {
        background-color: rgb(172, 172, 5);
        color: white;
        font-weight: bold;
        padding: 4px;
        text-align: center
    }

    .col {
        width: 50%;
    }

    .content {
        display: flex;
        text-align: center;
    }

    .col p span {
        border: 2px solid black;
        padding: 2px;
        border-radius: 5px;
        width: 200px;
    }
</style>

<body>
    <div class="header">
        <img src="{{asset("assets/$theme/dist/img/logo.jpeg")}}" width="100px" alt="">
        <h2>Ficha de Registro Nro. 1</h2>
    </div>
    <div class="title">Información del Húesped</div>
    <div class="content">
        <div class="col">
            <p>Nombre:
                <span> Cesar David </span>
            </p>
        </div>
        <div class="col">
            <p>Apellidos:
                <span> Arroyo Torres </span>
            </p>
        </div>
    </div>
    <div class="title">Información de la Habitación</div>
    <div class="title">Información de llegada y salida</div>


</body>

</html>