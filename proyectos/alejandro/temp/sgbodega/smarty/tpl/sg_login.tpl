<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
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
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">
									<img src="../images/user.png">&nbsp;&nbsp;
									Control de Acceso
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
										<input type="button" name="btnIngresar" value="Ingresar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>