<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="center">Apoderado</td>
        <td class="grilla-tab-fila-titulo" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo" align="center">Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Nro Cheque</td>
        <td class="grilla-tab-fila-titulo" align="center">Banco</td>
        <td class="grilla-tab-fila-titulo" align="center">Valor</td>
        <td class="grilla-tab-fila-titulo" align="center">Fecha</td>
        <td class="grilla-tab-fila-titulo" align="center">Estado</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].apoderado}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].curso}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].alumno}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].NumeroCheque}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].NombreBanco}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].ValorCheque}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].cheque_ncorr});">{$arrRegistros[registros].FechaCheque}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {if ($arrRegistros[registros].EstadoCheque == '0')}
                    <a href="#" onclick="xajax_PagarMov(xajax.getFormValues('Form1'),{$arrRegistros[registros].NumeroBoleta})">
                        <img src="../images/fin_comp/pago.png" title="Pagar Cheque" alt="Pagar Cheque" width="24" height="24"/>
                    </a>
                    <input type="hidden" name="cheque_{$arrRegistros[registros].NumeroBoleta}" id="cheque_{$arrRegistros[registros].NumeroBoleta}" value="{$arrRegistros[registros].NumeroBoleta}"/>
                {/if}
                {if ($arrRegistros[registros].EstadoCheque == '1')}
                    Cobrado
                {/if}
                {if ($arrRegistros[registros].EstadoCheque == '2')}
                    Anulado
                {/if}
            </td>
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" onclick="ImprimeDiv('divabonos');">
                <img src='../images/basicos/imprimir.png' title='Imprimir' width="32"/>
            </a>
        </td>
    </tr>
    </table>
</div>
