<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<!--
<tr>
	<td class="grilla-tab-fila-titulo" align='center' >Quincena</td>
	<td class="grilla-tab-fila-titulo" align='center' >{$quincena}</td>
</tr>
-->
<tr>
	<td class="grilla-tab-fila-titulo" align='center' >Trabajador</td>
	<td class="grilla-tab-fila-titulo" align='center' >Patente</td>
	<td class="grilla-tab-fila-titulo" align='center' >Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center' >Departamento</td>
	<td class="grilla-tab-fila-titulo" align='center' >Producto</td>
	<td class="grilla-tab-fila-titulo" align='center' >Asignado</td>
	<td class="grilla-tab-fila-titulo" align='center' >Disponible Quincena</td>
</tr>
	{section name=mes loop=$arrRegistros}	
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>{$arrRegistros[mes].trabajador}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].patente}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].empresa}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].depto}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].producto}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].asignacion}</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[mes].disponible}</td>

</tr>
	{/section}	

<tr>
	<td colspan='2' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



