<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
{section name=registros loop=$arrRegistros}
    {if $arrRegistros[registros].desc!=''}
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Empresa</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" >{$arrRegistros[registros].desc}</td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
            
    </tr>
        <tr>
            <td class="grilla-tab-fila-campo" align='center' ></td>
            <td class="grilla-tab-fila-campo" align='center' >93</td>
            <td class="grilla-tab-fila-campo" align='center' >95</td>
            <td class="grilla-tab-fila-campo" align='center' >97</td>
            <td class="grilla-tab-fila-campo" align='center' >DIESEL</td>
        </tr>
            {section name=detalle loop=$arrRegistros_detalle}
        		{if $arrRegistros[registros].rut_empresa == $arrRegistros_detalle[detalle].empresa}
                <tr>
                    <td 
                    	{if (($arrRegistros_detalle[detalle].tipo_corto == 'presupuesto')||($arrRegistros_detalle[detalle].tipo_corto=='diferencia'))}
                    		class="grilla-tab-fila-titulo" style="font-weight:bolder"
                        {else}
                    		class="grilla-tab-fila-campo" 
                         {/if}
                        align='left'>{$arrRegistros_detalle[detalle].tipo}</td>
                    <td 
                    	{if (($arrRegistros_detalle[detalle].tipo_corto == 'presupuesto')||($arrRegistros_detalle[detalle].tipo_corto=='diferencia'))}
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        {else}
                    		class="grilla-tab-fila-campo" 
                         {/if}
                        align='right'>
                        {if $arrRegistros_detalle[detalle].tipo_corto == 'extras'}
                            <input type="text" name="t_{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_93_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].primero}"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						{else}
                        	<label id="lbl_{$arrRegistros_detalle[detalle].tipo_corto}_93_{$arrRegistros[registros].rut_empresa}">{$arrRegistros_detalle[detalle].primero}</label>
                            <input type="hidden" name="t_{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_93_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].primero}"  />
                        {/if}
                    </td>
                    <td 
                    	{if (($arrRegistros_detalle[detalle].tipo_corto == 'presupuesto')||($arrRegistros_detalle[detalle].tipo_corto=='diferencia'))}
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        {else}
                    		class="grilla-tab-fila-campo" 
                         {/if}
                        align='right'>
                        {if $arrRegistros_detalle[detalle].tipo_corto == 'extras'}
                        	<input type="text" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_95_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].segundo}"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						{else}
                        	<label id="lbl_{$arrRegistros_detalle[detalle].tipo_corto}_95_{$arrRegistros[registros].rut_empresa}">{$arrRegistros_detalle[detalle].segundo}</label>
                            <input type="hidden" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_95_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].segundo}"  />
                        {/if}
                    </td>
                    <td 
                    	{if (($arrRegistros_detalle[detalle].tipo_corto == 'presupuesto')||($arrRegistros_detalle[detalle].tipo_corto=='diferencia'))}
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        {else}
                    		class="grilla-tab-fila-campo" 
                         {/if}
                        align='right'>
                        {if $arrRegistros_detalle[detalle].tipo_corto == 'extras'}
                        	<input type="text" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_97_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].tercero}" style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						{else}
                        	<label id="lbl_{$arrRegistros_detalle[detalle].tipo_corto}_97_{$arrRegistros[registros].rut_empresa}">{$arrRegistros_detalle[detalle].tercero}</label>
                            <input type="hidden" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_97_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].tercero}"  />
                        {/if}
                    </td>
                    <td 
                    	{if (($arrRegistros_detalle[detalle].tipo_corto == 'presupuesto')||($arrRegistros_detalle[detalle].tipo_corto=='diferencia'))}
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        {else}
                    		class="grilla-tab-fila-campo" 
                         {/if}
                        align='right'>
                        {if $arrRegistros_detalle[detalle].tipo_corto == 'extras'}
                        	<input type="text" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_DIESEL_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].cuarto}"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
                        {else}
                        	<label id="lbl_{$arrRegistros_detalle[detalle].tipo_corto}_DIESEL_{$arrRegistros[registros].rut_empresa}">{$arrRegistros_detalle[detalle].cuarto}</label>
                            <input type="hidden" name="{$arrRegistros_detalle[detalle].tipo_corto}[]" class="cambio_{$arrRegistros_detalle[detalle].tipo_corto}" id="txt_{$arrRegistros_detalle[detalle].tipo_corto}_DIESEL_{$arrRegistros[registros].rut_empresa}" value="{$arrRegistros_detalle[detalle].cuarto}"  />
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
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



