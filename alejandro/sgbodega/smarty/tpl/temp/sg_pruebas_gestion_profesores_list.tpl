<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Listado Ingreso Notas</td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center">{$anio_busqueda}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Periodo</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center">{$periodo_busqueda}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center">{$curso_busqueda}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Nombre Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center">Nombre Profesor</td>
        {section name=registrosRD loop=$arrRegistrosPrueba}
       	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				<a href="#" onclick="cambiar('{$arrRegistrosPrueba[registrosRD].NumeroNota}_{$arrRegistrosPrueba[registrosRD].CodigoCurso}_{$arrRegistrosPrueba[registrosRD].CodigoRamo}_{$arrRegistrosPrueba[registrosRD].AnoAcademico}_{$arrRegistrosPrueba[registrosRD].Semestre}_{$arrRegistrosPrueba[registrosRD].Prueba}')">N-{$arrRegistrosPrueba[registrosRD].NumeroNota}</a>
        </td>
        {/section}
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_asignatura}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            {section name=registrosDetalle loop=$arrRegistrosDetalle}
            	{if (($arrRegistros[registros].prueba_ncorr == $arrRegistrosDetalle[registrosDetalle].prueba_ncorr)&& ($arrRegistros[registros].curso == $arrRegistrosDetalle[registrosDetalle].curso)&&($arrRegistros[registros].asignatura == $arrRegistrosDetalle[registrosDetalle].asignatura))}
                    {if $arrRegistrosDetalle[registrosDetalle].cant_dias == 'NO'}
                    <td class='grilla-tab-fila-campo-pequenio' align='center'><!--Rojo-->
                        <img src="../images/cara_roja.jpg" title="{$arrRegistrosDetalle[registrosDetalle].FechaPrueba}-{$arrRegistrosDetalle[registrosDetalle].DescripcionPrueba}-{$arrRegistrosDetalle[registrosDetalle].CoeficientePrueba}"/>
                    </td>
                    {else}
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                            <a href="#" onclick="xajax_CargaVentana(xajax.getFormValues('Form1'),'{$arrRegistrosDetalle[registrosDetalle].curso}',
                                                '{$arrRegistrosDetalle[registrosDetalle].asignatura}','{$arrRegistrosDetalle[registrosDetalle].NumeroNota}',
                                                '{$arrRegistrosDetalle[registrosDetalle].Semestre}','{$arrRegistrosDetalle[registrosDetalle].AnoAcademico}');">
                                <img src="../images/cara_verde.jpg" title="{$arrRegistrosDetalle[registrosDetalle].FechaPrueba}-{$arrRegistrosDetalle[registrosDetalle].DescripcionPrueba}-{$arrRegistrosDetalle[registrosDetalle].CoeficientePrueba}"/>
                            </a>
                        </td>
                        <!--
                        {if $arrRegistrosDetalle[registrosDetalle].cant_dias < 10}
                           
                        {else}
                            <td class='grilla-tab-fila-campo-pequenio' align='center' >
                                <img src="../images/cara_amarilla.jpg"/>
                            </td>
                        {/if}	
                        -->
                	{/if}
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