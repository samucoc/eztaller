<?php /* Smarty version 2.6.18, created on 2014-11-04 16:27:40
         compiled from sg_combustible_ce_penau_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_combustible_ce_penau_list.tpl', 23, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ncorr');">Codigo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'persona');">Trabajador</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'patente');">Patente</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Monto</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'autorizado_por');">Autorizado Por</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'autorizado');">Autorizado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo');">Tipo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'>Accion</td>
	

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
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['persona']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['autorizado_por']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['autorizado']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo']; ?>
</td>
            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['autorizado'] == 'SI'): ?>
            	<td class="grilla-tab-fila-campo" align='left'>
            		<a href="#" onclick="xajax_RealizarCarga(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo']; ?>
')" >Realizar Carga</a>
               		<!-- <a href="#" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo']; ?>
')" >Eliminar Carga</a>--></td> 
			<?php else: ?>
	            <td class="grilla-tab-fila-campo" align='left'>
            		<!-- <a href="#" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo']; ?>
')" >Eliminar Carga</a>--></td>
	        <?php endif; ?>
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


