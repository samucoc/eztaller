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
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Retiro</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Sexo</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Nacimiento</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Email Apoderado</td>
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
                {if $arrRegistros[registros].item!='----'}
                    {if $arrRegistros[registros].matriculado=='1'}
                        <img src='../images/tick.png' width='24' title='Matriculado'  alt='Matriculado' />
                    {else}
                        {if $arrRegistros[registros].matriculado=='0'}
                        <img src='../images/stop.png' width='24' title='No Matriculado'   alt='No Matriculado'  />
                        {else}
                            <img src='../images/stop.png' width='24' title='Retirado' alt='Retirado'/>
                        {/if}
                    {/if}
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {if $arrRegistros[registros].FechaRetiro != '0000-00-00'}
                    {$arrRegistros[registros].FechaRetiro|date_format:'%d/%m/%Y'}
                {else}
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {if $arrRegistros[registros].item!='----'}
                    {if $arrRegistros[registros].sexo_alumno == 0}
    					Masculino
    				{else}
    					Femenino
    				{/if}
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].fecha_nacimiento}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].EMailApoderado}
            </td>
        </tr>
    {/section}

    </table>
</div>