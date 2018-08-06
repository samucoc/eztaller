<?php /* Smarty version 2.6.18, created on 2010-10-09 18:35:22
         compiled from sg_finiquito01.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Finiquito </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
 		
		<?php echo '
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements[\'v_pivot_excel\'].value=document.getElementById(\'pivot\').innerHTML;
			document.getElementById(nombreformulario).target = \'iframe_pivot_excel\'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById(\'pivot\').innerHTML="";document.getElementById(\'pivot_filter\').innerHTML="";document.getElementById(\'div_grafico\').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		</script> 

		'; ?>

	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			
			<div id="divcontenedor" align="left" style="display: block; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%">&nbsp;&nbsp;<img src="../images/My-Documents_48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; <?php echo $this->_tpl_vars['TITULO']; ?>
</label></td>
								</tr>
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Siniestro:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="hidden" id="txtSiniNcorr" name="txtSiniNcorr" value=''>
										<INPUT type="text" id="OBLI-txtSiniestro" name="OBLI-txtSiniestro" value='<?php echo $this->_tpl_vars['SINIESTRO']; ?>
' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Compañía:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCompaniaLarga" name="txtCompaniaLarga" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Compañía Abrev.:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCompania" name="txtCompania" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Asegurado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtRutAsegurado" name="OBLItxtRutAsegurado" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Asegurado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtNombreAsegurado" name="OBLItxtNombreAsegurado" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Poliza:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtPoliza" name="txtPoliza" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Tipo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTipo" name="txtTipo" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Conductor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtRutConductor" name="txtRutConductor" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Marca:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtMarca" name="txtMarca" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Modelo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtModelo" name="txtModelo" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">PPU:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtPatente" name="OBLItxtPatente" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Año:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtAnio" name="OBLItxtAnio" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Motor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumMotor" name="txtNumMotor" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Chasis:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumChasis" name="txtNumChasis" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha Actual:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFechaActual" name="txtFechaActual" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Conductor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNombreConductor" name="txtNombreConductor" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" style="width: 98%">
									</td>
								</tr>
							</table>
						
						<td>
					</tr>		
					<tr>
						<td>	
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Texto del Documento</td>
								</tr>

								<tr align="left">
									<td colspan='2' class="tabla-alycar-texto" style="width: 80%">
										<textarea id="txtTexto" name="txtTexto" cols="100" rows="30" style="width: 98%"><?php echo $this->_tpl_vars['TEXTO']; ?>
</textarea>
									</td>
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" id="btnGenerar" name="btnGenerar" value="Generar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" id="btnResetear" name="btnResetear" value="Resetear Finiquito" class="boton" onclick="xajax_ResetearFiniquito(xajax.getFormValues('Form1'));">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divabonos'><div>
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