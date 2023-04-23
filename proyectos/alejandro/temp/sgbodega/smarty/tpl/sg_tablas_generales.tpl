<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
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
										<INPUT type="hidden" id="txtTabla" name="txtTabla" value='{$TBL}'>
										{$TIT}
									</td> 
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodigo" name="txtCodigo" value='' maxLength="7" size="7" readonly>
										<label class="comentario">Este Código se Asignará Automáticamente</label>
									</td>
								</TR>
								
								{if ($TBL == 'sectores')}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Zona:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<SELECT id="OBLI-cboZona" name="OBLI-cboZona" onKeyPress="return Tabula(this, event, 0)"></SELECT>
										</td>	
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								{/if}
								{if ($TBL == 'vendedores')}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Apellidos - Nombres:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Comisión:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtComisionEnt" name="OBLI-txtComisionEnt" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="2" size="4">
											,
											<INPUT type="text" id="OBLI-txtComisionDec" name="OBLI-txtComisionDec" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="2" size="4">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Activo:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<SELECT id="OBLI-cboActivo" name="OBLI-cboActivo" onKeyPress="return Tabula(this, event, 0)">
												<option value='SI'>SI</option>
												<option value='SI'>SI</option>
												<option value='NO'>NO</option>
											</SELECT>
										</td>	
									</TR>
								{/if}
								{if ($TBL == 'cobrador') OR ($TBL == 'supervisor')}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Nombre:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Comisión:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtComisionEnt" name="OBLI-txtComisionEnt" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="2" size="4">
											,
											<INPUT type="text" id="OBLI-txtComisionDec" name="OBLI-txtComisionDec" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="2" size="4">
										</td>
									</TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Activo:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<SELECT id="OBLI-cboActivo" name="OBLI-cboActivo" onKeyPress="return Tabula(this, event, 0)">
												<option value='SI'>SI</option>
												<option value='SI'>SI</option>
												<option value='NO'>NO</option>
											</SELECT>
										</td>	
									</TR>
								{/if}
								{if ($TBL == 'familias')}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								{/if}
								{if ($TBL == 'subfamilias')}
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
								{/if}
								{if (($TBL == 'marcas') OR ($TBL == 'clasificacion') OR ($TBL == 'tramos'))}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripción:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtNombre" name="OBLI-txtNombre" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
										</td>
									</TR>
								{/if}
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
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