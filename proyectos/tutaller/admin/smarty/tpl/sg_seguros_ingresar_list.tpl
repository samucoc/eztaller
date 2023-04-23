<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='left'>Patente</td>
        <td class="grilla-tab-fila-titulo" align='left'>Nro Poliza</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2">Octubre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Noviembre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Diciembre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Enero</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Febrero</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Marzo</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Abril</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Mayo</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Junio</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Julio</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Agosto</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Septiembre</td>
        <td class="grilla-tab-fila-titulo" align='left'>Total</td>
                <td class="grilla-tab-fila-titulo" align='left'>Vehiculo</td>
                <td class="grilla-tab-fila-titulo" align='left'>A&ntilde;o</td>
                <td class="grilla-tab-fila-titulo" align='left'>Modelo</td>
            </tr>
{section name=registros loop=$arrRegistros}
    <tr>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].patente}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].poliza}</td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),10,'{$arrRegistros[registros].patente}')" {/if}  id="10_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].monto_pagado_oct}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),10,'{$arrRegistros[registros].patente}')" {/if}  id="10_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_oct}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),11,'{$arrRegistros[registros].patente}')" {/if}  id="11_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_nov}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  
       onclick="xajax_Traevalor(xajax.getFormValues('Form1'),11,'{$arrRegistros[registros].patente}')" 
       					{/if}  id="11_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_nov}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),12,'{$arrRegistros[registros].patente}')" {/if}  id="12_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_dic}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  
       onclick="xajax_Traevalor(xajax.getFormValues('Form1'),12,'{$arrRegistros[registros].patente}')" 
       					{/if}  id="12_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_dic}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'><a href="#" {if $arrRegistros[registros].patente!='Totales'} onclick="xajax_Traevalor(xajax.getFormValues('Form1'),1,'{$arrRegistros[registros].patente}')" {/if} id="1_{$arrRegistros[registros].patente}">{$arrRegistros[registros].monto_pagado_ene}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),1,'{$arrRegistros[registros].patente}')" {/if}  id="1_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_ene}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'><a href="#" {if $arrRegistros[registros].patente!='Totales'} onclick="xajax_Traevalor(xajax.getFormValues('Form1'),2,'{$arrRegistros[registros].patente}')" {/if}  id="2_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_feb} </a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),2,'{$arrRegistros[registros].patente}')" {/if}  id="2_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_feb}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),3,'{$arrRegistros[registros].patente}')" {/if}  id="3_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_mar}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),3,'{$arrRegistros[registros].patente}')" {/if}  id="3_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_mar}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#"  {if $arrRegistros[registros].patente!='Totales'} onclick="xajax_Traevalor(xajax.getFormValues('Form1'),4,'{$arrRegistros[registros].patente}')" {/if}  id="4_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_abr}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),4,'{$arrRegistros[registros].patente}')" {/if}  id="4_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_abr}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#"  {if $arrRegistros[registros].patente!='Totales'} onclick="xajax_Traevalor(xajax.getFormValues('Form1'),5,'{$arrRegistros[registros].patente}')" {/if}  id="5_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_may}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),5,'{$arrRegistros[registros].patente}')" {/if}  id="5_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_may}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),6,'{$arrRegistros[registros].patente}')" {/if}  id="6_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_jun}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),6,'{$arrRegistros[registros].patente}')" {/if}  id="6_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_jun}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),7,'{$arrRegistros[registros].patente}')" {/if}  id="7_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_jul}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),7,'{$arrRegistros[registros].patente}')" {/if}  id="7_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_jul}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),8,'{$arrRegistros[registros].patente}')" {/if}  id="8_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_ago}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),8,'{$arrRegistros[registros].patente}')" {/if}  id="8_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_ago}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" {if $arrRegistros[registros].patente!='Totales'}   onclick="xajax_Traevalor(xajax.getFormValues('Form1'),9,'{$arrRegistros[registros].patente}')" {/if}  id="9_{$arrRegistros[registros].patente}">	{$arrRegistros[registros].monto_pagado_sep}</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" {if $arrRegistros[registros].patente!='Totales'}  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),9,'{$arrRegistros[registros].patente}')" {/if}  id="9_{$arrRegistros[registros].patente}">	
				{$arrRegistros[registros].factura_sep}
			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].total}</td>
		        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].vehiculo}</td>
		        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].anio}</td>
		        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].modelo}</td>
	</tr>
{/section}
<tr>
	<td colspan='32' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


