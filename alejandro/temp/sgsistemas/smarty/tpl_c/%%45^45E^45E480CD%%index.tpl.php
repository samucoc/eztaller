<?php /* Smarty version 2.6.18, created on 2010-11-30 11:52:59
         compiled from index.tpl */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<HEAD>
		<?php echo $this->_tpl_vars['xajax_js']; ?>
	
		
		<title>Login</title>
		<!-- librerias para submodal -->
		<link rel="stylesheet" type="text/css" href="submodallogin/style.css" />
		<link rel="stylesheet" type="text/css" href="submodallogin/subModal.css" />
		<script type="text/javascript" src="submodallogin/common.js"></script>
		<script type="text/javascript" src="submodallogin/subModal.js"></script>
	
	</head>
	<frameset cols="1%,*,1%" border="0" frameborder="0" y framespacing="0">

		<frame name="1" frameborder="0" border="0" src="">
		
		<frameset rows="75,*" border="0" frameborder="0" y framespacing="0">
				
				<frame name="superior" src="top.php" frameborder="0" scrolling="no" noresize>
				
				<frameset cols="40%,*" border="0" frameborder="0" y framespacing="0">

						<frame name="lateral" frameborder="0" border="0" src="vacio.php" SCROLLING="no">
						<frame name="principal" frameborder="0" border="0" src="valida_usuario.php">
				
				</frameset>
			
			
		</frameset>
		
		<frame name="2" frameborder="0" border="0" src="">

	</frameset>

	<body onload="xajax_MuestraLogin(xajax.getFormValues('Form1'));" style="background:#000000;">
		<form id="Form1" name="Form1" method="post" runat="server">
			<table border='0' cellpadding="0" cellspacing="0" style="WIDTH: 100%;">
				<tr align="left" valign="middle">
					<td><img src="../images/logo_ocarrol.jpg" height='50' width='500'></td>
				</tr>
			</table>
		</form>
	</body>
	
</html>
