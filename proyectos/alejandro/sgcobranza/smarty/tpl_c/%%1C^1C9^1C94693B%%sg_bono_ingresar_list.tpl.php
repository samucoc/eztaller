<?php /* Smarty version 2.6.18, created on 2013-12-26 15:03:10
         compiled from sg_bono_ingresar_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_bono_ingresar_list.tpl', 12, false),)), $this); ?>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo">Fecha</td>
	<td class="grilla-tab-fila-titulo">Trabajador</td>
	<td class="grilla-tab-fila-titulo">Detalle</td>
	<td class="grilla-tab-fila-titulo">Monto</td>
	<td class="grilla-tab-fila-titulo"></td>
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
		<td class="grilla-tab-fila-campo">
        	<?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>

        </td>
		<td class="grilla-tab-fila-campo">
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['trabajador']; ?>

        </td>
		<td class="grilla-tab-fila-campo">
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['detalle']; ?>

        </td>
		<td class="grilla-tab-fila-campo">
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>

        </td>
		<td class="grilla-tab-fila-campo">
        	<a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
)">Eliminar</a>
        </td>
	</tr>
<?php endfor; endif; ?>
	<tr>
		<td class="grilla-tab-fila-campo" colspan="2">
        	<a href="http://192.168.0.50/sgvales/sitio/scripts/enviar_correo_bonos.php?grupo=<?php echo $this->_tpl_vars['grupo']; ?>
" >Enviar Correo</a>
        </td>
		<td class="grilla-tab-fila-campo" colspan="1">
        	Total
        </td>
		<td class="grilla-tab-fila-campo" colspan="1">
        	<?php echo $this->_tpl_vars['total']; ?>

        </td>
    </tr>
    <tr>
		<td class="grilla-tab-fila-campo" colspan="4">
        <!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
    	</td>
    </tr>
</table>