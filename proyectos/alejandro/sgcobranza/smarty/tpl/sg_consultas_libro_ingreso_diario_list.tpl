<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' colspan="16">Libro de ingresos diarios</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Periodo</td>
        <td class="grilla-tab-fila-titulo" align='center' id="periodo_td" name="periodo_td"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Dia</td>
        <td class="grilla-tab-fila-titulo" align='center'>Desde</td>
        <td class="grilla-tab-fila-titulo" align='center'>Hasta</td>
        <td class="grilla-tab-fila-titulo" align='center'>Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center'>Escolaridad</td>
        <td class="grilla-tab-fila-titulo" align='center'>Donaciones</td>
        <td class="grilla-tab-fila-titulo" align='center'>Exenciones</td>
        <td class="grilla-tab-fila-titulo" align='center'>Intereses</td>
        <td class="grilla-tab-fila-titulo" align='center'>Total</td>
        <td class="grilla-tab-fila-titulo" align='center'>Observaciones</td>
    </tr>
    {section name=registros loop=$arrRegistros}
            <tr> 
                <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].dia}</td>
                <td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].minimo}</td>
                <td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].maximo}</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].valor}</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].exenciones}</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].valor}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nulas}</td>
            </tr>
    {/section}
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
       <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
	</td>
</tr>
</table>
</div>
