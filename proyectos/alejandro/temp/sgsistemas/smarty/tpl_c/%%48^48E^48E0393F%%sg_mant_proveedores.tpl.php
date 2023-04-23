<?php /* Smarty version 2.6.18, created on 2010-12-07 17:23:38
         compiled from sg_mant_proveedores.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/User-group-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Mantenedor de Proveedores</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" value='<?php echo $this->_tpl_vars['NCORR']; ?>
' readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtRut" name="OBLI-txtRut" onKeyPress="return SoloNumeros(this, event, 0)" value='<?php echo $this->_tpl_vars['RUT_CLIENTE']; ?>
' maxLength="8" size="10">
										<INPUT type="text" id="OBLI-txtDig" name="OBLI-txtDig" onKeyPress="return Tabula(this, event, 0)" value='<?php echo $this->_tpl_vars['DV']; ?>
' maxLength="1" size="1">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nombre / Razón Social<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Giro:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtGiro" name="OBLI-txtGiro" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Dirección:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtDireccion" name="OBLI-txtDireccion" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Ciudad:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtCiudad" name="OBLI-txtCiudad" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fono 1:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFono1" name="txtFono1" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fono 2:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFono2" name="txtFono2" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fax:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFax" name="txtFax" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="15" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Contacto:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtContacto" name="txtContacto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
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
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_mant_proveedores.php';" > 
										<input type="button" name="btnBuscar" value="Buscar >>" class="boton" onClick="javascript: document.location.href='sg_busqueda.php?tbl=proveedores';" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
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