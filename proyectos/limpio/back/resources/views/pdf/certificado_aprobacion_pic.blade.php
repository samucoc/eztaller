<html>

<head>
    <style>
        * {
            font-family: sans-serif;
            font-size: 14px;
        }

        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        p {
            line-height: 25px;
            text-align: justify;
        }

        @page {
            /* margin: 0cm 0cm; */
            margin-left: 2cm;
            margin-right: 2cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-bottom: 4cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            margin: 0px;
        }

        header .logo {
            height: 98%;
            margin: 0px;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        img {
            display: block !important;
        }

        .table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
        }

        .table-signs td {
            width: 33.33% !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-12 {
            font-size: 12px;
        }
    </style>
    <title>{{$titulo}}</title>
</head>

<body>
    <header>
        <img class="logo" src="{{ public_path('/img/logo-mdsf.jpg') }}" />
    </header>
    <main>
        <p class="text-center">
            <strong>APROBACIÓN PROYECTO DE INTERVENCIÓN COMUNAL<br>PROGRAMA HABITABILIDAD</strong>
        </p>
        <p><strong>Convocatoria año {{$convocatoria->anio}}</strong></p>
        <p><strong>Proyecto de la comuna {{$convocatoria->comuna}}</strong></p>
        <p>
            Con Fecha XX de XXXXXX de 20XX se aprobó a través del Sistema Informático del Programa Habitabilidad,
            el Proyecto de Intervención Comunal de {{$convocatoria->comuna}}, convocatoria {{$convocatoria->anio}}.
        </p>
        <p>
            El PIC aprobado considera las familias y plan de intervención que se resumen en la tabla
            a continuación:
        </p>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-right">N</th>
                    <th>Familia</th>
                    <th class="text-center">Asesorías<br>Familiares</th>
                    <th class="text-center">Asesorías<br>Grupales</th>
                    <th class="text-center">Soluciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $row)
                <tr>
                    <td class="text-right">{{ $row->numero }}</td>
                    <td>{{ $row->nom_benef }}</td>
                    <td class="text-center">{{ $row->ase_fam }}</td>
                    <td class="text-center">{{ $row->ase_gru }}</td>
                    <td class="text-center">{{ $row->soluciones }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    <footer>
        <table class="table table-signs">
            <tr>
                <td>Visado técnicamente por:</td>
                <td>NOMBRE</td>
                <td>Fecha</td>
            </tr>
            <tr>
                <td>Aprobado por:</td>
                <td>NOMBRE</td>
                <td>Fecha</td>
            </tr>
        </table>
        <p class="text-color-gray text-12">
            Sistema Informático Programa Habitabilidad
            <!-- (algunos sistemas, cuando entregan certificados, tienen un pie de página que entrega la fuente de información, hora y fecha de la extracción, podríamos ponerlo pero desconozco el formato tipo) -->
            <br>Fecha de emisión: {{date('d-m-Y H:i:s') }}
        </p>
    </footer>
</body>

</html>