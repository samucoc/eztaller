<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Nro Lista
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Alumno
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="{$cant_dias}">
			Fecha
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Total
		</td>
	</tr>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		{section name=dias loop=$arrDias}
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrDias[dias].nro_dia}
		</td>
        {/section}
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].numero_lista}
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].nombre_alumno}
		</td>
		{section name=registrosDetalle loop=$arrRegistrosDetalle}
        	{if $arrRegistrosDetalle[registrosDetalle].rut_alumno == $arrRegistros[registros].rut_alumno}
                {if $arrRegistrosDetalle[registrosDetalle].domingo == 'SI' || $arrRegistrosDetalle[registrosDetalle].festivo == 'SI' }
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#F00">
                    </td>
                {else}
                    {if $arrRegistrosDetalle[registrosDetalle].atraso == 'SI'}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_EliminarAtraso(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].rut_alumno}','{$arrRegistrosDetalle[registrosDetalle].fecha}');" >
                    X
                    </td>
                    {else}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_ConfirmarAtraso(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].rut_alumno}','{$arrRegistrosDetalle[registrosDetalle].fecha}');">
                    </td>
                    {/if}
                {/if}
            {/if}
        {/section}
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			{$arrRegistros[registros].contador}
        </td>
	</tr>
{/section}
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		{section name=dias loop=$arrDias}
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrDias[dias].nro_dia}
		</td>
        {/section}
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
<tr>
	<td colspan="{$cant_dias+3}" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
	</td>
</tr>
</table>
