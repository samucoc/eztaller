<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
    <td width="21" align='center' class="grilla-tab-fila-titulo">
    	<input type="checkbox" name="selectall[]" id="selectall" onclick="checkAll(document.getElementById('Form1'), 'results1', this.checked);">
    </td>
	<td class="grilla-tab-fila-titulo-pequenio" >Nro Lista Alumno</td>
	<td class="grilla-tab-fila-titulo-pequenio" >Nombres Alumnos</td>
    {if $notas_ingresadas != '0'}
    	<td class="grilla-tab-fila-titulo-pequenio" colspan="{$notas_ingresadas}">Notas</td>
    {/if}
    <td width="100" class="grilla-tab-fila-titulo-pequenio">Ingresar Nota</td>
    <td width="100" class="grilla-tab-fila-titulo-pequenio">Fecha</td>
    <td width="100" class="grilla-tab-fila-titulo-pequenio">Observacion</td>
</tr>
{section name=registros loop=$arrRegistros}
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class='grilla-tab-fila-campo-pequenio' align='center'>
			<input type="checkbox" name="seleccion[]" class="results1" value='{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}'>
        </td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].nro_lista_alumno}
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			{$arrRegistros[registros].nombre_alumno}
		</td>
		{section name=registrosDetalle loop=$arrRegistrosDetalle}
        	{if $arrRegistros[registros].rut_alumno == $arrRegistrosDetalle[registrosDetalle].rut_alumno}
			<td class='grilla-tab-fila-campo-pequenio' align='center'>
				{$arrRegistrosDetalle[registrosDetalle].nota}
			</td>
            {/if}
        {/section}
        <td class='grilla-tab-fila-campo-pequenio' align='center' >
			<input type="text" name="nota_{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}" onKeyPress="return Tabula(this, event, 3)" size="5"/>
        </td>
        <td class='grilla-tab-fila-campo-pequenio' align='center' >
			<input type="text" name="fecha_{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}" onKeyPress="return SoloNumeros(this, event, 0)"  onkeyup="mascara(this,'-',patron,true)" size="10"/>
        </td>
        <td class='grilla-tab-fila-campo-pequenio' align='center'>
			<input type="text" name="observacion_{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre}" />
        </td>
	</tr>
{/section}
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnSeleccionar" value="Grabar" class="boton" onclick="xajax_ConfirmarNotas(xajax.getFormValues('Form1'));">
        <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime(xajax.getFormValues('Form1'));">
	</td>
</tr>
</table>
