<?php /* Smarty version 2.6.18, created on 2010-11-30 11:57:05
         compiled from frame_login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<?php echo $this->_tpl_vars['xajax_js']; ?>

	
	<title>User</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body onload="xajax_CargaInicial(xajax.getFormValues('Form1'));"style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">

		<div id="divcontenedor" align="left" style="margin:1px; padding: 1px;">
		
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left">		
								<td class="tabla-alycar-label" style="width: 30%">
									Usuario Actual:<br>
									<?php echo $this->_tpl_vars['NOMBRE_USUARIO']; ?>
<br>
									<?php echo $this->_tpl_vars['SUCURSAL_USUARIO']; ?>

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