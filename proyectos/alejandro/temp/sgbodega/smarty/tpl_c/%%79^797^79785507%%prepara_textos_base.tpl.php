<?php /* Smarty version 2.6.18, created on 2010-10-31 17:00:31
         compiled from prepara_textos_base.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Textos Base Para Finiquitos </title>
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
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">
										Textos Base Para Finiquitos
									</td> 
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Finiquito:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboFiniquito" name="OBLIcboFiniquito" onchange="xajax_CargaTextoBase(xajax.getFormValues('Form1'));"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Compañia:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboCompania" name="OBLIcboCompania" onchange="xajax_CargaTextoBase(xajax.getFormValues('Form1'));">
											<option value='- - Seleccione - -'>- - Seleccione - -</option>
											<option value='1'>RENTA</option>
											<option value='2'>RSA</option>
											<option value='3'>MAPFRE</option>
											<option value='4'>ALDO ROMERO</option>
										</SELECT>
									</td>	
								</TR>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">
										Parámetros Disponibles
									</td> 
								</tr>
								<tr align="left">
									<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Siniestro:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="OBLI-txtSiniestro" name="OBLI-txtSiniestro" value='<SINIESTRO>' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Compañía:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtCompaniaLarga" name="txtCompaniaLarga" value='<COMPANIA_NOMBRE>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>	
										</TR>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Compañía Abrev.:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtCompania" name="txtCompania" value='<COMPANIA_DESC>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>	
										</TR>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Rut Asegurado:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="OBLItxtRutAsegurado" name="OBLItxtRutAsegurado" value='<RUT_ASEGURADO>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Asegurado:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="OBLItxtNombreAsegurado" name="OBLItxtNombreAsegurado" value='<NOMBRE_ASEGURADO>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Poliza:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtPoliza" name="txtPoliza" value='<POLIZA>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Tipo:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtTipo" name="txtTipo" value='<TIPO>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Rut Conductor:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtRutConductor" name="txtRutConductor" value='<RUT_CONDUCTOR>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
									</table>
									<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Marca:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtMarca" name="txtMarca" value='<MARCA>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Modelo:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtModelo" name="txtModelo" value='<MODELO>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">PPU:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="OBLItxtPatente" name="OBLItxtPatente" value='<PATENTE>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Año:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="OBLItxtAnio" name="OBLItxtAnio" value='<ANIO>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Nº Motor:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtNumMotor" name="txtNumMotor" value='<NUM_MOTOR>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Nº Chasis:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtNumChasis" name="txtNumChasis" value='<NUM_CHASIS>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Fecha Actual:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtFechaActual" name="txtFechaActual" value='<FECHA>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
											</td>
										</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">Conductor:<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<INPUT type="text" id="txtNombreConductor" name="txtNombreConductor" value='<CONDUCTOR>' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
											</td>
										</tr>
									</table>
								
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td>	
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Texto Base</td>
								</tr>

								<tr align="left">
									<td colspan='2' class="tabla-alycar-texto" style="width: 80%">
										<textarea id="OBLItxtTexto" name="OBLItxtTexto" cols="100" rows="30" style="width: 98%"><?php echo $this->_tpl_vars['TEXTO']; ?>
</textarea>
									</td>
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										<!--&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria-->
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