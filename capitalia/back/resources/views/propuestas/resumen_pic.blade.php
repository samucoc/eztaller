<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table border="1" width="100%">
        <tbody>
            <tr>
                <td colspan="7">RESUMEN PROPUESTA COMUNAL</td>
            </tr>
            <tr>
                <td>Ejecutor:</td>
                <td>{{$convocatoria['ejecutor']}}</td>
                <td>Ejecutor Encargado:</td>
                <td>{{$convocatoria['nombre_enc_ejec']}}</td>
                <td rowspan="2">Encargado/a Programa SEREMI:</td>
                <td rowspan="2">{{$convocatoria['nombre_enc_prog_seremi']}}</td>
                <td rowspan="3">FOSIS - MDSF {{$convocatoria['anio']}}</td>
            </tr>
            <tr>
                <td>Comuna:</td>
                <td>{{$convocatoria['comuna'] }}</td>
                <td>Ejecutor Constructivo:</td>
                <td>{{$convocatoria['nombre_ejec_const']}}</td>
            </tr>
            <tr>
                <td>Región:</td>
                <td>{{$convocatoria['region'] }}</td>
                <td>Ejecutor Social:</td>
                <td>{{$convocatoria['nombre_ejec_social']}}</td>
                <td>ATE FOSIS:</td>
                <td>{{$convocatoria['nombre_ate_fosis']}}</td>
            </tr>
            <!-- <tr>
            <td colspan="4">1. LISTADO BENEFICIARIOS</td>
            <td>1.1 COSTOS ESTIMADOS</td>
            <td>1.2 RECURSOS INVERTIDOS POR FAMILIA</td>
            <td>1.3 ASESORIAS A REALIZAR SEGÚN TEMÁTICA</td>
        </tr>
        <tr>
            <td>N</td>
            <td>Beneficiario/a</td>
            <td>Dirección</td>
            <td>Programa Origen</td>
        </tr>
        <tr>
            <td>N</td>
            <td>Beneficiario/a</td>
            <td>Dirección</td>
            <td>Programa Origen</td>
        </tr> -->
        </tbody>
    </table>
    <table border="1" width="100%">
        <tr>
            <td rowspan="2">N</td>
            <td rowspan="2">Beneficiario/a</td>
            <td rowspan="2">Dirección</td>
            <td rowspan="2">Programa Origen</td>
            @foreach($sub_componentes as $row)
            <td colspan="{{count($row['soluciones'])}}">{{ $row['sub_componente'] }}</td>
            @endforeach
            <td rowspan="2">Inversión MDSF</td>
            <td rowspan="2">Aportes Locales</td>
            <td rowspan="2">Aportes de Otros</td>
            <td rowspan="2">Total inversión por familia</td>
            @foreach($sub_componentes as $row)
            <td colspan="2">{{ $row['sub_componente'] }}</td>
            @endforeach
        </tr>
        <tr>
            @foreach($sub_componentes as $sub_componente)
            @foreach($sub_componente['soluciones'] as $row)
            <td>{{ trim(substr($row['descripcion'],strpos($row['descripcion'],'-')+1)) }}</td>
            @endforeach
            @endforeach
            @foreach($sub_componentes as $row)
            <td>Grupal</td>
            <td>Familiar</td>
            @endforeach
        </tr>
        @foreach($beneficiarios as $key => $row)
        <tr>
            <td>
                {{ $row['numero'] }}
            </td>
            <td>
                {{ $row['nom_benef'] }}
            </td>
            <td>
                {{ $row['direccion'] }}
            </td>
            <td>
                {{ strtoupper($row['nom_programa']) }}
            </td>
            @foreach($row['soluciones'] as $_row)
            <td>{{$_row}}</td>
            @endforeach
            <td>
                {{ strtoupper($row['monto_aporte_mds']) }}
            </td>
            <td>
                {{ strtoupper($row['monto_aporte_local']) }}
            </td>
            <td>
                {{ strtoupper($row['monto_aporte_otros']) }}
            </td>
            <td>
                {{ strtoupper($row['monto_aporte_total']) }}
            </td>
            @foreach($row['asesorias'] as $_row)
            <td>{{$_row['grupal']}}</td>
            <td>{{$_row['familiar']}}</td>
            @endforeach
        </tr>
        @endforeach
        <tr>
            <td colspan="4">Costo Total por Solución</td>
            @foreach($total_soluciones as $_row)
            <td>{{$_row}}</td>
            @endforeach
            @foreach($total_aportes as $_row)
            <td>{{$_row}}</td>
            @endforeach
            @foreach($total_asesorias as $_row)
            <td>{{$_row['grupal']}}</td>
            <td>{{$_row['familiar']}}</td>
            @endforeach
        </tr>
        <tr>
            <td colspan="4">Costo Promedio por Solución</td>
            @foreach($prom_soluciones as $_row)
            <td>{{$_row}}</td>
            @endforeach
        </tr>
        <tr>
            <td colspan="4">Nº Soluciones</td>
            @foreach($cant_soluciones as $_row)
            <td>{{$_row}}</td>
            @endforeach
        </tr>
        <tr>
            <td colspan="4">Costo Mínimo Solución</td>
            @foreach($aux_soluciones as $_row)
            <td>{{min($_row)}}</td>
            @endforeach
        </tr>
        <tr>
            <td colspan="4">Costo Máximo Solución</td>
            @foreach($aux_soluciones as $_row)
            <td>{{max($_row)}}</td>
            @endforeach
        </tr>
    </table>
    <table border="1" width="100%">
        <tr>
            <td rowspan="2">Tipo asesoría</td>
            <td colspan="2">ASESORÍAS GRUPALES</td>
            <td colspan="2">ASESORÍAS FAMILIARES</td>
        </tr>
        <tr>
            <td>Nº asesorías grupales</td>
            <td>Total familias a convocar</td>
            <td>Nº asesorías familiares</td>
            <td>Total familias a convocar</td>
            <td>Total Asesorías</td>
        </tr>
        <?php
        $t_ase_grupales = 0;
        $t_fam_con_grupales = 0;
        $t_ase_familiares = 0;
        $t_fam_con_familiares = 0;
        $t_total = 0;
        ?>
        @foreach($resumen_asesorias as $row)
        <tr>
            <td>{{ $row->tipo_asesoria }}</td>
            <td>{{ $row->ase_grupales }}</td>
            <td>{{ $row->fam_con_grupales }}</td>
            <td>{{ $row->ase_familiares }}</td>
            <td>{{ $row->fam_con_familiares }}</td>
            <td>{{ $row->total }}</td>
        </tr>
        <?php
        $t_ase_grupales += $row->ase_grupales;
        $t_fam_con_grupales += $row->fam_con_grupales;
        $t_ase_familiares += $row->ase_familiares;
        $t_total += $row->total;
        ?>
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{$t_ase_grupales}}</td>
            <td>{{$t_fam_con_grupales}}</td>
            <td>{{$t_ase_familiares}}</td>
            <td>{{$t_fam_con_familiares}}</td>
            <td>{{$t_total}}</td>
        </tr>
    </table>
</body>

</html>