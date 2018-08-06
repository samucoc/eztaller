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
			<LINK href="http://192.168.1.102/sgyonley/estilos/estilo.css" type="text/css" rel="stylesheet">
			{literal}
						<style>
				table.tabla-alycar {
					BORDER-RIGHT: #B9B9B9 1px solid; BORDER-TOP: #B9B9B9 1px solid; FLOAT: left; BORDER-LEFT: #B9B9B9 1px solid; BORDER-BOTTOM: #B9B9B9 1px solid; BORDER-COLLAPSE: collapse;ALIGN:Center; width:100%;
				}
				.taba-alycar TD {
					BORDER-RIGHT: #B9B9B9 0px solid; PADDING-RIGHT: 0em; BORDER-TOP: #B9B9B9 0px solid; PADDING-LEFT: 0em; PADDING-BOTTOM: 0pt; BORDER-LEFT: #B9B9B9 0px solid; PADDING-TOP: 0pt; BORDER-BOTTOM: #B9B9B9 0px solid
				}

				.taba-alycar TR {
					BORDER-RIGHT: #B9B9B9 0px solid; PADDING-RIGHT: 0em; BORDER-TOP: #B9B9B9 0px solid; PADDING-LEFT: 0em; PADDING-BOTTOM: 0pt; BORDER-LEFT: #B9B9B9 0px solid; PADDING-TOP: 0pt; BORDER-BOTTOM: #B9B9B9 0px solid
				}

				table.tabla-alycar-menu{
					BORDER-RIGHT: #B9B9B9 1px solid; BORDER-TOP: #B9B9B9 1px solid; FLOAT: left; BORDER-LEFT: #B9B9B9 1px solid; BORDER-BOTTOM: #B9B9B9 1px solid; BORDER-COLLAPSE: collapse;ALIGN:Center; width:100%;
				}
				.taba-alycar-menu TD {
					BORDER-RIGHT: #B9B9B9 0px solid; PADDING-RIGHT: 0em; BORDER-TOP: #B9B9B9 0px solid; PADDING-LEFT: 0em; PADDING-BOTTOM: 0pt; BORDER-LEFT: #B9B9B9 0px solid; PADDING-TOP: 0pt; BORDER-BOTTOM: #B9B9B9 0px solid
				}

				.taba-alycar-menu TR {
					BORDER-RIGHT: #B9B9B9 0px solid; PADDING-RIGHT: 0em; BORDER-TOP: #B9B9B9 0px solid; PADDING-LEFT: 0em; PADDING-BOTTOM: 0pt; BORDER-LEFT: #B9B9B9 0px solid; PADDING-TOP: 0pt; BORDER-BOTTOM: #B9B9B9 0px solid
				}

				.tabla-alycar-menu .tabla-alycar-fila-informa-requerida-contrato-cabecera {
					/*background:#356AA0;*/
					background:#447CAD;
					border:1px solid #ffffff;
					margin-bottom:4px;
					padding:4px 4px;
					color:#ffffff;
					font-size:12px;
					text-align:center;
					font-weight:bold;
					cursor: pointer;
				}
				.tabla-alycar-menu .tabla-alycar-fila-informa-requerida-contrato-cabecera-fuera {
				    background:#E7ECF1;
				    border:1px solid #ffffff;
				    margin-bottom:4px;
				    padding:4px 4px;    
				    color:#1B4978;
				    font-size:12px;
					text-align:center;
				    font-weight:bold;
					cursor: pointer;
				}
				.tabla-alycar-menu .tabla-alycar-texto-menu{
				    background:#ffffff;
				    border:1px solid #CCD7E1;
				    margin-bottom:4px;
				    padding:4px 4px;    
				    color:#000000;
				    font-size:11px;
					text-align:center;
				    font-weight:bold;
				}

				.taba-alycar .tabla-alycar-fila-titulo{
				    background:#E7ECF1;
				    border:1px solid #CCD7E1;
				    margin-bottom:10px;
				    padding:10px 10px;    
				    color:#1B4978;
				    font-size:14px;
				    font-weight:bold;
				}	
				.tabla-alycar .tabla-alycar-fila-botones{
				    background:#E7ECF1;
				    border:1px solid #CCD7E1;
				    margin-bottom:10px;
				    padding:10px 10px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
					text-align:left;
				}
				.tabla-alycar .tabla-alycar-fila-botones-der{
				    background:#E7ECF1;
				    border:1px solid #CCD7E1;
				    margin-bottom:10px;
				    padding:10px 10px;    
				    color:#1B4978;
				    font-size:14px;
				    font-weight:bold;
					text-align:right;
				}

				.tabla-alycar .tabla-alycar-fila-botones-centrado{
				    background:#E7ECF1;
				    border:1px solid #CCD7E1;
				    margin-bottom:10px;
				    padding:10px 10px;    
				    color:#1B4978;
				    font-size:14px;
				    font-weight:bold;
					text-align:center;
				}	
				.tabla-alycar .tabla-alycar-fila-informa {
					background:#E7ECF1;
					border:1px solid #CCD7E1;
					margin-bottom:10px;
					padding:10px 20px;
					color:#1B4978;
					font-size:11px;	
				}
				.tabla-alycar .tabla-alycar-fila-informa-requerida {
					background:#E7ECF1;
					border:1px solid #CCD7E1;
					margin-bottom:10px;
					padding:10px 20px;
					color:#1B4978;
					font-size:11px;
					text-align:right;
				}
				.tabla-alycar .tabla-alycar-fila-informa-requerida-contrato {
					background:#D2DFEE;
					border:1px solid #CCD7E1;
					margin-bottom:10px;
					padding:10px 20px;
					color:#1B4978;
					font-size:14px;
					text-align:left;
					font-weight:bold;
				}
				.tabla-alycar .tabla-alycar-fila-informa-folio {
					background:#fff;
					border:1px solid #CCD7E1;
					margin-bottom:50px;
					padding:50px 50px;
					color:#CC3300;
					font-size:42px;
					text-align:center;
					font-weight:bold;
				}
				.tabla-alycar .tabla-alycar-fila-informa-requerida-contrato-cabecera {
					background:#356AA0;
					border:1px solid #CCD7E1;
					margin-bottom:7px;
					padding:7px 7px;
					color:#FFFFFF;
					font-size:12px;
					text-align:center;
					font-weight:bold;
					cursor: pointer;
				}
				.tabla-alycar .tabla-alycar-fila-busqueda {
					background:#fff;
					border:1px solid #CCD7E1;
					margin-bottom:2px;
					padding:3px 10px;
					color:#1B4978;
					font-size:13px;	
				}
				.tabla-alycar .tabla-alycar-fila-input-busqueda {
					background:#fff;
					border:1px solid #CCD7E1;
					margin-bottom:2px;
					padding:3px 10px;
					color:#1B4978;
					font-size:13px;	
				}
				.tabla-alycar .tabla-alycar-fila-label-busqueda {
				    background:#F1F1D8;
					border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
				}

				.tabla-alycar .tabla-alycar-fila-informa-busqueda {
				    /*background:#F1F1D8;*/
					background:#F1F1D8  url(../images/search_right.gif) no-repeat scroll;
					border:1px solid #CCD7E1;
				    margin-bottom:0px;
				    padding:0px 0px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
					height:18px;
				}
				.tabla-alycar .tabla-alycar-fila-informa-obligatoria {
				    /*background:#F1F1D8;*/
					background:#F1F1D8;
					border:1px solid #CCD7E1;
					margin-bottom:10px;
					padding:10px 20px;
				    color:#1B4978;
				    font-size:11px;
					text-align:right;
				}
				.tabla-alycar .tabla-alycar-label{
				    background:#F2F2F2;
					border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 20px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
					width:160px;
				}
				.tabla-alycar .tabla-alycar-label-peq{
				    background:#F2F2F2;
					border:1px solid #CCD7E1;
				    margin-bottom:2px;
				    padding:2px 10px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
					width:160px;
				}
				.tabla-alycar .tabla-alycar-menu-label{
				    background:#F2F2F2;
					border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 20px;    
				    color:#1B4978;
				    font-size:11px;
				    font-weight:bold;
					width:160px;
				}
				.tabla-alycar .tabla-alycar-label-total{
				    background:#F2F2F2;
					border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#1B4978;
				    font-size:14px;
				    font-weight:bold;
					width:160px;
					text-align:right;
				}
				.tabla-alycar .tabla-alycar-texto{
				    border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#000000;
				    font-size:13px;
				    font-weight:bold;
				}
				.tabla-alycar .tabla-alycar-texto-peq{
				    border:1px solid #CCD7E1;
				    margin-bottom:2px;
				    padding:2px 5px;    
				    color:#000000;
				    font-size:11px;
				    font-weight:bold;
				}
				.tabla-alycar .tabla-alycar-texto-slinea{
				    border: none;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#000000;
				    font-size:13px;
				    font-weight:bold;
				}
				.tabla-alycar .tabla-alycar-texto-derecha{
				    border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#000000;
				    font-size:13px;
				    font-weight:bold;
					text-align:right;
				}
				.tabla-alycar .tabla-alycar-input-derecha{
					text-align:right;
				}
				.tabla-alycar .tabla-alycar-texto-archivo{
				    padding:5px 10px;    
				    color:#000000;
				    font-size:13px;
				}
				.tabla-alycar .tabla-alycar-input{
				    border:1px solid #CCD7E1;
				    margin-bottom:5px;
				    padding:5px 10px;    
				    color:#000000;
				    font-size:14px;
				}

				.tabla-alycar .tabla-alycar-input-yellow{
					background-color:#FFFF00;
				}

				.tabla-alycar .tabla-alycar-datos-usuario {
					border:1px solid #CCD7E1;
					FONT-FAMILY: Arial, Helvetica, sans-serif;
					margin-bottom:10px;
					padding:5px 5px;
					color:#1B4978;
					font-size:12px;
					}

			</style>
			<script type="text/javascript">
				$(function($) { 
					$('#fecha_ot').mask("99/99/9999");
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
					$('#fecha_ot').datepicker({
						  showOn: "button",
						  buttonImage: "../images/calendario.png",
						  buttonImageOnly: true,
						  dateFormat : "dd/mm/yy"
						}); 

	 				$("#trabajador").autocomplete({
						source : 'busquedas/busqueda_persona.php',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById('rut_trabajador').value = rut;
							}
						});
					 $("#mecanico").autocomplete({
						source : 'busquedas/busqueda_mecanico.php',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById('rut_mecanico').value = rut;
							}
						});
					$("#patente").autocomplete({
						source : 'busquedas/busqueda_vehiculo.php'
						});
					$("#detalle_mo_nuv").autocomplete({
						source : 'busquedas/busqueda_mo.php',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById('cod_detalle_mo_nuv').value = rut;
							}
						});
					$("#repuesto").autocomplete({
						source : 'busquedas/busqueda_repuesto.php',
						select: function( event, ui ) {
							var rut = ui.item.id;
							document.getElementById('cod_repuesto').value = rut;
							}
						});
					$("#folio").blur(function(){
						var folio = $("#folio").val();
						$.ajax({
							url: 'busquedas/si_existe_folio.php?folio='+folio,
							success: function(data){
								if (data != ''){
									alert(data);
									}
								}
							});
						});
					$("#iva_mo").blur(function(){
						
						var valor1 = $("#precio_neto_mo").val();
						var iva_mo = $("#iva_mo").val();
						
						var total_mo = parseInt(valor1) + parseInt(iva_mo);
						document.getElementById("total_unitario_mo").value = total_mo;
					  });
					
					$("#cantidad_mo").blur(function(){
						
						var valor1 = $("#cantidad_mo").val();
						var total_unitario_mo = $("#total_unitario_mo").val();
						
						var total_mo =  parseInt(valor1) *  parseInt(total_unitario_mo);
						document.getElementById("total_mo").value = total_mo;
					  });
					
					$("#iva").blur(function(){
						
						var valor1 = $("#precio_neto_unitario").val();
						var iva_mo = $("#iva").val();
						
						var total_mo =  parseInt(valor1) +  parseInt(iva_mo);
						document.getElementById("precio_unitario").value = total_mo;
					  });
					
					$("#cantidad").blur(function(){
						
						var valor1 = $("#cantidad").val();
						var total_unitario_mo = $("#precio_unitario").val();
						
						var total_mo =  parseInt(valor1) *  parseInt(total_unitario_mo);
						document.getElementById("total").value = total_mo;
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
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="#"></td>
									<td style="width: 93%"><label class="form-titulo">Ingresar Orden de Trabajo</label></td>
								</tr>
							</table>
							<br>
						</td>
					</tr>
				</table>
			</div>
			<div align="left" style="margin-left:2px; padding: 2px;">
				<table class="tabla-alycar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td class="tabla-alycar-label">
							Nro Orden de Compra
						</td>
						<td class="tabla-alycar-texto" >
							<input type="text" name="ot_ncorr" id="ot_ncorr" onblur="xajax_RescatarOC(xajax.getFormValues('Form1'));">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Fecha
						</td>
						<td class="tabla-alycar-texto" >
							<input type="text" name="fecha_ot" id="fecha_ot">
						</td>
						<td class="tabla-alycar-label">
							Patente
						</td>
						<td class="tabla-alycar-texto" >
							<input type="text" name="patente" id="patente">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label">
							Mecanico
						</td>
						<td class="tabla-alycar-texto" >
							<input type="text" name="mecanico" id="mecanico">
							<input type="hidden" name="rut_mecanico" id="rut_mecanico">
						</td>
						<td class="tabla-alycar-label">
							Trabajador
						</td>
						<td class="tabla-alycar-texto" >
							<input type="text" name="trabajador" id="trabajador">
							<input type="hidden" name="rut_trabajador" id="rut_trabajador">
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label" colspan="4">
							Mano de Obra
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto" colspan="4">
							<table class="tabla-alycar" >
								<tr>
									<td class="tabla-alycar-label">
										Detalle
									</td>
									<td class="tabla-alycar-label">
									</td>
									<td class="tabla-alycar-label">
										Precio neto
									</td>
									<td class="tabla-alycar-label">
										Iva
									</td>
									<td class="tabla-alycar-label">
										Total unitario
									</td>
									<td class="tabla-alycar-label">
										Cantidad
									</td>
									<td class="tabla-alycar-label">
										Total
									</td>
									<td class="tabla-alycar-label">
										Accion
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-texto" >
										<input type="text" name="detalle_mo_nuv" id="detalle_mo_nuv" onKeyPress="return Tabula(this, event, 1)">
										<input type="hidden" name="cod_detalle_mo_nuv" id="cod_detalle_mo_nuv">
									</td>
									<td class="tabla-alycar-texto" >
										<a href="#" onclick="xajax_AgregarMO(xajax.getFormValues('Form1'));">
											<img src="../images/plus.png" title="Agregar Nueva Mano de Obra" />
										</a>
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="precio_neto_mo" id="precio_neto_mo" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="iva_mo" id="iva_mo" onKeyPress="return SoloNumeros(this, event, 1)">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="total_unitario_mo" id="total_unitario_mo" onKeyPress="return SoloNumeros(this, event, 0)" readonly="readonly">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="cantidad_mo" id="cantidad_mo" onKeyPress="return SoloNumeros(this, event, 1)">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="total_mo" id="total_mo" onKeyPress="return SoloNumeros(this, event, 0)" readonly="readonly">
									</td>
									<td class="tabla-alycar-texto" >
										<a href="#" onclick="xajax_GrabarMO(xajax.getFormValues('Form1'));">
											<img src="../images/plus.png" title="Agregar Mano de Obra" />
										</a>
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
						<td class="tabla-alycar-label" colspan="4">
							Repuestos
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto" colspan="4">
							<table class="tabla-alycar" >
								<tr>
									<td class="tabla-alycar-label">
										Repuesto
									</td>
									<td class="tabla-alycar-label">
									</td>
									<td class="tabla-alycar-label">
										Precio neto
									</td>
									<td class="tabla-alycar-label">
										Iva
									</td>
									<td class="tabla-alycar-label">
										Total unitario
									</td>
									<td class="tabla-alycar-label">
										Cantidad
									</td>
									<td class="tabla-alycar-label">
										Total
									</td>
									<td class="tabla-alycar-label">	
										Accion
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-texto" >
										<input type="text" name="repuesto" id="repuesto" onKeyPress="return Tabula(this, event, 0)">
										<input type="hidden" name="cod_repuesto" id="cod_repuesto" >
									</td>
									<td class="tabla-alycar-texto" >
										<a href="#" onclick="xajax_AgregarRep(xajax.getFormValues('Form1'));">
											<img src="../images/plus.png" title="Agregar Nuevo Repuesto" />
										</a>
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="precio_neto_unitario" id="precio_neto_unitario" onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
									<td>
										<input type="text" name="iva" id="iva" onKeyPress="return SoloNumeros(this, event, 1)">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="precio_unitario" id="precio_unitario" onKeyPress="return SoloNumeros(this, event, 0)" readonly="readonly">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="cantidad" id="cantidad" onKeyPress="return SoloNumeros(this, event, 1)">
									</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="total" id="total" onKeyPress="return SoloNumeros(this, event, 0)" readonly="readonly">
									</td>
									<td class="tabla-alycar-texto" >
										<a href="#" onclick="xajax_GrabarRepuesto(xajax.getFormValues('Form1'));">
											<img src="../images/plus.png" title="Agregar Reparacion" />
										</a>
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-texto" colspan="8">
										<div id="divrepuestos"></div>
									</td>
								</tr>

							</table>
						</td>
					</tr>
					</table>
					<table width="100%"  class="tabla-alycar" >
					<tr align="right">
						<td align="right">
							<table align="right">
								<tr>
									<td class="tabla-alycar-label" >
										
									</td>
									<td class="tabla-alycar-label" >
										Neto	
									</td>
									<td class="tabla-alycar-label" >
										Iva
									</td>
									<td class="tabla-alycar-label" >
										Total
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-label" >
										Total Mano de Obra
									</td>
									<td class="tabla-alycar-texto" id="neto_mo_final" name="neto_mo_final">
									
									</td>
									<td class="tabla-alycar-texto" id="iva_mo_final" name="iva_mo_final">
									
									</td>
									<td class="tabla-alycar-texto" id="total_mo_final" name="total_mo_final">
									
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-label" >
										Total Repuestos
									</td>
									<td class="tabla-alycar-texto" id="neto_rep_final" name="neto_rep_final">
										
									</td>
									<td class="tabla-alycar-texto" id="iva_rep_final" name="iva_rep_final">
										
									</td>
									<td class="tabla-alycar-texto" id="total_rep_final" name="total_rep_final">
										
									</td>
								</tr>
								<tr>
									<td class="tabla-alycar-label" >
										Total
									</td>
									<td class="tabla-alycar-texto" id="neto_final" name="neto_final">
										
									</td>
									<td class="tabla-alycar-texto" id="iva_final" name="iva_final">
										
									</td>
									<td class="tabla-alycar-texto" id="total_final" name="total_final">
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="tabla-alycar-label" colspan="99">
							<input type="button" name="btnAgregar" id="btnAgregar"  value="Grabar OT" class="boton"
								onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
						</td>
					</tr>
				</table>
			</div>

		</form>
	</body>
</HTML>