<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Contratos </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 90%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%"><img src="../images/User-group-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Mantenedor de Usuarios</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Id. Usuario:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="hidden" id="txtNcorrOculto" name="txtNcorrOculto" value=''>
										<INPUT type="text" id="OBLI-txtLogin" name="OBLI-txtLogin" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="20">
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('busqueda.php?entidad=4', 'Busqueda de Usuario', 550, 350, null);"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Contraseña:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtPass" name="OBLI-txtPass" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="20">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nombre:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Perfil<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="OBLI-cboPerfil" name="OBLI-cboPerfil" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Celular:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCelular" name="txtCelular" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="15">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Teléfono 1:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFono1" name="txtFono1" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="15">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Teléfono 2:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFono2" name="txtFono2" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="15">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Mail:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtMail" name="txtMail" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="obligatorio"> (*) </label>Informacion Obligatoria
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