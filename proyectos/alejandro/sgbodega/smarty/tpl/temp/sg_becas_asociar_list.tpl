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
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Sexo</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Nacimiento</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"' onclick="xajax_LlamaDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].rut_alumno_0});">
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nro_lista}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].rut_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {if $arrRegistros[registros].matriculado=='1'}
                    <img src='../images/tick.png' width='24' title='Matriculado' />
                {else}
                     <img src='../images/stop.png' width='24' title='No Matriculado'  />
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {if $arrRegistros[registros].sexo_alumno == 0}
					Masculino
				{else}
					Femenino
				{/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].fecha_nacimiento}
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