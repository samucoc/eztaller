<?php /* Smarty version 2.6.18, created on 2013-02-05 16:41:22
         compiled from sg_estado_cuenta_detalle_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_estado_cuenta_detalle_list.tpl', 15, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td class="grilla-tab-fila-campo" align='center' >Concepto</td>
            <td class="grilla-tab-fila-campo" align='center' >Fecha</td>
            <td class="grilla-tab-fila-campo" align='center' >Monto</td>
            <td class="grilla-tab-fila-campo" align='center' >Usuario</td>
        </tr>
        <?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['detalle']['show'] = true;
$this->_sections['detalle']['max'] = $this->_sections['detalle']['loop'];
$this->_sections['detalle']['step'] = 1;
$this->_sections['detalle']['start'] = $this->_sections['detalle']['step'] > 0 ? 0 : $this->_sections['detalle']['loop']-1;
if ($this->_sections['detalle']['show']) {
    $this->_sections['detalle']['total'] = $this->_sections['detalle']['loop'];
    if ($this->_sections['detalle']['total'] == 0)
        $this->_sections['detalle']['show'] = false;
} else
    $this->_sections['detalle']['total'] = 0;
if ($this->_sections['detalle']['show']):

            for ($this->_sections['detalle']['index'] = $this->_sections['detalle']['start'], $this->_sections['detalle']['iteration'] = 1;
                 $this->_sections['detalle']['iteration'] <= $this->_sections['detalle']['total'];
                 $this->_sections['detalle']['index'] += $this->_sections['detalle']['step'], $this->_sections['detalle']['iteration']++):
$this->_sections['detalle']['rownum'] = $this->_sections['detalle']['iteration'];
$this->_sections['detalle']['index_prev'] = $this->_sections['detalle']['index'] - $this->_sections['detalle']['step'];
$this->_sections['detalle']['index_next'] = $this->_sections['detalle']['index'] + $this->_sections['detalle']['step'];
$this->_sections['detalle']['first']      = ($this->_sections['detalle']['iteration'] == 1);
$this->_sections['detalle']['last']       = ($this->_sections['detalle']['iteration'] == $this->_sections['detalle']['total']);
?>
            <tr>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['detalle']['index']]['concepto']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left'>
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['detalle']['index']]['fecha'] != 'xxxx'): ?>
	                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['detalle']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

					<?php else: ?>                    
                    	----
                    <?php endif; ?>
                </td>
                <td class="grilla-tab-fila-campo" align='left'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['detalle']['index']]['monto']; ?>

                </td>
                <td class="grilla-tab-fila-campo" align='left'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['detalle']['index']]['usuario']; ?>

                </td>
            </tr>
        <?php endfor; endif; ?>
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


