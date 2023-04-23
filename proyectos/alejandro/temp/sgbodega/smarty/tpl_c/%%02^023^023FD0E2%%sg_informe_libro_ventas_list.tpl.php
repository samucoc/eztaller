<?php /* Smarty version 2.6.18, created on 2013-04-25 11:29:43
         compiled from sg_informe_libro_ventas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_informe_libro_ventas_list.tpl', 31, false),array('modifier', 'date_format', 'sg_informe_libro_ventas_list.tpl', 75, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan="13" class="grilla-tab-fila-titulo" align="center">Informe Libro Venta</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align="center">Fecha</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
</tr>
	<?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <?php if ($this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fecha'] == '----'): ?>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">
                    	Subtotales
                </td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_1']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_1']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_2']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_2']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_3']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_3']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                <?php elseif ($this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fecha'] == 'xxxx'): ?>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">
                    	----
                </td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_3']; ?>
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                <?php else: ?>
                <td class="grilla-tab-fila-titulo" align='left'>
	                	<?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

                </td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_1']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_1']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_2']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_2']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['inicio_3']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fin_3']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['monto_3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
				<?php endif; ?>
                
        </tr>
    <?php endfor; endif; ?>
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">-->
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


