<!DOCTYPE html>
<html>

<head>
    <title>DOCUMENTO DE PAGO</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        @page {
            margin: 0cm 0cm;
            /*   font-family: Arial; */

        }

        body {
            margin: 0.2cm;

        }



        .gray {
            background-color: lightgray
        }

        .divFirma {
            border: 1px solid black;
            border-right: none;
            border-left: none;
            width: 100%;
            padding: 0 5px;
            margin-top: 35px;
        }

        .firma {
            width: 50%;
            margin-right: auto;
            margin-left: auto;
            justify-content: center;
        }

    </style>
</head>

<body>
    <main>
        @php
            $nombre_doc = $tipo == 'BOLETA' ? 'BOLETA ELECTRÓNICA' : ($tipo == 'FACTURA' ? 'FACTURA ELECTRONICA' : 'TICKET');
        @endphp
        <p style=" margin:5px; text-align:center; font-size:14px; font-weight:bold;">HOTEL GARZASOFT</p>
        {{-- <p style=" margin:5px; text-align:center; font-size:14px; font-weight:bold;">DE: NERI TORO SILVA</p> --}}
        <p style=" margin:5px;  text-align:center; font-size:11px;"> RUC 20031544584</p>
        <p style=" margin:5px;  text-align:center; font-size:11px;"> CHICLAYO</p>
        <p style=" margin:5px;  text-align:center; font-size:11px;"> CHICLAYO - CHICLAYO - LAMBAYEQUE</p>
        <p style=" margin:5px;  text-align:center; font-size:14px; font-weight:bold;">{{ $nombre_doc }}</p>
        <p style=" margin:5px;  text-align:center; font-size:14px; font-weight:bold;">{{ $comprobante['numero'] }}</p>
        <table width='100%' style="  margin-top:10px; border-collapse: collapse;  ">
            <tr style="">
                <td style="  height:2px;  border-bottom : 0.5px black solid ">
                </td>
            </tr>
            <tr style="">
                <td style="  padding:15px 5px 5px ; font-size:12px; ">
                    <b style="width: 80px !important; display:inline-block;"> FECHA</b>
                    <p style="display: inline-block; margin:none;">: {{ $comprobante['fecha'] }}</p>
                </td>
            </tr>
            <tr style="">
                <td style="  padding:0px 5px 5px ; font-size:12px; text-align:left;">
                    <b style=" width: 80px !important; display:inline-block;">DNI/RUC</b>
                    <p style="display: inline-block; margin:none;">: {{ $dniRuc }}</p>
                </td>
            </tr>
            <tr style=" ">
                <td style="  padding:0px 5px 5px; font-size:12px; text-align:left; ">
                    <b style="width: 80px !important; display:inline-block;">NOMBRE</b>
                    <p style="display: inline-block; margin:none;">: {{ !is_null($nombre) ? $nombre : 'Varios' }}</p>
                </td>
            </tr>
            <tr style="">
                <td style=" padding:0px 5px 5px; font-size:12px; text-align:left; ">
                    <b style="width: 80px !important; display:inline-block;">DIRECCION</b>
                    <p style="display: inline-block; margin:none;width:80%;">:
                        {{ !is_null($direccion) ? $direccion : '-' }} </p>
                </td>
            </tr>
            @if ($tipo == 'FACTURA')
                <tr style="">
                    <td style=" padding:0px 5px 5px; font-size:12px; text-align:left; ">
                        <b style="width: 80px !important; display:inline-block;">FORMA DE PAGO</b>
                        <p style="display: inline-block; margin:none;width:80%;">: CONTADO </p>
                    </td>
                </tr>
            @endif
        </table>

        <table width='100%' style="  margin-top:5px; border-collapse: collapse; ">
            <tr>
                <td
                    style="width:40%; padding-bottom:5px; text-align:left; height:20px;  border : 0.5px black solid; border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    Producto</td>
                <td
                    style="width:20%; padding-bottom:5px; text-align:center; height:20px;  border : 0.5px black solid; border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    Cant.</td>
                <td
                    style="width:20%; padding-bottom:5px; text-align:center; height:20px;  border : 0.5px black solid; border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    Unit.</td>
                <td
                    style="width:20%; padding-bottom:5px; text-align:center; padding-right:10px; height:20px;  border : 0.5px black solid; border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    Subt.</td>
            </tr>

            @foreach ($detalles as $item)
                <tr>
                    <td colspan="4" style="width:100%;  padding: 1px;  text-align:left;     font-size:11px; ">
                        {{                         !is_null($item['producto_id']) ? $item['producto']['nombre'] : $item['servicios']['nombre'] }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:20%; padding: 1px; text-align:center;   font-size:11px;  ">
                        {{ number_format($item['cantidad'], 2) }}</td>
                    <td style="width:20%; padding: 1px; text-align:center;   font-size:11px;  ">
                        {{ number_format($item['preciocompra'], 2) }}</td>
                    <td style="width:20%;  padding: 1px; text-align:center; padding-right:10px;font-size:11px;  ">
                        {{ number_format($item['precioventa'], 2) }}</td>
                </tr>
            @endforeach
        </table>
        <table width='100%' style=" margin-top:10px; border-collapse: collapse; ">
            <tr>
                <td
                    style="width:35%; text-align:left;   border : 0.5px black solid; border-bottom:none;border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    Op. Gravada</td>
                <td
                    style="width:65%; text-align:right;   border : 0.5px black solid; border-bottom:none; border-left:none; border-right:none; font-size:13px;  font-weight:bold;">
                    {{ number_format('0.00', 2) }}</td>
            </tr>
            <tr>
                <td style="width:35%; text-align:left; font-size:13px;  font-weight:bold;">
                    I.G.V.(18%)</td>
                <td style="width:65%; text-align:right; font-size:13px;  font-weight:bold;">
                    {{ number_format('0.00', 2) }}</td>
            </tr>
            <tr>
                <td style="width:35%; text-align:left; font-size:13px;  font-weight:bold;">
                    Op. Inafecta</td>
                <td style="width:65%; text-align:right; font-size:13px;  font-weight:bold;">
                    {{ number_format('0.00', 2) }}</td>
            </tr>
            <tr>
                <td style="width:35%; text-align:left; font-size:13px;  font-weight:bold;">
                    Op. Exonerada</td>
                <td style="width:65%; text-align:right; font-size:13px;  font-weight:bold;">
                    {{ number_format($comprobante['total'], 2) }}</td>
            </tr>
            <tr>
                <td style="width:35%; text-align:left; font-size:13px;  font-weight:bold;">
                    TOTAL:</td>
                <td style="width:65%; text-align:right; font-size:13px;  font-weight:bold;">
                    {{ number_format($comprobante['total'], 2) }}</td>
            </tr>
        </table>
        @if ($tipo == 'TICKET')
            <table width='100%' style=" margin-top:8px; border-collapse: collapse; ">
                <tr>
                    <td
                        style="height:23px; text-align:center;   border : 2px black solid; border-left:none; border-right:none; font-size:15px;  font-weight:bold;">
                        Total a pagar : <span style="font-size:16px;"> S/. {{ number_format($comprobante['total'], 2) }} </span>
                    </td>

                </tr>

            </table>
        @endif
        <p style="text-align: center;">¡Gracias por su compra !</p>
        <p style="text-align: center;font-size:12px;  font-weight:bold;">
            {{ $tipo == 'TICKET' ? ' ' : 'Representación impresa del Comprobante Electrónico, consulte en https://facturae-garzasoft.com' }}
        </p>
    </main>

</body>

</html>
