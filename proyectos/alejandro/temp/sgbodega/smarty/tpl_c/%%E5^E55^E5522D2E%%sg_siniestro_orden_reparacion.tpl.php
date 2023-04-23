<?php /* Smarty version 2.6.18, created on 2010-10-11 21:32:17
         compiled from sg_siniestro_orden_reparacion.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_siniestro_orden_reparacion.tpl', 213, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Orden de Reparación </title>
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
				$(\'#txtVigencia\').mask("99/99/9999");
				$(\'#txtFechaUF\').mask("99/99/9999");
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
									<td style="width: 7%">&nbsp;&nbsp;<img src="../images/Gnome-Applications-System-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Orden de Reparación</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código Asignado:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodigo" name="txtCodigo" value='<?php echo $this->_tpl_vars['CODIGO']; ?>
' size="10" readonly>
										<INPUT type="hidden" id="txtValorUf" name="txtValorUf" value=''>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Siniestro:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumSiniestro" name="txtNumSiniestro" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="20" size="10">
									</td>
								</tr>
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
										<INPUT type="text" id="txtFono" name="txtFono" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="20" size="10">
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
										<INPUT type="text" id="txtAnio" name="txtAnio" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="4" size="4">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Color:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtColor" name="txtColor" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Motor:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumMotor" name="txtNumMotor" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Chasis:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumChasis" name="txtNumChasis" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Taller:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTaller" name="txtTaller" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Dirección Taller:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtDireccionTaller" name="txtDireccionTaller" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fono Taller:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFonoTaller" name="txtFonoTaller" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Facturar a:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFacturar" name="txtFacturar" value='' onKeyPress="return Tabula(this, event, 0)" readonly maxLength="100" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Facturación:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtRutFact" name="txtRutFact" onKeyPress="return SoloNumeros(this, event, 0)" value='' readonly maxLength="8" size="10">
										<INPUT type="text" id="txtDigFact" name="txtDigFact" onKeyPress="return Tabula(this, event, 0)" value='' readonly maxLength="1" size="1">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtFecha" name="txtFecha" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' readonly maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Tipo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboTipo" name="cboTipo" onKeyPress="return SoloNumeros(this, event, 0)">
										</SELECT>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Mano de Obra:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtManoObra" name="txtManoObra" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Pintura:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtPintura" name="txtPintura" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Trabajos Externos:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTrabajosExternos" name="txtTrabajosExternos" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Deducible en UF:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										
										<INPUT type="text" id="txtDeducibleEnt" name="txtDeducibleEnt" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_DeduciblePesos(xajax.getFormValues('Form1'));" maxLength="20" size="10">
										,
										<INPUT type="text" id="txtDeducibleDec" name="txtDeducibleDec" value='' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_DeduciblePesos(xajax.getFormValues('Form1'));" maxLength="3" size="3">
										&nbsp;&nbsp; 
										<label id='lbluf' class="requerido"></label>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Deducible en Pesos:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtDeduciblePesos" name="txtDeduciblePesos" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="20" size="10">
									</td>
								</tr>
								
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Detalle Repuestos</td>
								</tr>
							</table>	
							
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr align="center">
									<td class="grilla-tab-fila-titulo" style="width: 8%">Clave</td>
									<td class="grilla-tab-fila-titulo" style="width: 65%">Concepto</td>
									<td class="grilla-tab-fila-titulo" style="width: 12%">Valor</td>
									<td class="grilla-tab-fila-titulo" style="width: 5%">M/O</td>
									<td class="grilla-tab-fila-titulo" style="width: 5%">Pint.</td>
									<td class="grilla-tab-fila-titulo" style="width: 5%"></td>
								</tr>
								<tr align="left">
									<td class="grilla-tab-fila-campo" style="width: 8%">
										<SELECT style="width: 98%" id="cboClave" name="cboClave" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>
									<td class="grilla-tab-fila-campo" style="width: 65%">
										<INPUT style="width: 98%" type="text" id="txtConcepto" name="txtConcepto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 98%">
									</td>
									<td class="grilla-tab-fila-campo" style="width: 12%">
										<INPUT style="width: 98%" type="text" id="txtValor" name="txtValor" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" style="width: 98%">
									</td>
									<td class="grilla-tab-fila-campo" style="width: 5%">
										<INPUT style="width: 98%" type="text" id="txtMO" name="txtMO" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="3" style="width: 98%">
									</td>
									<td class="grilla-tab-fila-campo" style="width: 5%">
										<INPUT style="width: 98%" type="text" id="txtPint" name="txtPint" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="3" style="width: 98%">
									</td>
									<td class="grilla-tab-fila-campo" style="width: 5%">
										<input type="button" name="btnAg" value=" + " class="boton" onclick="xajax_GrabaLinea(xajax.getFormValues('Form1'));">
									</td>
								</tr>
							</table>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
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
		<div id="calendar-container"></div>
	
		<?php echo '
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "txtFecha",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario",step: 1});
		</script>
		'; ?>

	</body>
</HTML>