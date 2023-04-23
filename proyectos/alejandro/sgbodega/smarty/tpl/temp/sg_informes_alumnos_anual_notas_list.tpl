<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
			<p>REPUBLICA DE CHILE</p>																	
			<p>MINISTERIO DE EDUCACION</p>																	
			<p>DIVISION DE EDUCACION GENERAL</p>																	
			<p>SECRETARIA REGIONAL MINISTERIAL DE EDUCACION</p>																	
	    </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        		<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
                    	Region
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
                    	Quinta
                    </td>
                </tr>
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
						Provincia
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
                    	Valparaiso
                    </td>
                </tr>
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
                    	Comuna
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
                    	Villa Alemana
                    </td>
                </tr>
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
						Rol base de datos
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
						{$rbd_establecimiento}
                    </td>
                </tr>
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
						A&ntilde;o escolar
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
						{$anio}
                    </td>
                </tr>
		    </table>
        </td>
    </tr>
    </table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">
        	<h1>CERTIFICADO ANUAL DE ESTUDIOS</h1>
        </td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">
			ENSE&Ntilde;ANZA MEDIA
        </td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">
        	{$tipo_establecimiento}
        </td>
    </tr>
	</table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Plan y Programas de Estudio, Decreto Exento o Resoluci&oacute;n Excenta de Educaci&oacute;n</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">{$planes} de {$fecha_planes}</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Decreto de Promoci&oacute;n o evaluaci&oacute;n de alumnos, Decreto Exento de Educaci&oacute;n</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">{$evaluacion} de {$fecha_evaluacion}</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Decreto Cooperador de la funci&oacute;n Educativa del Estado (Ley Decreto Supremo)</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">{$NumeroDecreto} de {$FechaDecreto}</td>
    </tr>
	</table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Don(a)</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">{$nombre_alumno}</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Run</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">{$NumeroRutAlumno}</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">Alumno(a) del </td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">{$nombre_establecimiento}</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="4">ha cursado el {$nombre_curso} y, de acuerdo a las disposiciones reglamentarias vigentes, ha obtenido los siguientes resultados:</td>
    </tr>
	</table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Cifras
        </td> 
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				En Palabras
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
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
 		                       {$arrRegistrosDetalle[registrosDetalle].letra_nota}
                        </td>
                {/if}
            {/section}
        </tr>
    {/section}
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="left">
				En concecuencia
	        </td>
        </tr>
		<tr>
            <td class="grilla-tab-fila-campo-pequenio" align="left">
                <textarea rows="10" cols="100"></textarea>
            </td>
        </tr>
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
                Firma Director
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                Firma Prof Jefe
            </td>
        </tr>
		<tr>
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