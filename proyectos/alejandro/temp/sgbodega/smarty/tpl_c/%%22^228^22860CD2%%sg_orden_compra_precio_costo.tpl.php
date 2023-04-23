<?php /* Smarty version 2.6.18, created on 2017-06-09 16:58:49
         compiled from sg_orden_compra_precio_costo.tpl */ ?>
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
		<SCRIPT language="javascript">
			function checkAll(theForm, cName, status) {
				for (i=0,n=theForm.elements.length;i<n;i++)
				  if (theForm.elements[i].className.indexOf(cName) !=-1) {
					theForm.elements[i].checked = status;
				  }
				}
		</SCRIPT>
		<script type="text/javascript">
			$(function($) { 
				$(\'#txtFecha1\').mask("99/99/9999");
				$(\'#txtFecha2\').mask("99/99/9999");
				
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Mantenedor de Precios Costos</label></td>

									<input type="hidden" name="cantidad" id="cantidad" value="<?php echo $this->_tpl_vars['cantidad']; ?>
">
									<input type="hidden" name="fecha_cant_rec" id="fecha_cant_rec" value="<?php echo $this->_tpl_vars['fecha_cant_rec']; ?>
">
									<input type="hidden" name="factura" id="factura" value="<?php echo $this->_tpl_vars['factura']; ?>
">
									<input type="hidden" name="guia_despacho" id="guia_despacho" value="<?php echo $this->_tpl_vars['guia_despacho']; ?>
">
									<input type="hidden" name="OBLItxtCodVendedor" id="OBLItxtCodVendedor" value="<?php echo $this->_tpl_vars['OBLItxtCodVendedor']; ?>
">
									<input type="hidden" name="OBLItxtDescVendedor" id="OBLItxtDescVendedor" value="<?php echo $this->_tpl_vars['OBLItxtDescVendedor']; ?>
">

								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Producto</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="txtCodProducto" name="txtCodProducto" value='<?php echo $this->_tpl_vars['codigo']; ?>
' maxLength="10" style="width: 15%;" readonly="readonly"/>
                                    	<INPUT type="text" id="txtDescProducto" name="txtDescProducto" value='' maxLength="100" style="width: 75%;" readonly="readonly"/>
									</td>	
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Precio Costo Actual Nuevo</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="precio_actual_nuevo" name="precio_actual_nuevo" value='' readonly="readonly"/>
									</td>	
									<td class="tabla-alycar-label" style="width: 15%">Precio Costo Nuevo a Ingresar</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="precio_nuevo" name="precio_nuevo" value=''  onblur="xajax_CalcularPrecioUsado(xajax.getFormValues('Form1'))"/>
									</td>	
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Precio Costo Actual Usado</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="precio_actual_usado" name="precio_actual_usado" value='' readonly="readonly"/>
									</td>	
									<td class="tabla-alycar-label" style="width: 15%">Precio Costo Usado a Ingresar</td>
									<td class="tabla-alycar-texto" style="width: 35%">
										<INPUT type="text" id="precio_usado" name="precio_usado" value='' />
									</td>	
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" style="width: 100%" colspan="4">
									<input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Ingresar Precio Costo" onclick="xajax_Grabar(xajax.getFormValues('Form1'))"/>
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
											<div id='divabonos'><div>
										</td>
									</TR>
								</table>
							
							</div>	
						</form>
					</td>
				</tr>

			</table>
		</div>		
		
	</body>
</HTML>