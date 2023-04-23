<?php /* Smarty version 2.6.18, created on 2018-02-16 11:38:29
         compiled from sg_mant_tablas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_mant_tablas_list.tpl', 327, false),)), $this); ?>
<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<!--

	<tr>

    	<td colspan="10" class="grilla-tab-fila-titulo" align='right'>Cantidad de filas: <?php echo $this->_tpl_vars['cant_filas']; ?>
</td>

	</tr>

-->

	<tr>

    	<td colspan="10" class="grilla-tab-fila-titulo" align='center'>Listado de <?php echo $this->_tpl_vars['TITULO_TABLA']; ?>
</td>

	</tr>

<?php if (( $this->_tpl_vars['TBL'] == 'vehiculos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Marca</td>

		<td class="grilla-tab-fila-titulo" align='center'>Modelo</td>

		<td class="grilla-tab-fila-titulo" align='center'>A&ntilde;o</td>

		<td class="grilla-tab-fila-titulo" align='center'>Color</td>

		<td class="grilla-tab-fila-titulo" align='center'>Tipo Vehiculo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Patente </td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha adquisicion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Empresa </td>

		<td class="grilla-tab-fila-titulo" align='center'>Valor Comercial</td>

		<td class="grilla-tab-fila-titulo" align='center'>Valor Comercial Actual</td>

		<td class="grilla-tab-fila-titulo" align='center'>Rendimiento por Litro </td>

		<td class="grilla-tab-fila-titulo" align='center'>Tipo de Combustible</td>

		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>

		<td class="grilla-tab-fila-titulo" align='center'>Mes Revision Tecnica</td>

		<td class="grilla-tab-fila-titulo" align='center'>Empresa Aseguradora</td>

		<!--<td class="grilla-tab-fila-titulo" align='center'>Monto Prima</td>

		<td class="grilla-tab-fila-titulo" align='center'>Mes de Termino de seguro</td>-->

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['marca']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['modelo']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['color']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_veh']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_adq']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor_actual']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rend']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_comb']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['estado']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rev_tec']; ?>
</a>

                        </td>

			<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['emp_aseg']; ?>
</a>

                        </td>

			<!--<td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mont_prima']; ?>
</a>

                        </td>

                        <td class="grilla-tab-fila-campo">

                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['term_seguro']; ?>
</a>

                        </td>-->

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'personas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ape_pat']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ape_mat']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'usuarios' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>

		<td class="grilla-tab-fila-titulo" align='center'>Password</td>

		<td class="grilla-tab-fila-titulo" align='center'>Perfil</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');">XXXXXXXXXXX</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['perfil']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'perfiles' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'usuarios_perfiles_menu' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Perfil</td>

		<td class="grilla-tab-fila-titulo" align='center'>Menu</td>

		<td class="grilla-tab-fila-titulo" align='center'>Pagina</td>

		<td class="grilla-tab-fila-titulo" align='center'>Orden</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['perfil']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['menu']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['pagina']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['orden']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'menues' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Perfil Acceso</td>

		<td class="grilla-tab-fila-titulo" align='center'>Orden Menu</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['perfil']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['orden']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'menues_hijos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Menu Padre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Sub Menu</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Link de acceso</td>

		<td class="grilla-tab-fila-titulo" align='center'>Perfil de acceso</td>

		<td class="grilla-tab-fila-titulo" align='center'>Orden</td>

		<td class="grilla-tab-fila-titulo" align='center'>Mostrar</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['padre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sub_menu']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['link']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['perfil']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['orden']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mostrar']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'correos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>

		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['correo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'Horas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Tipo de Horario</td>

		<td class="grilla-tab-fila-titulo" align='center'>Codigo Hora</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_horario']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo_hora']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'proveedor' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>DV</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Giro</td>

		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['email']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'clientes' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Razon Social</td>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>

		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['email']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>



<?php elseif (( $this->_tpl_vars['TBL'] == 'prestadores' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Razon Social</td>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>

		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['email']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'trabajadores_tienen_cargas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha Nacimiento</td>

		<td class="grilla-tab-fila-titulo" align='center'>Edad</td>

		<td class="grilla-tab-fila-titulo" align='center'>Parentesco</td>

		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_paterno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_materno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_nac'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['edad']; ?>
</a></td>

            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['parentesco']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['estado']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'alumnos' )): ?>

    <tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nro Lista</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>

		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombres']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Postulantes' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>

		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombres']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Profesores' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>

		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Especialidad</td>  

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_paterno']; ?>
 <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_materno']; ?>
, <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion']; ?>
</a></td>

            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Apoderados' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>

		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_paterno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apellido_materno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion']; ?>
</a></td>

            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Niveles' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre Nivel</td>

		<td class="grilla-tab-fila-titulo" align='center'>Resolucion Autoriza</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha Resolucion Autoriza</td>

		<td class="grilla-tab-fila-titulo" align='center'>Resolucion Cierre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha Resolucion Cierre</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_nivel']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['resolucion_autoriza']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaResolucionAutoriza']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ResolucionCierre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaResolucionCierre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Asignaturas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>

		<td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>

		<td class="grilla-tab-fila-titulo" align='center'>Profesor</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Pruebas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>

		<td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>

		<td class="grilla-tab-fila-titulo" align='center'>Profesor</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion Prueba</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion_prueba']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Retiros' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Curso Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['observacion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'HojasDeVida' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>

		<td class="grilla-tab-fila-titulo" align='center' width="5%">Tipo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Motivo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo'] == 'Positiva'): ?>

            <td class="grilla-tab-fila-campo" style="background-color:#C30" onclick=	"xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');">

            </td>

			<?php else: ?>	

            <td class="grilla-tab-fila-campo" style="background-color:#356AA0" onclick=	"xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');">

            </td>

            <?php endif; ?>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['motivo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['observacion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Eximisiones' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Talonarios' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Desde</td>

		<td class="grilla-tab-fila-titulo" align='center'>Hasta</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>

		<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['desde']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['hasta']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['observacion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Movimientos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Numero Boleta</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>

		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Valor</td>

		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>

		<td class="grilla-tab-fila-titulo" align='center'>Tipo Pago</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_boleta']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['estado']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_pago']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<?php if (( $this->_tpl_vars['USUARIO'] == 'sige' )): ?>

					<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

				<?php endif; ?>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Becas' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Cursos</td>

		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Incorporacion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>

		<td class="grilla-tab-fila-titulo" align='center'>Tipo Beca</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['periodo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['incorporacion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['colegiatura']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_beca']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'TipoBeca' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Cuota 0</td>

		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cuota_0']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['colegiatura']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Compromisos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>

		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['periodo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Bitacoras' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha Gestion</td>

		<td class="grilla-tab-fila-titulo" align='center' style="width: 50%">Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Fecha Compromiso</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');">

				<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_1'] <> '0000-00-00'): ?>

				<?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_1'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>


				<?php else: ?>

				<?php endif; ?>

			</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Aranceles' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>

		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Cuota Inicial</td>

		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['periodo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['incorporacion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['colegiatura']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Cursos' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'>Arancel</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['arancel']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php elseif (( $this->_tpl_vars['TBL'] == 'Devoluciones' )): ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Nro Devolucion</td>
		
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		
		<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
		
		<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
		
		<td class="grilla-tab-fila-titulo" align='center'>Glosa</td>
		
		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numero']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_boleta']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['glosa']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php else: ?>

	<tr>

		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>

		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

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

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
</a></td>

			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['desc']; ?>
</a></td>

			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">

				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');" width="16"></a>

			</td>

		</tr>

	<?php endfor; endif; ?>

<?php endif; ?>

	<tr>

    <td colspan='16' class="grilla-tab-fila-titulo">

    	<a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>

    </td>

    

    </tr>

</table>

</div>