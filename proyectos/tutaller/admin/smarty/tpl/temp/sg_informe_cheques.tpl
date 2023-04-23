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
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
			
		{literal}
		
		<script type="text/javascript">
			$(function($) { 
				$('#txtFecha1').mask("99/99/9999");
				$('#txtFecha2').mask("99/99/9999");
				$('#txtFecha3').mask("99/99/9999");
				$('#txtFecha4').mask("99/99/9999");
				
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
				   tmp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
		</script> 

		{/literal}
	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Gnome-Edit-Find-Replace-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Informe de Cheques</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Cta. Cte.:</td>
									<td class="tabla-alycar-texto" style="width: 24%">
										<SELECT id="cboCtaCte" name="cboCtaCte" style="width: 100%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Operación:</td>
									<td class="tabla-alycar-texto" style="width: 24%">
										<!--<INPUT type="text" id="txtDetalle" name="txtDetalle" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">-->
										<SELECT id="cboOperacion" name="cboOperacion" style="width: 100%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>	
									<!--<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">N° Documento:</td>-->
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Detalle:</td>
									<td class="tabla-alycar-texto" style="width: 16%">
										<INPUT type="text" id="txtDetalle" name="txtDetalle" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">
										<!--<INPUT type="text" id="txtNumDoc" name="txtNumDoc" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">-->
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Rango F. Emisión:</td>
									<td class="tabla-alycar-texto" style="width: 24%">
										<INPUT type="text" id="txtFecha1" name="txtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='8'>
										al
										<INPUT type="text" id="txtFecha2" name="txtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='8'>
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Rango F. Vcto.:</td>
									<td class="tabla-alycar-texto" style="width: 24%">
										<INPUT type="text" id="txtFecha3" name="txtFecha3" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='8'>
										al
										<INPUT type="text" id="txtFecha4" name="txtFecha4" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='8'>
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 13%">Cobrado:</td>
									<td class="tabla-alycar-texto" style="width: 16%">
										<SELECT id="cboCobrado" name="cboCobrado" style="width: 100%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>Todos</option>
											<option value='0'>NO</option>
											<option value='1'>SI</option>
										</SELECT>
									</td>	
								
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							</table>
							
							<div id='divdetalle' style="display: block;">
								<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr align="left">
										<td colspan='2'>
											<div id='divresultado'><div>
										</td>
									</TR>
								</table>
							
							</div>	
							
						
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>