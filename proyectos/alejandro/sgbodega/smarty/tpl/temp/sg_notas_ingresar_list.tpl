<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio" colspan="{$notas_ingresadas+2}"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Semestre</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_semestre" colspan="{$notas_ingresadas+2}"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso" colspan="{$notas_ingresadas+2}"></td>
    </tr>
    <tr> 
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_asignatura" colspan="{$notas_ingresadas+2}"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        {section name=registrosRP loop=$arrRegistrosPrueba}
		   	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				{if $situacion_final == 1}
                    <a href="#" title="{$arrRegistrosPrueba[registrosRP].DescripcionPrueba}">
                        N-{$arrRegistrosPrueba[registrosRP].NumeroNota}
                    </a>
                    <div id="div_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" style="display:none">
                        <a id="mo_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" href="#">Editar</a>
                        <a id="el_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" href="#">Eliminar</a>
                    </div>
                {else}
                    <a onclick="cambiar('{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}')" href="#" title="{$arrRegistrosPrueba[registrosRP].DescripcionPrueba}">
    					N-{$arrRegistrosPrueba[registrosRP].NumeroNota}
    				</a>
    				<div id="div_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" style="display:none">
    					<a id="mo_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" onclick="xajax_ModificarNotaCM(xajax.getFormValues('Form1'),'{$arrRegistrosPrueba[registrosRP].NumeroNota}','{$arrRegistrosPrueba[registrosRP].CodigoCurso}','{$arrRegistrosPrueba[registrosRP].CodigoRamo}','{$arrRegistrosPrueba[registrosRP].AnoAcademico}','{$arrRegistrosPrueba[registrosRP].Semestre}','{$arrRegistrosPrueba[registrosRP].Prueba}')" href="#">Editar</a>
    					<a id="el_{$arrRegistrosPrueba[registrosRP].NumeroNota}_{$arrRegistrosPrueba[registrosRP].CodigoCurso}_{$arrRegistrosPrueba[registrosRP].CodigoRamo}_{$arrRegistrosPrueba[registrosRP].AnoAcademico}_{$arrRegistrosPrueba[registrosRP].Semestre}_{$arrRegistrosPrueba[registrosRP].Prueba}" onclick="xajax_EliminarNota(xajax.getFormValues('Form1'),'{$arrRegistrosPrueba[registrosRP].NumeroNota}','{$arrRegistrosPrueba[registrosRP].CodigoCurso}','{$arrRegistrosPrueba[registrosRP].CodigoRamo}','{$arrRegistrosPrueba[registrosRP].AnoAcademico}','{$arrRegistrosPrueba[registrosRP].Semestre}','{$arrRegistrosPrueba[registrosRP].Prueba}')" href="#">Eliminar</a>
    				</div>
                {/if}
            </td>
        {/section}
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
        </td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class="grilla-tab-fila-campo-pequenio" align="center">{$arrRegistros[registros].nro_lista_alumno}</td>
     		<td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRegistros[registros].nombre_alumno}</td>
        
			{section name=registrosDetalle loop=$arrRegistrosDetalle}
                {if $arrRegistros[registros].rut_alumno == $arrRegistrosDetalle[registrosDetalle].rut_alumno}
            			<td class='grilla-tab-fila-campo-pequenio' align='center' onclick="xajax_ModificarNota(xajax.getFormValues('Form1'),
                											'{$arrRegistros[registros].rut_alumno}',
                											'{$arrRegistros[registros].asignatura}',
                											'{$arrRegistros[registros].anio}',
                											'{$arrRegistros[registros].curso}',
                											'{$arrRegistros[registros].semestre}',
                											'{$arrRegistrosDetalle[registrosDetalle].prueba}',
                											'{$arrRegistrosDetalle[registrosDetalle].nro_nota}',
                											'{$arrRegistrosDetalle[registrosDetalle].nota}')">
                											<!-- $asignatura,$anio,$curso,$semestre,$prueba,$nro_nota,$nota -->
                        	{if $arrRegistrosDetalle[registrosDetalle].nota == ''}
                            <div style="color:#FF0000">                
                                --
                            </div>
                            {else}
                                {if $arrRegistrosDetalle[registrosDetalle].nota < 4}
                                <div style="color:#FF0000">                
                                    {$arrRegistrosDetalle[registrosDetalle].nota}
                                </div>
                                {else}
                                    {$arrRegistrosDetalle[registrosDetalle].nota}
                                {/if}
                            {/if}
                        </td>
                {/if}
            {/section}
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>