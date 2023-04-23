<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Mar
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Abr
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			May
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jun
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jul
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Ago
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Sep
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Oct
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Nov
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Dic
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Total
		</td>
	</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].nombre_curso}
		</td>
		{section name=registrosDetalle loop=$arrRegistrosDetalle}
        	{if $arrRegistrosDetalle[registrosDetalle].curso == $arrRegistros[registros].curso}
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].marzo}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].abril}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].mayo}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].junio}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].julio}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].agosto}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].septiembre}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].octubre}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].noviembre}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].diciembre}
                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		{$arrRegistrosDetalle[registrosDetalle].total}
                </td>
            {/if}
        {/section}
	</tr>
{/section}
<tr>
	<td colspan="{$cant_dias+3}" class="grilla-tab-fila-titulo">
      <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_resumen_inasistencias.php?anio={$anio}', 'Grafico Resumen Inasistencias Colegio', 1440, 650, null);" class="btn btn-primary text-center align-middle" title="Grafico Resumen Inasistencias Colegio">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	{if $curso!=''}
    	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_curso_resumen_inasistencias.php?anio={$anio}&curso={$curso}', 'Grafico Resumen Inasistencias Curso', 750, 650, null);" class="btn btn-primary text-center align-middle " title="Grafico Resumen Inasistencias Curso">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	{/if}
    </td>
</tr>
</table>
