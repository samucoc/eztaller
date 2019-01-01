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
			$(function($) 
				{ 
					$('#OBLItxtFechaEmision').mask("99/99/9999");
					$('#OBLItxtFechaVencimiento').mask("99/99/9999");
					$('#txtFechaPago').mask("99/99/9999");
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
									<td style="width: 7%" align='right'><img src="../images/Check-64.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Registro de Cheques</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Tipo de Operación:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<SELECT id="OBLIcboOperacion" name="OBLIcboOperacion" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Cuenta Corriente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtCodCuenta" name="OBLItxtCodCuenta" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'cuentas', 'CaId', 'CaNombre', 'OBLItxtCodCuenta', 'OBLItxtDescCuenta', '1');" value='' maxLength="10" size="9">
										<INPUT type="text" id="OBLItxtDescCuenta" name="OBLItxtDescCuenta" readonly value='' maxLength="100" size="40">
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda_tbl.php?tbl=cuentas', 'Cuentas', 500, 350, null);"></a>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">N° Documento:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtNumDoc" name="OBLItxtNumDoc" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="15" size="9">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Detalle del Cheque:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtDetalle" name="OBLItxtDetalle" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Fecha Emisión:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtFechaEmision" name="OBLItxtFechaEmision" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Fecha Vencimiento:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtFechaVencimiento" name="OBLItxtFechaVencimiento" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Monto Cheque:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="OBLItxtMonto" name="OBLItxtMonto" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Pagado:</td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<SELECT id="cboPagado" name="cboPagado" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value='0'>NO</option>
											<option value='1'>SI</option>
										</SELECT>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 25%">Fecha Pago:</td>
									<td class="tabla-alycar-texto-peq" style="width: 75%">
										<INPUT type="text" id="txtFechaPago" name="txtFechaPago" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_registro_cheques.php';" > 
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