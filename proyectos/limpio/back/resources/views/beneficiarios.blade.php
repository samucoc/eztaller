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
    </style>
</head>
<body>
<div class="container">
    <h1>Listado de familias potenciales</h1>
    <p class="description">
        <b>Convocatoria:</b> {{$convocatoria->anio}}
    </p>
    <p class="description">
        <b>Comunas:</b> {{$comunas}}
    </p>
    <h2>Datos de familias</h2>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>N°</th>
            <th>RUN Representante</th>
            <th>Nombre Representante</th>
            <th>Dirección</th>
            <th>Programa Origen</th>
            <th>Teléfono</th>
            <th>Activo</th>
            <th>Nombre apoyo familiar</th>
            <th>Correo apoyo familiar</th>
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
                <td>{{$row->telefono}}</td>
                <td>{{$row->activo ? 'Si' : 'No'}}</td>
                <td>{{$row->nom_apo_fam}}</td>
                <td>{{$row->email_apo_fam}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
