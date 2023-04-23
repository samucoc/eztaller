<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" colspan="4" align="center">{$nombre_curso}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">C&oacute;digo Asginatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" colspan="4" align="center">Nombre Asignatura</td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>N&uacute;mero Orden</td>
        <td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
        <td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
        <td class="grilla-tab-fila-titulo" align='center'>C&oacute;digo RECH</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].numero}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].Descripcion}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].profesor}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].RECH}
            </td>
            
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
            <a href="#" style="cursor: hand;"><img src="../images/basicos/salida.png" border=0 title="Volver" onclick="window.history.back();" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>