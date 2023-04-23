<?php
/* Smarty version 3.1.33, created on 2020-05-05 22:47:36
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_inasistencias_ingresar_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5eb22548ea9e76_30834555',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e0fe7bfd2019aa36a8c547677450f5ab34f3127d' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_inasistencias_ingresar_list.tpl',
      1 => 1579573421,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5eb22548ea9e76_30834555 (Smarty_Internal_Template $_smarty_tpl) {
?><table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $_smarty_tpl->tpl_vars['periodo']->value;?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $_smarty_tpl->tpl_vars['curso']->value;?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Mes
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $_smarty_tpl->tpl_vars['mes']->value;?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Nro Lista
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Alumno
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value;?>
">
			Fecha
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Total
		</td>
	</tr>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php
$__section_dias_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrDias']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_dias_0_total = $__section_dias_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_dias'] = new Smarty_Variable(array());
if ($__section_dias_0_total !== 0) {
for ($__section_dias_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] = 0; $__section_dias_0_iteration <= $__section_dias_0_total; $__section_dias_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrDias']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] : null)]['nro_dia'];?>

		</td>
        <?php
}
}
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
<?php
$__section_registros_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_1_total = $__section_registros_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_1_total !== 0) {
for ($__section_registros_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_1_iteration <= $__section_registros_1_total; $__section_registros_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="10%">
			<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] != '0000-00-00') {?>
				<strike>
				<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['numero_lista'];?>

				</strike>
			<?php } else { ?>
				<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['numero_lista'];?>

			<?php }?>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="20%">
			<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] != '0000-00-00') {?>
				<strike>
				<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

				</strike>
			<?php } else { ?>
				<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

			<?php }?>
		</td>
		<?php
$__section_registrosDetalle_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_2_total = $__section_registrosDetalle_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_2_total !== 0) {
for ($__section_registrosDetalle_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_2_iteration <= $__section_registrosDetalle_2_total; $__section_registrosDetalle_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
        	<?php if (($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno']) && ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nro_lista'] == $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['numero_lista'])) {?>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['domingo'] == 'SI' || $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['festivo'] == 'SI') {?>
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#ffcccc">
                    </td>
                <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['atraso'] == 'SI') {?>
                    	<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] != '0000-00-00') {?>
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
		                		<strike>
		                    	X
		                    	</strike>
		                    </td>
						<?php } else { ?>
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px"  onclick="xajax_EliminarInasistencia(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'];?>
');" >
		                    	X
		                    </td>
						<?php }?>
                    <?php } else { ?>
	                    <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['cont_atraso'] > 0) {?>
	                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
	                    	<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['cont_atraso'];?>

	                    </td>
	                    <?php } else { ?>
	                    	<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] != '0000-00-00') {?>
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
	                    		</td>							
	                    	<?php } else { ?>
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'];?>
');">
			                    </td>
	                    	<?php }?>
	                    
	                    <?php }?>
                    <?php }?>
                <?php }?>
            <?php }?>
        <?php
}
}
?>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['contador'];?>

        </td>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'];?>

        </td>
		<td class="grilla-tab-fila-campo-pequenio" align='center' width="10px" height="10px">
			<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'] == '0000000') {?>
			<?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] < '85') {?>
					<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
				<?php } elseif ((($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] >= '85') && ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] <= '90'))) {?>
					<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
				<?php } else { ?>
					<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
				<?php }?>
			<?php }?>
		</td>
        
	</tr>
<?php
}
}
?>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php
$__section_dias_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrDias']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_dias_3_total = $__section_dias_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_dias'] = new Smarty_Variable(array());
if ($__section_dias_3_total !== 0) {
for ($__section_dias_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] = 0; $__section_dias_3_iteration <= $__section_dias_3_total; $__section_dias_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $_smarty_tpl->tpl_vars['arrDias']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] : null)]['nro_dia'];?>

		</td>
        <?php
}
}
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Presentes</td>
		<?php
$__section_presente_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrPresentes']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_presente_4_total = $__section_presente_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_presente'] = new Smarty_Variable(array());
if ($__section_presente_4_total !== 0) {
for ($__section_presente_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_presente']->value['index'] = 0; $__section_presente_4_iteration <= $__section_presente_4_total; $__section_presente_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_presente']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $_smarty_tpl->tpl_vars['arrPresentes']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_presente']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_presente']->value['index'] : null)]['cantidad'];?>

		</td>
        <?php
}
}
?>
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Ausentes</td>
		<?php
$__section_ausente_5_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrAusentes']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_ausente_5_total = $__section_ausente_5_loop;
$_smarty_tpl->tpl_vars['__smarty_section_ausente'] = new Smarty_Variable(array());
if ($__section_ausente_5_total !== 0) {
for ($__section_ausente_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_ausente']->value['index'] = 0; $__section_ausente_5_iteration <= $__section_ausente_5_total; $__section_ausente_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_ausente']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $_smarty_tpl->tpl_vars['arrAusentes']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_ausente']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_ausente']->value['index'] : null)]['cantidad'];?>

		</td>
        <?php
}
}
?>
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Matricula</td>
		<?php
$__section_matricula_6_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrMatricula']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_matricula_6_total = $__section_matricula_6_loop;
$_smarty_tpl->tpl_vars['__smarty_section_matricula'] = new Smarty_Variable(array());
if ($__section_matricula_6_total !== 0) {
for ($__section_matricula_6_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_matricula']->value['index'] = 0; $__section_matricula_6_iteration <= $__section_matricula_6_total; $__section_matricula_6_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_matricula']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $_smarty_tpl->tpl_vars['arrMatricula']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_matricula']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_matricula']->value['index'] : null)]['cantidad'];?>

		</td>
        <?php
}
}
?>
	</tr>
    
<tr>
	<td colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value+5;?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>
<?php }
}
