<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="4">Lista Flotante Para Asistencia</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">Fecha</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">{$nombre_curso}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Matricula</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Ingreso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Retiro</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                {if ($arrRegistros[registros].sexo_alumno == '0')} 
                    style="color: blue !important;"
                {else}
                    style="color: red !important;"
                {/if}
            >
                {if $arrRegistros[registros].nro_lista=='0'}

                {else}
                    {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}
                        {$arrRegistros[registros].nro_lista}
                    {else}
                        <strike>
                        {$arrRegistros[registros].nro_lista}
                        </strike>
                    {/if}
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                {if ($arrRegistros[registros].sexo_alumno == '0')} 
                    style="color: blue !important;"
                {else}
                    style="color: red !important;"
                {/if}
            >
                {if $arrRegistros[registros].nro_matricula=='0'}

                {else}
                    {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}
                        {$arrRegistros[registros].nro_matricula}
                    {else}
                        <strike>
                            {$arrRegistros[registros].nro_matricula}
                        </strike>
                    {/if}                    
                {/if}

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                {if ($arrRegistros[registros].sexo_alumno == '0')} 
                    style="color: blue !important;"
                {else}
                    style="color: red !important;"
                {/if}
            >
                    {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}
                        {$arrRegistros[registros].fecha_ingreso|date_format:"%d/%m/%Y"}
                    {else}
                        <strike>
                            {$arrRegistros[registros].fecha_ingreso|date_format:"%d/%m/%Y"}
                        </strike>
                    {/if}  
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}

                {else}
                        <strike>
                            {$arrRegistros[registros].fecha_retiro|date_format:"%d/%m/%Y"}
                        </strike>
                {/if}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                {if ($arrRegistros[registros].sexo_alumno == '0')} 
                    style="color: blue !important;"
                {else}
                    style="color: red !important;"
                {/if}
            >
                 {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}
                        {$arrRegistros[registros].rut_alumno}
                    {else}
                        <strike>
                            {$arrRegistros[registros].rut_alumno}
                        </strike>
                    {/if}  


            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                {if ($arrRegistros[registros].sexo_alumno == '0')} 
                    style="color: blue !important;"
                {else}
                    style="color: red !important;"
                {/if}
            >
                 {if $arrRegistros[registros].fecha_retiro=='0000-00-00'}
                         {$arrRegistros[registros].nombre_alumno}
                    {else}
                        <strike>
                             {$arrRegistros[registros].nombre_alumno}
                        </strike>
                    {/if}  
               
            </td>
        </tr>
    {/section}
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Hombres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>{$hombre}</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Mujeres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>{$mujer}</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Total</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>{$total}</td>
        </tr>

    </table>
</div>