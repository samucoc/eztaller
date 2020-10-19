<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="5">Cumplea&ntilde;os de Alumnos</td>
    </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                Alumno
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                Curso
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                Fecha Nacimiento
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                Edad
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                Foto
            </td>
           
        </tr>

        {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].edad}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <img src="{$arrRegistros[registros].foto}" width="120">
            </td>
           
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>