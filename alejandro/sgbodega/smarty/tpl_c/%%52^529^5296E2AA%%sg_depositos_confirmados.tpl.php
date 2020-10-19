<?php /* Smarty version 2.6.18, created on 2012-02-09 11:33:57
         compiled from sg_depositos_confirmados.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
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
		
		<?php echo '
		
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFecha1\').mask("99/99/9999");
				$(\'#OBLItxtFecha2\').mask("99/99/9999");
				
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

		'; ?>

	
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
									<td style="width: 7%" align='right'><img src="../images/Checklist-64.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Depósitos Confirmados</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Banco:</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<SELECT id="cboBanco" name="cboBanco" style="width: 100%" onchange="xajax_CargaCtasCtes(xajax.getFormValues('Form1'));" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CargaSectores(xajax.getFormValues('Form1')), xajax_CargaCobradores(xajax.getFormValues('Form1'))">
											<option value=''>Todos</option>
										</SELECT>
									</td>	
									<td class="tabla-alycar-label" style="width: 15%">Cta. Cte.:</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<SELECT id="cboCtaCte" name="cboCtaCte" style="width: 100%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>Todas</option>
										</SELECT>
									</td>	
									
								</tr>
								<tr align="left">
									
									<td class="tabla-alycar-label" style="width: 15%">Tipo:</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<SELECT id="cboTipo" name="cboTipo" style="width: 100%" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>Todos</option>
										</SELECT>
									</td>	
									
									<td class="tabla-alycar-label" style="width: 15%">Fecha Depósito:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="OBLItxtFecha1" name="OBLItxtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="OBLItxtFecha2" name="OBLItxtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
								
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							
							</table>
							<div id='divdetalle' style="display: block;">
								<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr align="center">
										<td colspan='2'>
											<div id='divprogreso' style="display: none; text-align: center;">
												<img src="../images/cargando.gif">
											<div>
										</td>
									</tr>
									<tr align="left">
										<td colspan='2'>
											<div id='divresultado'><div>
										</td>
									</TR>
								</table>
							
							</div>	
						</form>
					</td>
				</tr>
				<tr>
					<td>
						<div id="divbotones" align="left" style="display: none; margin:0px; padding: 0px;">
							<form action="FicheroExcel.php" id="form_excel" method="post" target="_blank">
								<table class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
									<tr align="left">
										<td colspan="6" class="grilla-tab-fila-titulo">
											  <input type="button" class='boton' value="Imprimir" onClick="ImprimeDiv('divresultado');">
											  <input type="button" class='boton' value="Excel" onClick="exportar_excel('form_excel', 'tabla');">
											  
											  <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
										</td>
									</tr>
								</table>
							</form>
						</div>
					</td>
				</tr>
			</table>
		</div>		
		
	</body>
</HTML>