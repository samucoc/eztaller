<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Situaci&oacute;n</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Accion</td>
        
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {if $arrRegistros[registros].situacion == '1'}
                    <img src='../images/tick.png' width='24' title='Proceso Cerrado' />
                {else}
                    <img src='../images/stop.png' width='24' title='Proceso Pendiente' />
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {if $arrRegistros[registros].situacion_final == '1'}

                {else}
                <a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'),'{$arrRegistros[registros].codigo_curso}');">
                    <img src='../images/basicos/agregar.png' title='Realizar Fin de A&ntilde;o' width="32"/>                    
                </a>
                {/if}
            </td>
            
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>