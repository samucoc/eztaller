<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-campo" align='center' colspan="{$total_meses}" >{$trabajador}</td>

</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Mes</td>
	{section name=mes loop=$arrRegistros_mes}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_mes[mes].mes}</td>
	{/section}	
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Provision normal Mensual</td>
	{section name=si loop=$arrRegistros_asig}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_asig[si].asignacion}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Saldo Inicial</td>
	{section name=si loop=$arrRegistros_si}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_si[si].saldo_inicial}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Cargas Normales</td>
	{section name=cn loop=$arrRegistros_cn}
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_cn[cn].carga_normal}</td>		
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Reversa de Consumo</td>
	{section name=devo_carga loop=$arrRegistros_devo_carga}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_devo_carga[devo_carga].devo_carga}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Reversa de Asignacion</td>
	{section name=devo_carga loop=$arrRegistros_devo_carga}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_rev_asig[devo_carga].rev_asig}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Devoluciones de Asignacion</td>
	{section name=devo_asig loop=$arrRegistros_devo_asig}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_devo_asig[devo_asig].devo_asig}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Cargas Normales con Boleta</td>
	{section name=cn loop=$arrRegistros_cn_boleta}
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_cn_boleta[cn].cn_boleta}</td>		
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Disponible</td>
	{section name=disponible loop=$arrRegistros_disponible}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_disponible[disponible].disponible}</td>
	{/section}
</tr>


<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Extra</td>
	{section name=extra loop=$arrRegistros_extra}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_extra[extra].extra}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Extra con Boleta</td>
	{section name=extra_boleta loop=$arrRegistros_extra_boleta}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_extra_boleta[extra_boleta].extra_boleta}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Total Extras</td>
	{section name=total_extra loop=$arrRegistros_total_extra}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_total_extra[total_extra].total_extra}</td>
	{/section}
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Consumo Total Trabajador</td>
	{section name=extra loop=$arrRegistros_ctt}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_ctt[extra].tt}</td>
	{/section}
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Total consumido por copec</td>
	{section name=extra_boleta loop=$arrRegistros_tct}	
		<td class="grilla-tab-fila-campo" align='center' >{$arrRegistros_tct[extra_boleta].cc}</td>
	{/section}
</tr>

<tr>
	<td colspan='{$total_meses+1}' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



