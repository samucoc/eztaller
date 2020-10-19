<?php /* Smarty version 2.6.18, created on 2010-11-30 11:53:00
         compiled from valida_usuario.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->_tpl_vars['xajax_js']; ?>

<title></title>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
	</HEAD>

	<body style="background:#ffffff;"> 
		<form action="valida_usuario.php" method="post" name="mainform" id="mainform">
			
			<br><br><br><br><br>
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 40%; float: left; border: 1pt solid #000000; background:#ffffff">
					<tr>
						<td>
							
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%"><img src="../images/Users-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Iniciar Sesión</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">		
									<td class="tabla-alycar-label" style="width: 30%">Usuario:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtUsuario" name="txtUsuario" maxLength="20" size="22">
									</td>
								</tr>
								<tr align="left">		
									<td class="tabla-alycar-label" style="width: 30%">Password:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="password" id="txtPassword" name="txtPassword" maxLength="20" size="22">
									</td>
								</tr>
								<tr align="center">		
									<td colspan="6" class="tabla-alycar-fila-botones" align="center">
										<INPUT type="button" class='boton' value='Iniciar Sesión' onclick="xajax_ValidaUsuario(xajax.getFormValues('mainform'));">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
			
		</form>
	</body>
</html>