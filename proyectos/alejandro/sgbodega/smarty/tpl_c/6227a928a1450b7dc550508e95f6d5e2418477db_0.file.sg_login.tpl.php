<?php
/* Smarty version 3.1.33, created on 2020-10-18 23:02:11
  from 'D:\xampp\htdocs\eztaller\alejandro\sgbodega\smarty\tpl\sg_login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f8cf3a3e6c5e3_16486312',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6227a928a1450b7dc550508e95f6d5e2418477db' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eztaller\\alejandro\\sgbodega\\smarty\\tpl\\sg_login.tpl',
      1 => 1603072927,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8cf3a3e6c5e3_16486312 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<link rel="icon" href="../images/ficha-alumno.ico" type="image/x-icon" />	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="center" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 96%; float: left; border: 5pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							
							<!--
							<table border="0" cellpadding="0" cellspacing="0" style="width: 28%; float: left;">
								<tr align="center" valign="middle">
									<td><img src="../images/logo_ar.png"></td>
								</tr>
							</table>
							!-->
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%; float: left;">
								<tr align="left">
									<td colspan="2" align="center">
                                    	<img src="../images/Identidad-Arcoiris-2020-HD.jpg" width="100"/>
									</td>
								</TR>
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato" align="center">
									<img src="../images/user.png">&nbsp;&nbsp;
										<span style="text-align: center; padding-left: 20%">Sistema Prototipo</span>
									</td> 
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Usuario:</td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtUsuario" name="OBLI-txtUsuario" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="30" style="width: 98%">
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Password:</td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="password" id="OBLI-txtPassword" name="OBLI-txtPassword" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="30" style="width: 98%">
									</td>
								</TR>
								<tr align="left">
									<td colspan='2' class="tabla-alycar-fila-botones-der">
										<a href="#"   onclick="xajax_Grabar(xajax.getFormValues('Form1'));" >
											<img src="../images/basicos/ingreso.png" width="32" title="Ingresar"/>
										</a>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML><?php }
}
