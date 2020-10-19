<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Alumno</td>
    	<td class="grilla-tab-fila-titulo-pequenio" colspan="{$notas_ingresadas+1}" align="center">{$nombre_alumno}</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Semestre</td>
    	<td class="grilla-tab-fila-titulo-pequenio" colspan="{$notas_ingresadas+1}"  align="center">{$nombre_semestre}</td>
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Asignatura</td>
        {section name=cu start=0 step=1 loop=$notas_ingresadas}
		   	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				N-{$smarty.section.cu.index+1}
            </td>
        {/section}
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
            </td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_asignatura}
            </td>
            {section name=registrosDetalle loop=$arrRegistrosDetalle}
                {if $arrRegistros[registros].codigo_asignatura == $arrRegistrosDetalle[registrosDetalle].codigo_asignatura}
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        	{if $arrRegistrosDetalle[registrosDetalle].nota < 4}
                            <div style="color:#FF0000">                
                                {$arrRegistrosDetalle[registrosDetalle].nota}
                            </div>
                            {else}
                                {$arrRegistrosDetalle[registrosDetalle].nota}
                            {/if}
                        </td>
                {/if}
            {/section}
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');;">
        </td>
    </tr>
    </table>
</div>