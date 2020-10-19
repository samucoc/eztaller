<?php /* Smarty version 2.6.18, created on 2016-05-03 20:54:51
         compiled from sg_pruebas_gestion_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_pruebas_gestion_list.tpl', 46, false),)), $this); ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='right' colspan="7">Cantidad de filas: <?php echo $this->_tpl_vars['cant_filas']; ?>
 </td> 
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='center' colspan="7">Calendario de Evaluaciones</td> 
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >A&ntilde;o</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6"><?php echo $this->_tpl_vars['anio']; ?>
</td> 
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >Semestre</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6"><?php echo $this->_tpl_vars['semestre']; ?>
</td> 
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align='left' >Curso</td> 
        <td class="grilla-tab-fila-campo-pequenio" align='left'  colspan="6"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td> 
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
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['semestre']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaPrueba'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_tope'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cant_dias']; ?>

            </td>
            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaRealPrueba'] == '0000-00-00'): ?>
                <td class='grilla-tab-fila-campo-pequenio' align='center'><!--Rojo-->
                	<img src="../images/cara_roja.jpg"/>
                </td>
            <?php else: ?>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cant_dias'] < 10): ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
        		        <img src="../images/cara_verde.jpg"/>
                    </td>
                <?php else: ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
					    <img src="../images/cara_amarilla.jpg"/>
		            </td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>