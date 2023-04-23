<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Toma Inventario </title>
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
	
		{literal}
			<script type="text/javascript">
				$(function($) { 
					$('#OBLItxtCierre').mask("99/99/9999");
					}
				); 		
			</script>
		{/literal}
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			
			<div id="divcontenedor" align="left" style="display: block; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Cierra Toma Inventario</td>
								</tr>
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Ultimo Cierre:</td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="txtUltCierre" name="txtUltCierre" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Fecha Cierre:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLItxtCierre" name="OBLItxtCierre" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>	
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" id="btnGrabar" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
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