<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            font-family: 'Raleway', sans-serif;
            font-size: xx-small;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table_1 {
            width: 35%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background: #0f69b4;
        }

        th {
            color: #fff;
        }

        .description {
            font-size: x-small;
        }

        .titulo_div {
            font-size: x-small;
            border:1px solid red;
        }
    </style>
</head>
<body>
<div class="row">
  <div class="col-sm-4"><p><img src="./img/logo-mdsf.jpg" alt="Smiley face" height="60" width="70"></p></div>
</div>
<div class="container">
    <p class="description">
        <b>Convocatoria:</b> {{$convocatoria->anio}}
    </p>
    <p class="description">
        <b>Comunas:</b> {{$comunas}}
    </p>
    <h2>RESUMEN DIAGNÓSTICO FAMILIAR INTEGRAL FOSIS MDSF</h2>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>N°</th>
            <th>Run  BENEFICIARIO/A</th>
            <th>NOMBRE  BENEFICIARIO/A</th>
            <th>DIRECCIÓN</th>
            <th>PROGRAMA  ORIGEN</th>
            <th>CANTIDAD DE PROBLEMATICAS DE LA VIVIENDA Y EL ENTORNO</th>
            <th>N° DE PROBLEMÁTICAS  POR FAMILIA</th>
            <th>ACCIONES RIESGOSAS, INSALUBLES Y/O INADECUADAS</th>
            <th>HACINAMIENTO EN VIVIENDA</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($beneficiarios as $row)
            <tr>
                <td>{{$row->numero}}</td>
                <td>{{$row->rut_benef}}</td>
                <td>{{$row->nom_benef}}</td>
                <td>{{$row->direccion}}</td>
                <td>{{$row->nom_programa}}</td>
                <td>
                @foreach ($row->problematicas as $row1)
                    {{$row1->soluciones}}<br>
                @endforeach
                </td>
                <td>{{$row->count_prob}}</td>
                <td>
                @foreach ($row->acciones as $row2)
                    {{$row2->soluciones}}<br>
                @endforeach
                </td>
                <td>@if( $row->hacinamiento_familia <= 2.4 )
                        <p>Sin Hacinamiento</p>
                    @elseif( $row->hacinamiento_familia > 2.4 || $row->hacinamiento_familia <= 4.9 )
                        <p>Hacinamiento Medio</p>
                    @else
                        <p>Hacinamiento Critico</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
        <h2>Composición Etárea para Asesorías</h2>
        <table class="table_1 table-bordered table-striped">
            <thead>
                <tr>
                    <th>Rango Etáreo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($beneficiarios as $row)
                    @foreach ($row->hacinamiento as $row2)
                    <tr>
                    <td> {{$row2->rango}} </td>
                    <td> {{$row2->cantidad}} </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
</div>
</body>
</html>