<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Alumno</td>
    	<td class="grilla-tab-fila-titulo-pequenio" colspan="4" align="center">{$nombre_alumno}</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].FechaInasistencia}
            </td>
           
	        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
        </td>
    </tr>
    </table>
</div>