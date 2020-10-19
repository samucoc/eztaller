<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].nro_lista_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            {section name=registrosDetalle loop=$arrRegistrosDetalle}
            	{if $arrRegistros[registros].rut_alumno == $arrRegistrosDetalle[registrosDetalle].rut_alumno}
                	<td class='grilla-tab-fila-campo-pequenio' align='center' >
                            <input type="hidden" name="seleccion[]" value="{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}_{$arrRegistrosDetalle[registrosDetalle].itemdesa}">	
                            <input type="text" name="dp_{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}_{$arrRegistrosDetalle[registrosDetalle].itemdesa}" onKeyPress="return Tabula(this, event, 1)" size="5" value="{$arrRegistrosDetalle[registrosDetalle].concepto}"/>
            		</td>
                {/if}
            {/section}
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <input type="button" name="btnSeleccionar" value="Grabar" class="boton" onclick="xajax_ConfirmarDP(xajax.getFormValues('Form1'));">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>