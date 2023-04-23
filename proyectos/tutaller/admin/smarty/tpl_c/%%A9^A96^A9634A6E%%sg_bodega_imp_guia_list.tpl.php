<?php /* Smarty version 2.6.18, created on 2015-06-22 20:06:08
         compiled from sg_bodega_imp_guia_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_bodega_imp_guia_list.tpl', 90, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:8px !important;">

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
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Fecha:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
</td>
	</tr>
	<?php if (( ( $this->_tpl_vars['movim'] == '1' ) || ( $this->_tpl_vars['movim'] == '3' ) )): ?>	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Proveedor:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['proveedor']; ?>
</td>
		</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>OC:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['oc']; ?>
</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Factura:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['factura']; ?>
</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Guia Despacho:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['guia_despacho']; ?>
</td>
	</tr>
	
	<?php endif; ?>
    <tr>
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Gu�a:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['guia']; ?>
</td>
	</tr>	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Movimiento:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['movimiento']; ?>
</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Bodega:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['bodega']; ?>
</td>
	</tr>
	<?php if (( $this->_tpl_vars['movim'] == '9' )): ?>	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['trabajador']; ?>
</td>
		</tr>
	<?php endif; ?>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Observaci�n:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['obs']; ?>
</td>
	</tr>
	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Usuario:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Empresa:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
	</tr>
	<?php if (( ( $this->_tpl_vars['movim'] == '2' ) || ( $this->_tpl_vars['movim'] == '4' ) || ( $this->_tpl_vars['movim'] == '6' ) )): ?>	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['vendedor']; ?>
</td>
		</tr>
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Patente:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['vendedor']; ?>
</td>
		</tr>
		<?php endif; ?>
	<?php if (( $this->_tpl_vars['movim'] == '6' )): ?>	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Folio:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['folio']; ?>
</td>
		</tr>
	<?php endif; ?>
	
	
	</tr>

<tr>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Codigo</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Descripcion</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Cantidad</td>
</tr>

<?php unset($this->_sections['registrosDet']);
$this->_sections['registrosDet']['name'] = 'registrosDet';
$this->_sections['registrosDet']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDet']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDet']['show'] = true;
$this->_sections['registrosDet']['max'] = $this->_sections['registrosDet']['loop'];
$this->_sections['registrosDet']['step'] = 1;
$this->_sections['registrosDet']['start'] = $this->_sections['registrosDet']['step'] > 0 ? 0 : $this->_sections['registrosDet']['loop']-1;
if ($this->_sections['registrosDet']['show']) {
    $this->_sections['registrosDet']['total'] = $this->_sections['registrosDet']['loop'];
    if ($this->_sections['registrosDet']['total'] == 0)
        $this->_sections['registrosDet']['show'] = false;
} else
    $this->_sections['registrosDet']['total'] = 0;
if ($this->_sections['registrosDet']['show']):

            for ($this->_sections['registrosDet']['index'] = $this->_sections['registrosDet']['start'], $this->_sections['registrosDet']['iteration'] = 1;
                 $this->_sections['registrosDet']['iteration'] <= $this->_sections['registrosDet']['total'];
                 $this->_sections['registrosDet']['index'] += $this->_sections['registrosDet']['step'], $this->_sections['registrosDet']['iteration']++):
$this->_sections['registrosDet']['rownum'] = $this->_sections['registrosDet']['iteration'];
$this->_sections['registrosDet']['index_prev'] = $this->_sections['registrosDet']['index'] - $this->_sections['registrosDet']['step'];
$this->_sections['registrosDet']['index_next'] = $this->_sections['registrosDet']['index'] + $this->_sections['registrosDet']['step'];
$this->_sections['registrosDet']['first']      = ($this->_sections['registrosDet']['iteration'] == 1);
$this->_sections['registrosDet']['last']       = ($this->_sections['registrosDet']['iteration'] == $this->_sections['registrosDet']['total']);
?>
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	
	</tr>
		
<?php endfor; endif; ?>

<tr>
	<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo-pequenio" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_CANTIDAD'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
</tr>
</table>

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Emisor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Revisor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Receptor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Chofer</td>
</tr>

<tr>
	<td colspan='8' class="grilla-tab-fila-titulo-pequenio">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
<?php endfor; endif; ?>

</table>
</div>


