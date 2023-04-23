<?php /* Smarty version 2.6.18, created on 2010-10-11 22:50:31
         compiled from sg_tablas_generales.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Asignación de Accesorios </title>
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
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1')), xajax_CargaListado(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 90%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">
										<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $this->_tpl_vars['TBL']; ?>
'>
										<?php echo $this->_tpl_vars['TIT']; ?>

									</td> 
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodigo" name="txtCodigo" value='' maxLength="7" size="7" readonly>
										<label class="comentario">Este Código se Asignará Automáticamente</label>
									</td>
								</TR>
								
								<?php if (( $this->_tpl_vars['TBL'] == 'liquidadores' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Mail:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtMail" name="txtMail" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtObs" name="txtObs" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( ( $this->_tpl_vars['TBL'] == 'vehiculos' ) || ( $this->_tpl_vars['TBL'] == 'marcas' ) )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtObs" name="txtObs" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( $this->_tpl_vars['TBL'] == 'modelos' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 20%">Marca:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 80%">
											<SELECT id="OBLIcboMarca" name="OBLIcboMarca"></SELECT>
										</td>	
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtObs" name="txtObs" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( $this->_tpl_vars['TBL'] == 'talleres' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Dirección:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDireccion" name="OBLI-txtDireccion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Fono:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtFono" name="OBLI-txtFono" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="15" size="15">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Mail:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtMail" name="OBLI-txtMail" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="50" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtObs" name="txtObs" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								
								<?php if (( $this->_tpl_vars['TBL'] == 'companias' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Abreviación:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtAbreviacion" name="OBLI-txtAbreviacion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" size="10">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Nombre o Razón Social:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Rut:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtRut" name="OBLI-txtRut" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="8" size="10">
											<INPUT type="text" id="OBLI-txtDig" name="OBLI-txtDig" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="1" size="1">
										</td>
									</tr>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Dirección:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDireccion" name="OBLI-txtDireccion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Giro:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtGiro" name="OBLI-txtGiro" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtObs" name="txtObs" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( $this->_tpl_vars['TBL'] == 'claves_reparaciones' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Abreviación:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtAbreviacion" name="OBLI-txtAbreviacion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" size="10">
										</td>
									</TR>
								<?php endif; ?>
								
								<?php if (( $this->_tpl_vars['TBL'] == 'familias' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( $this->_tpl_vars['TBL'] == 'subfamilias' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Familia:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<SELECT id="OBLI-cboFamilia" name="OBLI-cboFamilia" onKeyPress="return Tabula(this, event, 0)"></SELECT>
										</td>	
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								<?php if (( $this->_tpl_vars['TBL'] == 'documentos' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								<?php endif; ?>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										<!--&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria-->
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
		</form>
	</body>
</HTML>