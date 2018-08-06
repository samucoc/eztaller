<?php /* Smarty version 2.6.18, created on 2016-09-21 11:42:33
         compiled from sg_ot_ingreso.tpl */ ?>
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
							<table border="0" class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="grilla-tab-fila-titulo">Ingresar Orden de Trabajo</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar" class="grilla-tab"  cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td class="grilla-tab-fila-campo">
							Folio
						</td>
						<td class="grilla-tab-fila-titulo" colspan="3">
							<input type="text" name="folio" id="folio">
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-campo">
							Fecha
						</td>
						<td class="grilla-tab-fila-titulo" >
							<input type="text" name="fecha_ot" id="fecha_ot">
						</td>
						<td class="grilla-tab-fila-campo">
							Patente
						</td>
						<td class="grilla-tab-fila-titulo" >
							<input type="text" name="patente" id="patente">
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-campo">
							Mecanico
						</td>
						<td class="grilla-tab-fila-titulo" >
							<input type="text" name="mecanico" id="mecanico">
							<input type="hidden" name="rut_mecanico" id="rut_mecanico">
						</td>
						<td class="grilla-tab-fila-campo">
							Trabajador
						</td>
						<td class="grilla-tab-fila-titulo" >
							<input type="text" name="trabajador" id="trabajador">
							<input type="hidden" name="rut_trabajador" id="rut_trabajador">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-fila-informa-requerida-contrato" colspan="4">
							Mano de Obra
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-campo" colspan="4">
							<table>
								<tr>
									<td>
										Detalle
									</td>
									<td>
										Cantidad
									</td>
									<td>
										Precio neto
									</td>
									<td>
										Iva
									</td>
									<td>
										Total unitario
									</td>
									<td>
										Total
									</td>
									<td>	
										Accion
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="detalle_mo_nuv" id="detalle_mo_nuv" onKeyPress="return Tabula(this, event, 1)">
										<input type="hidden" name="cod_detalle_mo_nuv" id="cod_detalle_mo_nuv">
									</td>
									<td>
										<input type="text" name="cantidad_mo" id="cantidad_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="precio_neto_mo" id="precio_neto_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="iva_mo" id="iva_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="total_unitario_mo" id="total_unitario_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="total_mo" id="total_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="button" name="btnAgregarMO" id="btnAgregarMO" value="Agregar Mano de Obra"  class="boton"
											onclick="xajax_GrabarMO(xajax.getFormValues('Form1'));">
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-text" colspan="8">
										<div id="divmo"></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-fila-informa-requerida-contrato" colspan="4">
							Repuestos
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-campo" colspan="1">
							Mano de Obra
						</td>
						<td class="tabla-alycar-text" colspan="3">
							<input type="type" name="detalle_mo" id="detalle_mo">
							<input type="hidden" name="mod_ncorr" id="mod_ncorr">
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-campo" colspan="4">
							<table>
								<tr>
									<td>
										Repuesto
									</td>
									<td>
										Cantidad
									</td>
									<td>
										Precio neto
									</td>
									<td>
										Iva
									</td>
									<td>
										Total unitario
									</td>
									<td>
										Total
									</td>
									<td>	
										Accion
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="repuesto" id="repuesto" onKeyPress="return Tabula(this, event, 0)">
										<input type="hidden" name="cod_repuesto" id="cod_repuesto" >
									</td>
									<td>
										<input type="text" name="cantidad" id="cantidad" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="precio_neto_unitario" id="precio_neto_unitario" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="iva" id="iva" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="precio_unitario" id="precio_unitario" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="total" id="total" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="button" name="btnAgregarRep" id="btnAgregarRep"  value="Agregar Reparacion" class="boton"
											onclick="xajax_GrabarRepuesto(xajax.getFormValues('Form1'));">
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-text" colspan="8">
										<div id="divrepuestos"></div>
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-text" colspan="8">
										<input type="button" name="btnAgregar" id="btnAgregar"  value="Grabar OT" class="boton"
											onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
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