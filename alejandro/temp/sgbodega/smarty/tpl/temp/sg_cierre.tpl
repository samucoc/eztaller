<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
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
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
			
		{literal}
		
		<script type="text/javascript">
			$(function($) { 
				$('#OBLItxtFecha').mask("99/99/9999");
				}
			); 		
		</script>

		{/literal}
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/1day-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Establecer Cierre</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Empresa:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboEmpresa" name="OBLIcboEmpresa" onchange="xajax_MuestraUltCierre(xajax.getFormValues('Form1'));" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Ultimo Cierre:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="txtUltimoCierre" name="txtUltimoCierre" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="10" size="10" readonly>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Fecha Cierre:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="OBLItxtFecha" name="OBLItxtFecha" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='10'>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Periodo Asociado:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										Mes:
										<SELECT id="cboMes" name="cboMes" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='1'>Enero</option>
											<option value='2'>Febrero</option>
											<option value='3'>Marzo</option>
											<option value='4'>Abril</option>
											<option value='5'>Mayo</option>
											<option value='6'>Junio</option>
											<option value='7'>Julio</option>
											<option value='8'>Agosto</option>
											<option value='9'>Septiembre</option>
											<option value='10'>Octubre</option>
											<option value='11'>Noviembre</option>
											<option value='12'>Diciembre</option>
										</SELECT>
										&nbsp;&nbsp;
										A�o:
										<SELECT id="cboAnio" name="cboAnio" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='2010'>2010</option>
											<option value='2011'>2011</option>
											<option value='2012'>2012</option>
											<option value='2013'>2013</option>
											<option value='2014'>2014</option>
											<option value='2015'>2015</option>
										</SELECT>
										
									</td>	
								</TR>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_mant_trabajadores.php';" > 
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