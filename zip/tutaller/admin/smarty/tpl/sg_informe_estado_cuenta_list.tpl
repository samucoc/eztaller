<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
{section name=registros loop=$arrRegistros}
    {if $arrRegistros[registros].desc!=''}
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Empresa</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" >{$arrRegistros[registros].desc}</td>
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Tipo Compra Combustible</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" >{$arrRegistros[registros].boleta}</td>
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Periodo</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" >{$arrRegistros[registros].mes} - {$arrRegistros[registros].anio}</td>
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
        <tr>
            <td class="grilla-tab-fila-campo" align='center' width="20%" ></td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >93</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >95</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >97</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >PD</td>
        </tr>
            {section name=detalle loop=$arrRegistros_detalle}
        		{if $arrRegistros[registros].rut_empresa == $arrRegistros_detalle[detalle].empresa}
                <tr>
                    <td class="grilla-tab-fila-campo" 
                    	{if $arrRegistros_detalle[detalle].tipo == 'Totales'}
                    	
                    	{/if}
                    align='left'>
						{$arrRegistros_detalle[detalle].tipo}
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	{if $arrRegistros_detalle[detalle].tipo == 'Totales'}
                    	
                    	{/if}
                    align='left'>
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
    	                    <a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo={$arrRegistros_detalle[detalle].tipo}&depto={$arrRegistros_detalle[detalle].depto}&empresa={$arrRegistros_detalle[detalle].empresa}&octanaje=93&inicio={$arrRegistros_detalle[detalle].inicio}&fin={$arrRegistros_detalle[detalle].fin}', 'Muestra Detalle', 800, 600, null);">
                        {/if}
                        {$arrRegistros_detalle[detalle].primero}
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
	                        </a>
                        {/if}
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	{if $arrRegistros_detalle[detalle].tipo == 'Totales'}
                    	
                    	{/if}
                    align='left'>
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
	                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo={$arrRegistros_detalle[detalle].tipo}&depto={$arrRegistros_detalle[detalle].depto}&empresa={$arrRegistros_detalle[detalle].empresa}&octanaje=95&inicio={$arrRegistros_detalle[detalle].inicio}&fin={$arrRegistros_detalle[detalle].fin}', 'Muestra Detalle', 800, 600, null);">
						{/if}
						{$arrRegistros_detalle[detalle].segundo}
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
                        	</a>
						{/if}
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	{if $arrRegistros_detalle[detalle].tipo == 'Totales'}
                    	
                    	{/if}
                    align='left'>
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo={$arrRegistros_detalle[detalle].tipo}&depto={$arrRegistros_detalle[detalle].depto}&empresa={$arrRegistros_detalle[detalle].empresa}&octanaje=97&inicio={$arrRegistros_detalle[detalle].inicio}&fin={$arrRegistros_detalle[detalle].fin}', 'Muestra Detalle', 800, 600, null);">
						{/if}
						{$arrRegistros_detalle[detalle].tercero}
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
                        	</a>
						{/if}
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	{if $arrRegistros_detalle[detalle].tipo == 'Totales'}
                    	
                    	{/if}
                    align='left'>
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo={$arrRegistros_detalle[detalle].tipo}&depto={$arrRegistros_detalle[detalle].depto}&empresa={$arrRegistros_detalle[detalle].empresa}&octanaje=PD&inicio={$arrRegistros_detalle[detalle].inicio}&fin={$arrRegistros_detalle[detalle].fin}', 'Muestra Detalle', 800, 600, null);">
						{/if}
						{$arrRegistros_detalle[detalle].cuarto}
                    	{if $arrRegistros_detalle[detalle].tipo != 'Totales'}
                        	</a>
						{/if}
                    </td>
                </tr>
		        {/if}
            {/section}
	{/if}
{/section}

<tr>
    <td colspan='16' class="grilla-tab-fila-titulo">
        <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
        <!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">-->
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto; text-align: center;"></iframe>
    </td>
</tr>
</table>
</div>



