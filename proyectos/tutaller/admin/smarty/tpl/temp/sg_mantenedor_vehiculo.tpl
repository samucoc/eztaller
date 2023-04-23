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
			
			
		<!-- jquery conversor a excel -->
			<script type="text/javascript" src="../includes_js/jquery.min.js"></script>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		{literal}
		
		<script type="text/javascript">
			$(function($) { 
				$('#OBLItxtFecha1').mask("99/99/9999");
				$('#OBLItxtFecha2').mask("99/99/9999");
				
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
			function exportar_excel(id_form, id_tabla)
			{
				 // Obtiene el contenido de la tabla indicada
				 var tabla = $("#" + id_tabla).html();
				 // Añade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el código en PHP
				 $("#" + id_form).submit();
			}
 		</script> 

		{/literal}
	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Registro Pie de Vendedor</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" value='{$NCORR}' readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<SELECT id="OBLIcboEmpresa" name="OBLIcboEmpresa" style="width: 50%" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CargaSectores(xajax.getFormValues('Form1'),'','',''), xajax_CargaCobradores(xajax.getFormValues('Form1'),'','',''), xajax_CargaVendedores(xajax.getFormValues('Form1'),'','','')"></SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Sector:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<SELECT id="OBLIcboSector" name="OBLIcboSector" style="width: 50%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Vendedor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<SELECT id="OBLIcboVendedor" name="OBLIcboVendedor" style="width: 50%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Cobrador Inform.:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<SELECT id="OBLIcboCobrador" name="OBLIcboCobrador" style="width: 50%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
										</SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Folio:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="txtFolio" name="txtFolio" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLItxtFecha1" name="OBLItxtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLItxtMonto" name="OBLItxtMonto" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</tr>
								
								
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnEliminar" value="Eliminar" class="boton" onclick="xajax_Eliminar(xajax.getFormValues('Form1'));">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_cobranza_registro_pie_vendedor.php';" > 
										<input type="button" name="btnBuscar" value="Buscar >>" class="boton" onClick="javascript: document.location.href='sg_busqueda_pie_vendedor.php?tbl=pie_vendedor';" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>		
		
	</body>
</HTML>