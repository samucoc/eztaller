<?php /* Smarty version 2.6.18, created on 2014-11-22 12:14:39
         compiled from sg_informes_alumnos_anual_notas_list.tpl */ ?>
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
						<?php echo $this->_tpl_vars['rbd_establecimiento']; ?>

                    </td>
                </tr>
			    <tr>
			    	<td class="grilla-tab-fila-campo-pequenio" align="center">
						A&ntilde;o escolar
                    </td>
                    <td class="grilla-tab-fila-campo-pequenio" align="center">
						<?php echo $this->_tpl_vars['anio']; ?>

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
        	<?php echo $this->_tpl_vars['tipo_establecimiento']; ?>

        </td>
    </tr>
	</table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Plan y Programas de Estudio, Decreto Exento o Resoluci&oacute;n Excenta de Educaci&oacute;n</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center"><?php echo $this->_tpl_vars['planes']; ?>
 de <?php echo $this->_tpl_vars['fecha_planes']; ?>
</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Decreto de Promoci&oacute;n o evaluaci&oacute;n de alumnos, Decreto Exento de Educaci&oacute;n</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center"><?php echo $this->_tpl_vars['evaluacion']; ?>
 de <?php echo $this->_tpl_vars['fecha_evaluacion']; ?>
</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Decreto Cooperador de la funci&oacute;n Educativa del Estado (Ley Decreto Supremo)</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center"><?php echo $this->_tpl_vars['NumeroDecreto']; ?>
 de <?php echo $this->_tpl_vars['FechaDecreto']; ?>
</td>
    </tr>
	</table>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Don(a)</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center"><?php echo $this->_tpl_vars['nombre_alumno']; ?>
</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center">Run</td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center"><?php echo $this->_tpl_vars['NumeroRutAlumno']; ?>
</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">Alumno(a) del </td>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"><?php echo $this->_tpl_vars['nombre_establecimiento']; ?>
</td>
    </tr>
   	<tr>
    	<td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="4">ha cursado el <?php echo $this->_tpl_vars['nombre_curso']; ?>
 y, de acuerdo a las disposiciones reglamentarias vigentes, ha obtenido los siguientes resultados:</td>
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
    <?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros']['show'] = true;
$this->_sections['registros']['max'] = $this->_sections['registros']['loop'];
$this->_sections['registros']['step'] = 1;
$this->_sections['registros']['start'] = $this->_sections['registros']['step'] > 0 ? 0 : $this->_sections['registros']['loop']-1;
if ($this->_sections['registros']['show']) {
    $this->_sections['registros']['total'] = $this->_sections['registros']['loop'];
    if ($this->_sections['registros']['total'] == 0)
        $this->_sections['registros']['show'] = false;
} else
    $this->_sections['registros']['total'] = 0;
if ($this->_sections['registros']['show']):

            for ($this->_sections['registros']['index'] = $this->_sections['registros']['start'], $this->_sections['registros']['iteration'] = 1;
                 $this->_sections['registros']['iteration'] <= $this->_sections['registros']['total'];
                 $this->_sections['registros']['index'] += $this->_sections['registros']['step'], $this->_sections['registros']['iteration']++):
$this->_sections['registros']['rownum'] = $this->_sections['registros']['iteration'];
$this->_sections['registros']['index_prev'] = $this->_sections['registros']['index'] - $this->_sections['registros']['step'];
$this->_sections['registros']['index_next'] = $this->_sections['registros']['index'] + $this->_sections['registros']['step'];
$this->_sections['registros']['first']      = ($this->_sections['registros']['iteration'] == 1);
$this->_sections['registros']['last']       = ($this->_sections['registros']['iteration'] == $this->_sections['registros']['total']);
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_asignatura']; ?>

            </td>
			           
            <?php unset($this->_sections['registrosDetalle']);
$this->_sections['registrosDetalle']['name'] = 'registrosDetalle';
$this->_sections['registrosDetalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDetalle']['show'] = true;
$this->_sections['registrosDetalle']['max'] = $this->_sections['registrosDetalle']['loop'];
$this->_sections['registrosDetalle']['step'] = 1;
$this->_sections['registrosDetalle']['start'] = $this->_sections['registrosDetalle']['step'] > 0 ? 0 : $this->_sections['registrosDetalle']['loop']-1;
if ($this->_sections['registrosDetalle']['show']) {
    $this->_sections['registrosDetalle']['total'] = $this->_sections['registrosDetalle']['loop'];
    if ($this->_sections['registrosDetalle']['total'] == 0)
        $this->_sections['registrosDetalle']['show'] = false;
} else
    $this->_sections['registrosDetalle']['total'] = 0;
if ($this->_sections['registrosDetalle']['show']):

            for ($this->_sections['registrosDetalle']['index'] = $this->_sections['registrosDetalle']['start'], $this->_sections['registrosDetalle']['iteration'] = 1;
                 $this->_sections['registrosDetalle']['iteration'] <= $this->_sections['registrosDetalle']['total'];
                 $this->_sections['registrosDetalle']['index'] += $this->_sections['registrosDetalle']['step'], $this->_sections['registrosDetalle']['iteration']++):
$this->_sections['registrosDetalle']['rownum'] = $this->_sections['registrosDetalle']['iteration'];
$this->_sections['registrosDetalle']['index_prev'] = $this->_sections['registrosDetalle']['index'] - $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['index_next'] = $this->_sections['registrosDetalle']['index'] + $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['first']      = ($this->_sections['registrosDetalle']['iteration'] == 1);
$this->_sections['registrosDetalle']['last']       = ($this->_sections['registrosDetalle']['iteration'] == $this->_sections['registrosDetalle']['total']);
?>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['CodigoRamo_1']): ?>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        	<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota_t'] == ''): ?>
                            <div style="color:#FF0000">                
                                P
                            </div>
                            <?php else: ?>
                                <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota_t'] < 4): ?>
                                <div style="color:#FF0000">                
                                    <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota_t']; ?>

                                </div>
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota_t']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
 		                       <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['letra_nota']; ?>

                        </td>
                <?php endif; ?>
            <?php endfor; endif; ?>
        </tr>
    <?php endfor; endif; ?>
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
            	<img src="<?php echo $this->_tpl_vars['foto']; ?>
" width="100" height="100"/>
            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
            	________________________
            </td>
        </tr>
    </table>
    
    
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');;">
        </td>
    </tr>
    </table>
</div>