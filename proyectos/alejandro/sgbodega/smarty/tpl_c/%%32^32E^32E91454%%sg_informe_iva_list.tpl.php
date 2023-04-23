<?php /* Smarty version 2.6.18, created on 2013-04-03 15:55:43
         compiled from sg_informe_iva_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_informe_iva_list.tpl', 14, false),array('function', 'math', 'sg_informe_iva_list.tpl', 93, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan="4" class="grilla-tab-fila-titulo" align="center">Informe IVA</td>
</tr>
<tr>
	<td colspan="2" class="grilla-tab-fila-titulo" align="center">Ventas</td>
	<td colspan="2" class="grilla-tab-fila-titulo" align="center">Compras</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left' width="25%">Neto</td>
	<td class="grilla-tab-fila-campo" align='left' width="25%"><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
	<td class="grilla-tab-fila-titulo" align='left' width="25%">Neto</td>
	<td class="grilla-tab-fila-campo" align='left' width="25%"><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva</td>
	<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
	<td class="grilla-tab-fila-titulo" align='left'>Iva</td>
	<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_compra_1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total</td>
	<td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
	<td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total</td>
	<td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_compra_1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_credito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_credito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_credito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_credito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_credito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_credito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_debito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['neto_debito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_debito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_debito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder; border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_debito_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder; border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['total_debito_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" colspan="2" align='right'></td>
	<td class="grilla-tab-fila-titulo" 	align='left'>Exento</td>
	<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['exento_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" colspan="4" align='center'>Resumen</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva D&eacute;bito</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_venta'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva Cr&eacute;dito</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_compra'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'></td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left' style="font-weight:bolder; border:2px solid #000"><?php echo ((is_array($_tmp=$this->_tpl_vars['iva_resultado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Ret. 2&ordf; Categor&iacute;a</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['total_bh'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>PPM <?php echo $this->_tpl_vars['porcentaje_ppm']; ?>
%</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'><?php echo smarty_function_math(array('equation' => "x * (y/100)",'x' => $this->_tpl_vars['neto_venta'],'y' => $this->_tpl_vars['porcentaje_ppm'],'format' => "%.0f"), $this);?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Total a pagar</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left' style="font-weight:bolder; border:2px solid #000"><?php echo smarty_function_math(array('equation' => "x+y+(z * (a/100))",'x' => $this->_tpl_vars['iva_resultado'],'y' => $this->_tpl_vars['total_bh'],'z' => $this->_tpl_vars['neto_venta'],'a' => $this->_tpl_vars['porcentaje_ppm'],'format' => "%.0f"), $this);?>
</td>
</tr>
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


