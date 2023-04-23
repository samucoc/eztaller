<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <style>
        html, body {
            font-family: 'Raleway', sans-serif;
            font-size: x-small;
        }
        * {
            padding: 0;
            margin: 0;
            color: #474747;

        }

        .contenedor-principal {
            width: 100%;
            background: red;
            /* max-width: 18cm; */
            /*margin: 0 auto;*/
        }

        .row {
            display: table;
            width: calc(100% - 70px);
            padding: 0 35px;
        }

        .p25 {
            /*display: table-cell;*/
            /*width: 25%;*/
            /*padding-bottom: 8px;*/
        }

        .p33 {
            display: table-cell;
            width: 33%;
            padding-bottom: 8px;
        }

        .p33:last-child {
            width: 34%;
            padding-bottom: 8px;
        }

        .p50 {
            display: table-cell;
            width: 50%;
            padding-bottom: 8px;
        }

        input {
            border: none;
            border-bottom: 2px solid #767676;
            margin-top: 6px;
            margin-bottom: 8px;
            width: 100%;
        }

        .border-general {
            border: 1px solid #767676;
            margin: 15px;
            padding: 10px 0px 10px 0px;
        }

        .boderBottom {
            border-bottom: 1px solid #767676;
        }

        .marginCabecera {
            margin-left: 35px;
        }

        h3 {
            padding-top: 15px;
        }

        h2 {
            padding-top: 3px;
            padding-bottom: 2px;
            padding-left: 20px;
        }
        .table-encabezado{
            width: 100%;
            margin: 15px;
            padding: 10px 0px 10px 0px;
        }

        tr>td{
            padding: 0 5px 0 7px;
        }
    </style>
</head>

<body>

<h1 class="marginCabecera">Convocatorias</h1>
<br>
@forelse($convocatorias as $index => $conv)
    <table style="width: 100%">
        <tr>
            <td>
                <table style="width: 100%; margin: 15px; padding: 10px 0px 10px 0px;">
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 140px">Año de convocatoria</td>
                                    <td style="width: 200px">Región</td>
                                    <td class="p25">Comuna</td>
                                </tr>
                                <tr>
                                    <td class="p25"><input type="text" value="{{ $conv->anio }}"></td>
                                    <td class="p25"><input type="text" value="{{ $conv->comunas[0]->nom_reg }}"></td>
                                    <?php
                                    $comunas = [];
                                    foreach ($conv->comunas as $comuna)
                                        $comunas[] = $comuna->nom_com;
                                    ?>
                                    <td class="p25"><input type="text" value="{{ implode(" / ", $comunas) }}"></td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 250px">Estado de convocatoria</td>
                                    <td style="width: 400px">Observación</td>
                                </tr>
                                <tr>
                                    <td class="p25"><input type="text" value="{{ $conv->estado->nombre }}"></td>
                                    <td class="p25"><input type="text" value="{{ $conv->observacion }}"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%" class="border-general">
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h2>Institución ejecutora</h2>
                                    </td>
                                </tr>
                                <tr >
                                    <td>Nombre</td>
                                    <td>RUT</td>
                                    <td>Teléfono</td>
                                    <td>Dirección</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->ejecutor }}"></td>
                                    <td><input type="text" value="{{ $conv->rut_ejecutor }}"></td>
                                    <td><input type="text" value="{{ $conv->fono_ejecutor }}"></td>
                                    <td><input type="text" value="{{ $conv->direccion_ejecutor }}"></td>
                                </tr>
                                <tr>
                                    <td>Estado del SIGEC</td>
                                    <td>Fecha de transferencia</td>
                                    <td>Fecha de término</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->estado_sigec }}"></td>
                                    <td><input type="text" value="{{ date_format(date_create($conv->fecha_transferencia), 'd-m-Y') }}"></td>
                                    <td><input type="text" value="{{  date_format(date_create($conv->fecha_termino), 'd-m-Y') }}"></td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h2>Equipo ejecutor</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3>Coordinador </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">RUT</td>
                                    <td>Nombre</td>
                                    <td>E-mail</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->rut_enc_ejec }}"></td>
                                    <td><input type="text" value="{{ $conv->nombre_enc_ejec }}"></td>
                                    <td><input type="text" value="{{ $conv->email_enc_ejec }}"></td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h3>Profesional constructivo </h3>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 200px">RUT</td>
                                    <td>Nombre</td>
                                    <td>E-mail</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->rut_ejec_const }}"></td>
                                    <td><input type="text" value="{{ $conv->nombre_ejec_const }}"></td>
                                    <td><input type="text" value="{{ $conv->email_ejec_const }}"></td>
                                </tr>
                                <tr>
                                    <td>Profesión</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->profesion_ejec_const }}"></td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h3>Profesional social </h3>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 200px">RUT</td>
                                    <td>Nombre</td>
                                    <td>E-mail</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->rut_ejec_social }}"></td>
                                    <td><input type="text" value="{{ $conv->nombre_ejec_social }}"></td>
                                    <td><input type="text" value="{{ $conv->email_ejec_social }}"></td>
                                </tr>
                                <tr>
                                    <td>Profesión</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->profesion_ejec_social }}"></td>
                                </tr>
                            </table>

                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h2>Equipo supervisor regional</h2>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h3>Encargado prog. Seremi</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">RUT</td>
                                    <td>Nombre</td>
                                    <td>E-mail</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->rut_enc_prog_seremi }}"></td>
                                    <td><input type="text" value="{{ $conv->nombre_enc_prog_seremi }}"></td>
                                    <td><input type="text" value="{{ $conv->email_enc_prog_seremi }}"></td>
                                </tr>
                            </table>

                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <h3>ATE fosis</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 200px">RUT</td>
                                    <td>Nombre</td>
                                    <td>E-mail</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="{{ $conv->rut_ate_fosis }}"></td>
                                    <td><input type="text" value="{{ $conv->nombre_ate_fosis }}"></td>
                                    <td><input type="text" value="{{ $conv->email_ate_fosis }}"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- SALTO DE PAGINA -->
    @if($index < count($convocatorias)-1)
        <div style="page-break-after:always;"></div>
    @endif
@empty
    <label>No existen registros</label>
@endforelse

</body>
</html>