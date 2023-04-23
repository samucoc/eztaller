<?php /* Smarty version 2.6.18, created on 2016-09-26 10:37:03
         compiled from sg_ot_imprimir.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
	        <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
            <!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
            <script src="../includes_js/jquery.uploadify.min.js" type="text/javascript"></script>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadify.css">
			<script src="../includes_js/jquery.Rut.js" type="text/javascript"></script>

		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<?php echo '
			<script type="text/javascript">
	   			function ImprimeDiv(id)
				{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   	temp.document.write(c.innerHTML);
				   	temp.document.close();
					  
				   	var is_chrome = function () { return Boolean(temp.chrome); }
					if(is_chrome) {
							setTimeout(function () { // wait until all resources loaded 
								temp.print();  // change window to winPrint
					            temp.close();// change window to winPrint
					        }, 100);
						}
					else{
					   	temp.print();
					   	temp.close();
					}
				}

            </script>                        
			<script type="text/javascript">
				$(function($) { 
					$(\'#fecha_ot\').mask("99/99/9999");
					}
				); 		
			</script>
			<script type="text/javascript">
				$(document).ready(function() {
	 				$("#trabajador").autocomplete({
						source : \'busquedas/busqueda_persona.php\',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById(\'rut_trabajador\').value = rut;
							}
						});
					 $("#mecanico").autocomplete({
						source : \'busquedas/busqueda_mecanico.php\',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById(\'rut_mecanico\').value = rut;
							}
						});
					$("#patente").autocomplete({
						source : \'busquedas/busqueda_vehiculo.php\'
						});
					$("#detalle_mo_nuv").autocomplete({
						source : \'busquedas/busqueda_mo.php\',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById(\'cod_detalle_mo_nuv\').value = rut;
							}
						});
					$("#repuesto").autocomplete({
						source : \'busquedas/busqueda_repuesto.php\',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById(\'cod_repuesto\').value = rut;
							}
						});
					});
			</script>
			'; ?>

			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Ingresar Orden de Trabajo</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar tabla-alycar"  cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td class="tabla-alycar-label">
							Nro. Correlativo OT
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="ot_ncorr" id="ot_ncorr" value="<?php echo $this->_tpl_vars['ot_ncorr']; ?>
">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Folio OT
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="folio" id="folio" >
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-text" colspan="99">
							<input type="button" name="btnAgregar" id="btnAgregar"  value="Buscar OT" class="boton"
											onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
						</td>
					</tr>
				</table>
				<table class="curvar" class="tabla-alycar"  cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td class="tabla-alycar-text" colspan="8">
							<div id="divabonos"></div>
						</td>
					</tr>
				</table>
			</div>

		</form>
	</body>
</HTML>