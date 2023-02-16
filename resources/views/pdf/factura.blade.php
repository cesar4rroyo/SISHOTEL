<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DOCUMENTO DE PAGO</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('assets/logo.png')}}" alt="" width="150" /></td>
            <td align="right">
                <h3>MARAKOS GRIL S.A.C.</h3>
                <pre>
                RUC 20605066942
                CALLE MIGUEL GRAU NRO. 795
                LAMBAYEQUE - CHICLAYO - PIMENTEL
            </pre>
            </td>
        </tr>

    </table>

    <table width="100%">
        <tr>
            <td align="center">
                <h3><strong>FACTURA ELECTRÓNICA: {{$comprobante['numero']}}</strong></h3>
                <hr>
            </td>
        </tr>
        <hr>
        <tr>
            <td><strong>FECHA:</strong> {{$comprobante['fecha']}}</td>
        </tr>
        <tr>
            <td><strong>DNI/RUC:</strong> {{$dniRuc}}</td>
        </tr>
        <tr>
            <td><strong>NOMBRE:</strong>
                {{($nombre) ? $nombre : 'VARIOS'}}
            </td>
        </tr>
        <tr>
            <td><strong>DIRECCION:</strong>{{!is_null($direccion)?$direccion :'-'}}
            </td>
        </tr>
        <tr>
            <td><strong>FORMA DE PAGO:</strong>{{'Contado'}}
            </td>
        </tr>
    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio Unitario S/.</th>
                <th>Subtotal S/.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $item)
            <tr>
                <th scope="row">{{($loop->index)+1}}</th>
                @if (!is_null($item['producto_id']))
                <td>{{$item['producto']['nombre']}}</td>
                @else
                <td>{{$item['servicios']['nombre']}}</td>
                @endif
                <td>{{$item['cantidad']}}</td>
                <td>{{$item['preciocompra']}}</td>
                <td>{{$item['precioventa']}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Op. Gravada S/.</td>
                <td align="right">{{$comprobante['subtotal']}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">I.G.V (18%)</td>
                <td align="right">{{$comprobante['igv']}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Op. Inafecta</td>
                <td align="right">{{'0.00'}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Op. Exonerada</td>
                <td align="right">{{'0.00'}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">TOTAL S/.</td>
                <td align="right" class="gray">{{$comprobante['total']}}</td>
            </tr>
        </tfoot>
    </table>
    <hr>
    <table width="100%">
        <tr>
            <td align="center">
                <h4><strong>¡Gracias por su preferencia!</strong></h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p><strong>Representación impresa del Comprobante
                        Electrónico, consulte en https://facturaegarzasoft.com</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>