<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo Barra</td>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Contado</td>
	<td class="grilla-tab-fila-titulo" align='center'>Diferencias</td>
	<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
	
</tr>

{section name=registrosTI loop=$arrRegistrosTI}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosTI[registrosTI].codigo_barra}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosTI[registrosTI].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosTI[registrosTI].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosTI[registrosTI].cantidad}</td>
	</tr>
		
{/section}

</table>
</div>



