<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
    		Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Porcentaje
        </td>
    </tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].curso}
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].porcentaje}
		</td>
		<td class="grilla-tab-fila-campo-pequenio">
			{if $arrRegistros[registros].porcentaje < '85'}
				<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
			{elseif (($arrRegistros[registros].porcentaje >= '85')&&($arrRegistros[registros].porcentaje <= '90'))}
				<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
			{else}
				<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
			{/if}
		</td>
	</tr>
{/section}
<tr>
	<td colspan="{$cant_dias+3}" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Grafico" onclick="showPopWin('sg_informe_porcentaje_asistencia_grafico.php?anio={$anio}&periodo={$periodo}', 'Grafico', 1200, 300, null);" width="32"></a>
	</td>
</tr>
</table>
