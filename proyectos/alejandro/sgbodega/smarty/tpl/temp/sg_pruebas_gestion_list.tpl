<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='right' colspan="7">Cantidad de filas: {$cant_filas} </td> 
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='center' colspan="7">Calendario de Evaluaciones</td> 
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >A&ntilde;o</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6">{$anio}</td> 
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >Semestre</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6">{$semestre}</td> 
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >Curso</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6">{$nombre_curso}</td> 
    </tr>
    
   <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='center'>Profesor</td> 
        <td class="grilla-tab-fila-titulo-pequenio"  align='center'>Descripci&oacute;n</td>
        <td class="grilla-tab-fila-titulo-pequenio"  align='center' >Semestre</td>
        <td class="grilla-tab-fila-titulo-pequenio"   align='center'>Fecha Prueba</td>
        <td class="grilla-tab-fila-titulo-pequenio"   align='center'>Fecha Tope</td>
        <td class="grilla-tab-fila-titulo-pequenio"   align='center'>Cantidad Dias</td>
        <td class="grilla-tab-fila-titulo-pequenio"   align='center'>Estado</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].descripcion}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].semestre}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].FechaPrueba|date_format:"%d/%m/%Y"}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].fecha_tope|date_format:"%d/%m/%Y"}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].cant_dias}
            </td>
            {if $arrRegistros[registros].FechaRealPrueba == '0000-00-00'}
                <td class='grilla-tab-fila-campo-pequenio' align='center'><!--Rojo-->
                	<img src="../images/cara_roja.jpg"/>
                </td>
            {else}
                {if $arrRegistros[registros].cant_dias < 10}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
        		        <img src="../images/cara_verde.jpg"/>
                    </td>
                {else}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
					    <img src="../images/cara_amarilla.jpg"/>
		            </td>
                {/if}
            {/if}
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>