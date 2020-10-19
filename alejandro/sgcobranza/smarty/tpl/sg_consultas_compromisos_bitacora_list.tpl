<div id="pivot">										
<table id='tabla_0' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-campo-pequenio" align="left">
            <table class="grilla-tab" id="tabla_1" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Direccion Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Telefono Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Email</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Fecha Compromiso</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Descripcion Compromiso</td>
                </tr>
                {section name=registros loop=$arrRegistros}
                        <tr> 
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].apoderado}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].direccion_apoderado}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].telefono_apoderado}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].email}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].alumno}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha_compromiso}</td>
                            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion_compromiso}</td>
                        </tr>
                {/section}
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
