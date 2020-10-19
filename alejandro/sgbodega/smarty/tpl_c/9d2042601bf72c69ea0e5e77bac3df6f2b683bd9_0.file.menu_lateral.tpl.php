<?php
/* Smarty version 3.1.33, created on 2019-08-05 17:11:50
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/menu_lateral.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d489b96a19322_78889439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d2042601bf72c69ea0e5e77bac3df6f2b683bd9' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/menu_lateral.tpl',
      1 => 1563312311,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d489b96a19322_78889439 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body onload="xajax_CargaInicial(xajax.getFormValues('Form1'),<?php echo $_smarty_tpl->tpl_vars['grupo']->value;?>
);"style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">

		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
		
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left">
								<td class="tabla-alycar-fila-informa-requerida-contrato-cabecera">
									<div style="cursor: pointer" onclick="xajax_Link(xajax.getFormValues('Form1'));"><?php echo $_smarty_tpl->tpl_vars['TITULO_MENU']->value;?>
</div>
								</td>
							</tr>
						</table>
						<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							<?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
								<tr align="left">		
									<td class="tabla-alycar-label" style="width: 30%"><a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['link'];?>
');"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['descripcion'];?>
</a></td>
								</tr>
							<?php
}
}
?>
						</table>
					</td>
				</tr>
			</table>
			
		</div>
	</form>
		

</body>
</html>
<?php }
}
