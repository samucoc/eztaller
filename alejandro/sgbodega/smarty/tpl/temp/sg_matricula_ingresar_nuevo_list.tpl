<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso Admision</td> 
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Estado</td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"' 
                onclick="xajax_ActulizarAlumno(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}')" >
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {if $arrRegistros[registros].autorizado == '1'}
                    Aceptado
                {elseif $arrRegistros[registros].autorizado == '2'}
                    Autorizado
                {else}
                    Matriculado
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