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
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>

		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			{literal}
			<script type="text/javascript">
	   			function ImprimeDiv(id)
				{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
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
					$('#pri_fecha_venc').mask("99/99/9999");
					}
				); 		
			</script>
			<script type="text/javascript">
				$(document).ready(function() {
	 				$.datepicker.regional['es'] = {
					  closeText: 'Cerrar',
					  prevText: '<Ant',
					  nextText: 'Sig>',
					  currentText: 'Hoy',
					  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
					  dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado'],
					  dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
					  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
					  weekHeader: 'Sm',
					  dateFormat: 'dd/mm/yy',
					  firstDay: 1,
					  isRTL: false,
					  showMonthAfterYear: false,
					  yearSuffix: ''};
			    	$.datepicker.setDefaults($.datepicker.regional['es']);                            
					$('#pri_fecha_venc').datepicker({
						  showOn: "button",
						  buttonImage: "../images/calendario.png",
						  buttonImageOnly: true,
						  dateFormat : "dd/mm/yy"
						}); 
	 				$("#nombre_cta_cte").autocomplete({
						source : 'busquedas/busqueda_OBLIcta_cte_ncorr.php',
						select: function( event, ui ) {
							var rut = ui.item.name;
							document.getElementById('cta_cte').value = rut;
							}
						});
					});
			</script>
			{/literal}
			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Ingresar nuevo credito</td>
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
							Nro Credito
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="nro_credito" id="nro_credito">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Cuenta Corriente
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="nombre_cta_cte" id="nombre_cta_cte">
							<input type="hidden" name="cta_cte" id="cta_cte">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Monto Solicitado
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="monto_solicitado" id="monto_solicitado">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Comnisiones
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="comisiones" id="comisiones">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Seguros 1
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="seguros_1" id="seguros_1">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Seguros 2
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="seguros_2" id="seguros_2">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Seguros 3
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="seguros_2" id="seguros_2">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Total Credito
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="total_credito" id="total_credito">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Primera fecha de vencimiento
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="pri_fecha_venc" id="pri_fecha_venc">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Tasa de interes mensual
						</td>
						<td class="tabla-alycar-texto" colspan="3">
							<input type="text" name="interes_mensual" id="interes_mensual">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-text" colspan="8">
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