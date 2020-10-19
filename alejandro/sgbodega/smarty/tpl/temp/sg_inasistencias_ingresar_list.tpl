<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			{$periodo}
		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			{$curso}
		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Mes
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			{$mes}
		</td>
	</tr>
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
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="10%">
			{if $arrRegistros[registros].fecha_retiro != '0000-00-00'}
				<strike>
				{$arrRegistros[registros].numero_lista}
				</strike>
			{else}
				{$arrRegistros[registros].numero_lista}
			{/if}
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="20%">
			{if $arrRegistros[registros].fecha_retiro != '0000-00-00'}
				<strike>
				{$arrRegistros[registros].nombre_alumno}
				</strike>
			{else}
				{$arrRegistros[registros].nombre_alumno}
			{/if}
		</td>
		{section name=registrosDetalle loop=$arrRegistrosDetalle}
        	{if ($arrRegistrosDetalle[registrosDetalle].rut_alumno == $arrRegistros[registros].rut_alumno)&&
        		($arrRegistrosDetalle[registrosDetalle].nro_lista == $arrRegistros[registros].numero_lista)}
                {if $arrRegistrosDetalle[registrosDetalle].domingo == 'SI' || $arrRegistrosDetalle[registrosDetalle].festivo == 'SI' }
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#ffcccc">
                    </td>
                {else}
                    {if $arrRegistrosDetalle[registrosDetalle].atraso == 'SI'}
                    	{if $arrRegistros[registros].fecha_retiro != '0000-00-00'}
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
		                		<strike>
		                    	X
		                    	</strike>
		                    </td>
						{else}
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px"  onclick="xajax_EliminarInasistencia(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].rut_alumno}','{$arrRegistrosDetalle[registrosDetalle].fecha}');" >
		                    	X
		                    </td>
						{/if}
                    {else}
	                    {if $arrRegistrosDetalle[registrosDetalle].cont_atraso > 0}
	                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
	                    	{$arrRegistrosDetalle[registrosDetalle].cont_atraso}
	                    </td>
	                    {else}
	                    	{if $arrRegistros[registros].fecha_retiro != '0000-00-00'}
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
	                    		</td>							
	                    	{else}
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].rut_alumno}','{$arrRegistrosDetalle[registrosDetalle].fecha}');">
			                    </td>
	                    	{/if}
	                    
	                    {/if}
                    {/if}
                {/if}
            {/if}
        {/section}
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			{$arrRegistros[registros].contador}
        </td>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			{$arrRegistros[registros].porcentaje}
        </td>
		<td class="grilla-tab-fila-campo-pequenio" align='center' width="10px" height="10px">
			{if $arrRegistros[registros].rut_alumno == '0000000'}
			{else}
				{if $arrRegistros[registros].porcentaje < '85'}
					<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
				{elseif (($arrRegistros[registros].porcentaje >= '85')&&($arrRegistros[registros].porcentaje <= '90'))}
					<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
				{else}
					<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
				{/if}
			{/if}
		</td>
        
	</tr>
{/section}
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		{section name=dias loop=$arrDias}
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			{$arrDias[dias].nro_dia}
		</td>
        {/section}
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Presentes</td>
		{section name=presente loop=$arrPresentes}
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			{$arrPresentes[presente].cantidad}
		</td>
        {/section}
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Ausentes</td>
		{section name=ausente loop=$arrAusentes}
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			{$arrAusentes[ausente].cantidad}
		</td>
        {/section}
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Matricula</td>
		{section name=matricula loop=$arrMatricula}
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			{$arrMatricula[matricula].cantidad}
		</td>
        {/section}
	</tr>
    
<tr>
	<td colspan="{$cant_dias+5}" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>
