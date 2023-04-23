<div id="pivot">										
<table id='tabla_0' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-campo-pequenio" align="left">
            <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <!-- <tr>
                <td class="grilla-tab-fila-campo-pequenio" align="left">
                    <h2>{$nombre_establecimiento}</h2>
                    <p>{$direccion_establecimiento}</p>
                    <p>R.D.B : {$rbd_establecimiento}</p>
                </td>
            </tr> -->
            </table>
            <table class="grilla-tab" id="tabla_1" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" align='center'>Rut Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>DV Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Apellido Materno Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Nombres Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Nombre Tipo Beca</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Arancel Mensual</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Valor Beca</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Aporte Apoderado</td>
                </tr>
                <!-- {section name=registros loop=$arrRegistros}
                <tr> 
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NumeroRutAlumno}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].DVAlumno}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].PaternoAlumno}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].MaternoAlumno}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NombresAlumno}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NombreCurso}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NombreTipoBeca}</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].valor_mensual}</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].valor_beca}</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].ap_apoderado}</td>
                    
                </tr>
                {/section} -->
            <tr> 
                    <td class="grilla-tab-fila-campo" align='left' colspan="8">Sum. Valor Beca</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$sum_valor_beca}</td>
            </tr>
            <tr>
            	<td colspan='16' class="grilla-tab-fila-titulo">
                    <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
                    <a href="#" style="cursor: hand;" id="btnExport" name="btnExport" onclick="tableToExcel('tabla_0', 'Listado Becados')"><img src="../images/basicos/imprimir.png" border=0 title="Exportar Excel" width="32"></a>
                </td>
            </tr>
            </table>
        </td>
    </tr>
</table>
</div>
