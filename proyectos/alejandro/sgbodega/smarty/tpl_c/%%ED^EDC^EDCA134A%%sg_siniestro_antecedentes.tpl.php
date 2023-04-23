<?php /* Smarty version 2.6.18, created on 2010-10-11 19:23:43
         compiled from sg_siniestro_antecedentes.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Antecedentes </title>
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
				$(\'#OBLItxtVigencia\').mask("99/99/9999");
				$(\'#OBLItxtFechaUF\').mask("99/99/9999");
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
									<td style="width: 7%">&nbsp;&nbsp;<img src="../images/Report-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Antecedentes</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código Asignado:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodigo" name="txtCodigo" value='<?php echo $this->_tpl_vars['CODIGO']; ?>
' size="10" readonly>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Siniestro:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumSiniestro" name="txtNumSiniestro" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Compañía:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="txtCompania" name="txtCompania" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nombre Asegurado:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNombreAsegurado" name="txtNombreAsegurado" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Asegurado:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtRut" name="txtRut" onKeyPress="return SoloNumeros(this, event, 0)" value='' readonly maxLength="8" size="10">
										<INPUT type="text" id="txtDig" name="txtDig" onKeyPress="return Tabula(this, event, 0)" value='' readonly maxLength="1" size="1">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fono:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFono" name="txtFono" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Mail:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtMail" name="txtMail" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="80" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Conductor:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtConductor" name="txtConductor" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtRutConductor" name="txtRutConductor" onchange="xajax_CalculaDigito(xajax.getFormValues('Form1'));" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="8" size="10">
										<INPUT type="text" id="txtDigConductor" name="txtDigConductor" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="1" size="1">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Dirección:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtDireccion" name="txtDireccion" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Clase:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboClase" name="cboClase" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='B'>B</option>
											<option value='C'>C</option>
											<option value='D'>D</option>
											<option value='E'>E</option>
											<option value='A1'>A1</option>
											<option value='A2'>A2</option>
											<option value='A3'>A3</option>
											<option value='A4'>A4</option>
											<option value='A5'>A5</option>
										</SELECT>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Vigencia:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtVigencia" name="txtVigencia" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Alcoholemia:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboAlcoholemia" name="cboAlcoholemia" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='SI'>SI</option>
											<option value='NO'>NO</option>
										</SELECT>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Tipo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTipo" name="txtTipo" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Marca:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtMarca" name="txtMarca" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Modelo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtModelo" name="txtModelo" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">PPU:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtPatente" name="txtPatente" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Año:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtAnio" name="txtAnio" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="4" size="4">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Color:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtColor" name="txtColor" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Motor:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumMotor" name="txtNumMotor" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Chasis:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumChasis" name="txtNumChasis" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Kms.:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtKms" name="txtKms" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Documentos:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<input type="checkbox" id="option1" name="option1" value="V"> Vehículo&nbsp;&nbsp;&nbsp;
										<input type="checkbox" id="option2" name="option2" value="C"> Carabineros&nbsp;&nbsp;&nbsp;
										<input type="checkbox" id="option3" name="option3" value="L"> Licencia
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Valor UF:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtValorUF" name="txtValorUF" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaPesos(xajax.getFormValues('Form1'));" maxLength="10" size="10">
										,
										<INPUT type="text" id="txtValorUFDec" name="txtValorUFDec" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaPesos(xajax.getFormValues('Form1'));" maxLength="3" size="3">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha UF:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFechaUF" name="txtFechaUF" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Deducible Total en UF:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTotalUF" name="txtTotalUF" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaPesos(xajax.getFormValues('Form1'));" maxLength="10" size="10">
										,
										<INPUT type="text" id="txtTotalUFDec" name="txtTotalUFDec" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaPesos(xajax.getFormValues('Form1'));" maxLength="3" size="3">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Deducible Total en Pesos:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTotalPesos" name="txtTotalPesos" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
									</td>
								</tr>
								
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="3" class="tabla-alycar-fila-informa-requerida-contrato">Observaciones</td>
								</tr>
								<tr align="center">
									<td class="tabla-alycar-label" style="width: 15%">Fecha</td>
									<td class="tabla-alycar-label" style="width: 83%">Observación</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs1" name="txtFechaObs1" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario3' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs1" name="txtObs1" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs2" name="txtFechaObs2" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario4' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs2" name="txtObs2" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs3" name="txtFechaObs3" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario5' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs3" name="txtObs3" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs4" name="txtFechaObs4" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario6' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs4" name="txtObs4" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs5" name="txtFechaObs5" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario7' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs5" name="txtObs5" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs6" name="txtFechaObs6" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario8' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs6" name="txtObs6" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs7" name="txtFechaObs7" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario9' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs7" name="txtObs7" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs8" name="txtFechaObs8" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario10' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs8" name="txtObs8" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs9" name="txtFechaObs9" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario11' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs9" name="txtObs9" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 15%">
										<INPUT type="text" id="txtFechaObs10" name="txtFechaObs10" value='' maxLength="10" style="width: 72%">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario12' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
									<td class="tabla-alycar-texto" style="width: 83%">
										<INPUT type="text" id="txtObs10" name="txtObs10" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<div id='prueba'></div>
										
										<input type="button" name="btnGrabar" value="Grabar Antecedentes" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
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
			Calendar.setup({inputField : "txtVigencia",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
			Calendar.setup({inputField : "txtFechaUF",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
			Calendar.setup({inputField : "txtFechaObs1",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario3",step: 1});
			Calendar.setup({inputField : "txtFechaObs2",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario4",step: 1});
			Calendar.setup({inputField : "txtFechaObs3",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario5",step: 1});
			Calendar.setup({inputField : "txtFechaObs4",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario6",step: 1});
			Calendar.setup({inputField : "txtFechaObs5",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario7",step: 1});
			Calendar.setup({inputField : "txtFechaObs6",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario8",step: 1});
			Calendar.setup({inputField : "txtFechaObs7",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario9",step: 1});
			Calendar.setup({inputField : "txtFechaObs8",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario10",step: 1});
			Calendar.setup({inputField : "txtFechaObs9",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario11",step: 1});
			Calendar.setup({inputField : "txtFechaObs10",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario12",step: 1});
		</script>
		'; ?>

	</body>
</HTML>