<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			{$periodo}
		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			{$curso}
		</td>
	</tr>
		{section name=alumnos loop=$arrAlumnos}
		<tr>
       		<td class='grilla-tab-fila-campo-pequenio' align='left' style="width: 20%;">
       			{$arrAlumnos[alumnos].nombre_alumno}
            </td>
			{section name=registrosDetalle loop=$arrRegistrosDetalle}
				{section name=registros loop=$arrRegistros}
					{if ($arrRegistrosDetalle[registrosDetalle].fecha == $arrRegistros[registros].fecha) && 
						($arrRegistrosDetalle[registrosDetalle].rut_alumno == $arrAlumnos[alumnos].rut_alumno) 
						}
						{if $arrRegistrosDetalle[registrosDetalle].rut_alumno == '-----'}
						<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
							{if $arrRegistros[registros].fecha=='promedio'}
								Porc. Asistencia
							{else}
								<a href="#" title="{$arrRegistros[registros].title}">{$arrRegistros[registros].fecha|date_format:'%d/%m/%Y'}</a>
							{/if}
	                    </td>
						{else}
	             		<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].rut_alumno}','{$arrRegistrosDetalle[registrosDetalle].fecha}');">
	             			{$arrRegistrosDetalle[registrosDetalle].checked}
	                    </td>
	                    {/if}
		            {/if}
		        {/section}
			{/section}
		</tr>
		{/section}
<tr>
	<td colspan="{$cant_dias+5}" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>
