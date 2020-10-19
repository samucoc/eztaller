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
									<td class="tabla-alycar-fila-label-busqueda" style="width: 7%">Cod. Cta. Cte.:</td>
									<td class="tabla-alycar-texto" style="width: 6%">
										<INPUT type="text" id="txtCodCtaCte" name="txtCodCtaCte" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 7%">N° Documento:</td>
									<td class="tabla-alycar-texto" style="width: 6%">
										<INPUT type="text" id="txtNumDoc" name="txtNumDoc" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 5%">Detalle:</td>
									<td class="tabla-alycar-texto" style="width: 6%">
										<INPUT type="text" id="txtDetalle" name="txtDetalle" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="10" style="width: 94%">
									</td>	
									<td class="tabla-alycar-fila-label-busqueda" style="width: 5%">Rango:</td>
									<td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="txtFecha1" name="txtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="txtFecha2" name="txtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
										&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>	
								
								</tr>
								
								<!--
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Rango:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 28%">
										<INPUT type="text" id="OBLItxtFecha1" name="OBLItxtFecha1" value='' maxLength="10" size='9' readonly>
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="OBLItxtFecha2" name="OBLItxtFecha2" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
									<td class="tabla-alycar-label" style="width: 15%">Sector:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 42%">
										<INPUT type="text" id="OBLItxtCodSector" name="OBLItxtCodSector" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sgyonley.sectores', 'sect_cod', 'sect_desc', 'OBLItxtCodSector', 'OBLItxtDescSector', '1');" value='' maxLength="10" size="2">
										<INPUT type="text" id="OBLItxtDescSector" name="OBLItxtDescSector" readonly value='' maxLength="100" size="28">
										&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>	
								</tr>
								-->
								
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
							
							<!--
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_fondos_asignados.php';"> 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							</table>
							-->
							
						
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>