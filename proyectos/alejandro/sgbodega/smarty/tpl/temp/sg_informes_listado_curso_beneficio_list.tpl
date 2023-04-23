<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$nombre_curso}
            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo-pequenio' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$nombre_profe}
            </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Orden</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Beneficio</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"' 
             >
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].item}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].rut_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {if $arrRegistros[registros].matriculado=='1'}
                    <img src='../images/tick.png' width='24' title='Con beneficio'  alt='Con beneficio' onclick='xajax_EliminarBeneficio(xajax.getFormValues('Form1'),"{$arrRegistros[registros].rut_alumno}")'/>
                {else}
                    <img src='../images/stop.png' width='24' title='Sin beneficio'   alt='Sin beneficio' onclick='xajax_AgregarBeneficio(xajax.getFormValues('Form1'),"{$arrRegistros[registros].rut_alumno}")'/>
                {/if}
            </td>
        </tr>
    {/section}

    </table>
</div>