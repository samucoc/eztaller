<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo" align="center">Fecha Boleta</td>
        <td class="grilla-tab-fila-titulo" align="center">Numero Boleta</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].NumeroRutAlumno}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].alumno}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].curso}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].FechaBoleta}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].NumeroBoleta}</a>
            </td>
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" onclick="ImprimeDiv('divabonos');">
                <img src='../images/basicos/imprimir.png' title='Imprimir' width="32"/>
            </a>
            <a href="#" onclick="exportToExcel('divabonos');">
                <img src='../images/basicos/imprimir.png' title='Exportar a Excel' width="32"/>
            </a>
        </td>
    </tr>
    </table>
</div>
