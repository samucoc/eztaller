<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<img src="{$logo_establecimiento}"  width="100" height="100"/>
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<h2>{$nombre_establecimiento}</h2>
        	<p>{$direccion_establecimiento}</p>
        	<p>R.D.B : {$rbd_establecimiento}</p>
        </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" colspan="{$notas_ingresadas+2}" align="center">
        	<h1>INFORME DE RENDIMIENTO ESCOLAR</h1>
        </td>
	</tr>															
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" colspan="{$notas_ingresadas+2}" align="center">
        	<h2>A&Ntilde;O {$anio}</h2>
        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        Alumno
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        {$nombre_alumno}
        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	Curso
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	{$nombre_curso}
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	Nro. Lista
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	{$nro_lista}
        </td>
	</tr>															
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	Profesor Jefe
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	{$nombre_profesor}
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	Fecha
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	{$smarty.now|date_format:"%d-%m-%Y"}
        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				1er Semestre
        </td> 
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				2do Semestre
        </td> 
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
        </td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_asignatura}
            </td>
			           
            {section name=registrosDetalle loop=$arrRegistrosDetalle}
                {if $arrRegistros[registros].asignatura == $arrRegistrosDetalle[registrosDetalle].CodigoRamo_1}
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        	{if $arrRegistrosDetalle[registrosDetalle].nota_1 == ''}
                            <div style="color:#FF0000">                
                                P
                            </div>
                            {else}
                                {if $arrRegistrosDetalle[registrosDetalle].nota_1 < 4}
                                <div style="color:#FF0000">                
                                    {$arrRegistrosDetalle[registrosDetalle].nota_1}
                                </div>
                                {else}
                                    {$arrRegistrosDetalle[registrosDetalle].nota_1}
                                {/if}
                            {/if}
                        </td>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        	{if $arrRegistrosDetalle[registrosDetalle].nota_2 == ''}
                            <div style="color:#FF0000">                
                                P
                            </div>
                            {else}
                                {if $arrRegistrosDetalle[registrosDetalle].nota_2 < 4}
                                <div style="color:#FF0000">                
                                    {$arrRegistrosDetalle[registrosDetalle].nota_2}
                                </div>
                                {else}
                                    {$arrRegistrosDetalle[registrosDetalle].nota_2}
                                {/if}
                            {/if}
                        </td>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        	{if $arrRegistrosDetalle[registrosDetalle].nota_t == ''}
                            <div style="color:#FF0000">                
                                P
                            </div>
                            {else}
                                {if $arrRegistrosDetalle[registrosDetalle].nota_t < 4}
                                <div style="color:#FF0000">                
                                    {$arrRegistrosDetalle[registrosDetalle].nota_t}
                                </div>
                                {else}
                                    {$arrRegistrosDetalle[registrosDetalle].nota_t}
                                {/if}
                            {/if}
                        </td>
                {/if}
            {/section}
        </tr>
    {/section}
        </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" colspan="3" align="left">
				Asistencia
            </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Dias Trabajados
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Dias Faltados
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                % Asistencia
            </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
				{$asistencia}
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                {$inasistencia}
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                {$porc_ina}
            </td>
        </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" colspan="3" align="left">
				Observaciones
	        </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Atrasos
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Positivas
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Negativas
            </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
				{$atrasos}
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                {$positiva}
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                {$negativa}
            </td>
        </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="left">
				Observacion General
	        </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="left">
                <textarea rows="10" cols="100"></textarea>
            </td>
        </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Firma Apoderado
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Firma Director
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Firma Prof Jefe
            </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
				________________________
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
            	<img src="{$foto}" width="100" height="100"/>
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
            	________________________
            </td>
        </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>