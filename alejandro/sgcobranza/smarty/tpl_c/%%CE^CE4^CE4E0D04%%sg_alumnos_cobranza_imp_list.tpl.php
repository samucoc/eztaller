<?php /* Smarty version 2.6.18, created on 2016-02-22 16:12:12
         compiled from sg_alumnos_cobranza_imp_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_alumnos_cobranza_imp_list.tpl', 28, false),array('modifier', 'number_format', 'sg_alumnos_cobranza_imp_list.tpl', 29, false),)), $this); ?>
<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
    	<td colspan="2" class="grilla-tab-fila-titulo">Cartola A&ntilde;o <?php echo $this->_tpl_vars['anio']; ?>
</td> 
    </tr>
	<tr>
    	<td class="grilla-tab-fila-titulo">Alumno</td>
    	<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['alumno']; ?>
</td>
    </tr>
    <tr>
    	<td class="grilla-tab-fila-titulo">Curso</td>
    	<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['curso']; ?>
</td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Nro Cuota</td>
                <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pactado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pagado</td>
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
                    <tr>
                    <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_cuota']; ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['pactado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valorpagado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
                    </tr>
            <?php endfor; endif; ?>
            
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Total</td>
                <td class="grilla-tab-fila-campo" align='right' colspan="6"><label id="total" name="total"><?php echo $this->_tpl_vars['tot_saldo']; ?>
</label></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
</div>


