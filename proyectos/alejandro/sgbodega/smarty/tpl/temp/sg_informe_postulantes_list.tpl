<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Periodo
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Curso
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Alumno
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Observaciones
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Estado
            </td>
           
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].periodo}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].alumno}
            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].observaciones}
            </td>
            {if $arrRegistros[registros].matriculado == '1' } 
                <td class='grilla-tab-fila-campo' align='center'> 
                    <img src='../images/tick.png' width='24' title='Aceptado' />
                </td>
            {else}
                <td class='grilla-tab-fila-campo' align='center'>
                    <img src='../images/stop.png' width='24' 
                        {if $arrRegistros[registros].matriculado == '2'}
                            title='En proceso'
                        {else}
                            title='Pendiente'
                        {/if}
                    />
                    {if $arrRegistros[registros].matriculado == '2'}
                        !
                    {/if}
                </td>
            {/if}    
            
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>