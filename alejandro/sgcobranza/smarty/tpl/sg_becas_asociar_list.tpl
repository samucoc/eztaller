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
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Becado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Beca Cuota Inicial</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">% Beca Cuota Inicial</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Beca Colegiatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">% Beca Colegiatura</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
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
            {if $arrRegistros[registros].nro_lista != 'Totales'}
                {if $arrRegistros[registros].matriculado=='1'}
                    <img src='../images/tick.png' width='24' title='Matriculado' />
                {else}
                     <img src='../images/stop.png' width='24' title='No Matriculado'  />
                {/if}
            {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
            {if $arrRegistros[registros].nro_lista != 'Totales'}
                    {if ($arrRegistros[registros].con_beca=='')||($arrRegistros[registros].con_beca=='Sin Beca')}
                        <img src='../images/stop.png' width='24' title='Sin Beca' onclick="xajax_LlamaDetalle(xajax.getFormValues('Form1'),{$arrRegistros[registros].rut_alumno_0});"/>
                    {else}
                        <a href="#" onclick="xajax_LlamaDetalle_1(xajax.getFormValues('Form1'),{$arrRegistros[registros].rut_alumno_0});" title="Eliminar Beca">{$arrRegistros[registros].con_beca}</a>
                    {/if}
            {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].IncorporacionTipoBeca|number_format:0:",":"."}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].PorcBecaIncorporacion} %
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].ColegiaturaTipoBeca|number_format:0:",":"."}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].PorcBecaColegiatura} %
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