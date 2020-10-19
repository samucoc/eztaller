<?php /* Smarty version 2.6.18, created on 2016-05-26 12:57:05
         compiled from sg_informes_alumnos_semestral_notas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informes_alumnos_semestral_notas_list.tpl', 62, false),)), $this); ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<img src="<?php echo $this->_tpl_vars['logo_establecimiento']; ?>
"  width="100" height="100"/>
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<h2><?php echo $this->_tpl_vars['nombre_establecimiento']; ?>
</h2>
        	<p><?php echo $this->_tpl_vars['direccion_establecimiento']; ?>
</p>
        	<p>R.D.B : <?php echo $this->_tpl_vars['rbd_establecimiento']; ?>
</p>
        </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
" align="center">
        	<h1>INFORME FINAL</h1>
        </td>
	</tr>															
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
" align="center">
        	<h2><?php echo $this->_tpl_vars['nombre_semestre']; ?>
</h2>
        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        Alumno
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        <?php echo $this->_tpl_vars['nombre_alumno']; ?>

        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	Curso
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	<?php echo $this->_tpl_vars['nombre_curso']; ?>

        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	Nro. Lista
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center" width="25%">
        	<?php echo $this->_tpl_vars['nro_lista']; ?>

        </td>
	</tr>															
    <tr>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	Profesor Jefe
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<?php echo $this->_tpl_vars['nombre_profesor']; ?>

        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	Fecha
        </td>
    	<td class="grilla-tab-fila-campo-pequenio" align="center">
        	<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>

        </td>
	</tr>															
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Asignatura</td>
        <?php unset($this->_sections['registrosRP']);
$this->_sections['registrosRP']['name'] = 'registrosRP';
$this->_sections['registrosRP']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosMaximo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosRP']['show'] = true;
$this->_sections['registrosRP']['max'] = $this->_sections['registrosRP']['loop'];
$this->_sections['registrosRP']['step'] = 1;
$this->_sections['registrosRP']['start'] = $this->_sections['registrosRP']['step'] > 0 ? 0 : $this->_sections['registrosRP']['loop']-1;
if ($this->_sections['registrosRP']['show']) {
    $this->_sections['registrosRP']['total'] = $this->_sections['registrosRP']['loop'];
    if ($this->_sections['registrosRP']['total'] == 0)
        $this->_sections['registrosRP']['show'] = false;
} else
    $this->_sections['registrosRP']['total'] = 0;
if ($this->_sections['registrosRP']['show']):

            for ($this->_sections['registrosRP']['index'] = $this->_sections['registrosRP']['start'], $this->_sections['registrosRP']['iteration'] = 1;
                 $this->_sections['registrosRP']['iteration'] <= $this->_sections['registrosRP']['total'];
                 $this->_sections['registrosRP']['index'] += $this->_sections['registrosRP']['step'], $this->_sections['registrosRP']['iteration']++):
$this->_sections['registrosRP']['rownum'] = $this->_sections['registrosRP']['iteration'];
$this->_sections['registrosRP']['index_prev'] = $this->_sections['registrosRP']['index'] - $this->_sections['registrosRP']['step'];
$this->_sections['registrosRP']['index_next'] = $this->_sections['registrosRP']['index'] + $this->_sections['registrosRP']['step'];
$this->_sections['registrosRP']['first']      = ($this->_sections['registrosRP']['iteration'] == 1);
$this->_sections['registrosRP']['last']       = ($this->_sections['registrosRP']['iteration'] == $this->_sections['registrosRP']['total']);
?>
		   	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				N-<?php echo $this->_tpl_vars['arrRegistrosMaximo'][$this->_sections['registrosRP']['index']]['nro_nota']; ?>

            </td>
        <?php endfor; endif; ?>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
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
       	            <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['CodigoRamo'] )): ?>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                            <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota'] < 4): ?>
                            <div style="color:#FF0000">                
                                <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                            </div>
                            <?php else: ?>
                                <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                            <?php endif; ?>
                        </td>
    	            <?php endif; ?>
                <?php endfor; endif; ?>
        
        </tr>
    <?php endfor; endif; ?>
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
				<?php echo $this->_tpl_vars['asistencia']; ?>

            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                <?php echo $this->_tpl_vars['inasistencia']; ?>

            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                <?php echo $this->_tpl_vars['porc_ina']; ?>

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
				<?php echo $this->_tpl_vars['atrasos']; ?>

            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                <?php echo $this->_tpl_vars['positiva']; ?>

            </td>
            <td class="grilla-tab-fila-campo-pequenio" align="center">
                <?php echo $this->_tpl_vars['negativa']; ?>

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
                <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
            </td>
	    </tr>
    </table>
</div>