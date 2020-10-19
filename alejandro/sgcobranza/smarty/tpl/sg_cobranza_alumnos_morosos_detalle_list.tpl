<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Apoderado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" colspan="17">{$nombre_apoderado}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" colspan="17">{$nombre_alumno}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" colspan="17">{$nombre_curso}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Tipo Cuota</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Cuota</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Vencimineto</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Pactado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Pagado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Saldo</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].tipo_cuota}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].nro_cuota}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].fecha_venc|date_format:"%d/%m/%Y"}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].pactado|number_format:0:",":"."}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].pagado|number_format:0:",":"."}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].saldo|number_format:0:",":"."}
            </td>
	    </tr>
    {/section}

    <tr>
        <td colspan='5' class="grilla-tab-fila-titulo">
            Total
        </td>
        <td colspan='1' class="grilla-tab-fila-titulo" align='right'>
            {$total_saldo|number_format:0:",":"."}
        </td>
    </tr>
    
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
        </td>
    </tr>
    </table>
</div>