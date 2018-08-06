<?php /* Smarty version 2.6.18, created on 2010-10-31 17:10:15
         compiled from sg_ingreso_siniestro.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Ingreso Siniestro </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		<?php echo '
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFechaAsignacion\').mask("99/99/9999");
				}
			); 		
		</script>
		
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
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%">&nbsp;&nbsp;<img src="../images/Cars-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Ingreso de Siniestro</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodigo" name="txtCodigo" value='<?php echo $this->_tpl_vars['CODIGO']; ?>
' size="10" readonly>
										<label class="comentario">Este Código se Asignará Automáticamente</label>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Liquidador:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboLiquidador" name="OBLIcboLiquidador" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Compañía:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboCompania" name="OBLIcboCompania" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Siniestro:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtNumSiniestro" name="OBLItxtNumSiniestro" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Tipo Vehículo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboTipoVehiculo" name="OBLIcboTipoVehiculo" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Marca:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboMarca" name="OBLIcboMarca" onKeyPress="return Tabula(this, event, 0)" onchange="xajax_CargaModelos(xajax.getFormValues('Form1'));"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Modelo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboModelo" name="OBLIcboModelo" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtPatente" name="OBLItxtPatente" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Taller:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLIcboTaller" name="OBLIcboTaller" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nombre Asegurado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtNombreAsegurado" name="OBLItxtNombreAsegurado" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Asegurado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLI-txtRut" name="OBLI-txtRut" onchange="xajax_CalculaDigito(xajax.getFormValues('Form1'));" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="8" size="10">
										<INPUT type="text" id="OBLI-txtDig" name="OBLI-txtDig" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="1" size="1">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Poliza:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtNumPoliza" name="OBLItxtNumPoliza" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="10">
										&nbsp;&nbsp;Item:
										<INPUT type="text" id="txtItem" name="txtItem" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="6" size="6">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">A / RC:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtArc" name="OBLItxtArc" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Ded.:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtDed" name="OBLItxtDed" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha Asignación:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtFechaAsignacion" name="OBLItxtFechaAsignacion" value='' onchange="xajax_CalculaDiasDif(xajax.getFormValues('Form1'));" onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Ramo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtRamo" name="txtRamo" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Estado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtEstado" name="OBLItxtEstado" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Prov. (Estimada/Final):<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="OBLItxtProv" name="OBLItxtProv" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFecha" name="txtFecha" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Factura:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumFactura" name="txtNumFactura" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha Entrega:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFechaEntrega" name="txtFechaEntrega" value='' onchange="xajax_CalculaDiasDif(xajax.getFormValues('Form1'));" onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario3' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
										
										&nbsp;&nbsp;
										<label id='diasdif' class="requerido"></label>
									</td>
								</TR>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<div id='prueba'></div>
										
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="xajax_Nuevo(xajax.getFormValues('Form1'));" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
										
										<div id='sql'></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
		<div id="calendar-container"></div>
	
		<?php echo '
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "OBLItxtFechaAsignacion",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
			Calendar.setup({inputField : "txtFecha",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
			Calendar.setup({inputField : "txtFechaEntrega",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario3",step: 1});
		</script>
		'; ?>

	</body>
</HTML>