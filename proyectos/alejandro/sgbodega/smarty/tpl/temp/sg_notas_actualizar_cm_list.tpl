<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="5%">Nro Lista</td> 
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Nombre Alumno</td>
        <td width="100" class="grilla-tab-fila-titulo-pequenio" align="center">Nota</td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].nro_lista_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
       			<input type="hidden" name="seleccion[]" value="{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}_{$arrRegistros[registros].prueba}" />	
            </td>
            {section name=registrosDetalle loop=$arrRegistrosDetalle}
                {if ($arrRegistros[registros].rut_alumno == $arrRegistrosDetalle[registrosDetalle].rut_alumno)}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        <input type="text" name="nota_{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}_{$arrRegistros[registros].prueba}" onKeyPress="return SoloNumeros(this, event, 1)" size="5"   {if $arrRegistrosDetalle[registrosDetalle].nota == ''}
                                                                    value=""
                                                                {else}
                                                                    value="{$arrRegistrosDetalle[registrosDetalle].nota}"
                                                                {/if}
                        onchange="xajax_ReconocerNro(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}_{$arrRegistros[registros].prueba}')" />
                    </td>
                {/if}
            {/section}
            
        </tr>
    {/section}
    </table>
</div>