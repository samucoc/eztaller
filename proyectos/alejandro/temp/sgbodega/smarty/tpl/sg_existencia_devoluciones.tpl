<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Devoluciones </title>
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
		
		{literal}
		<script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFechaRevision').mask("99/99/9999");
				$('#txtPrimerVencimiento').mask("99/99/9999");
				$('#OBLI-txtFechaDescuento').mask("99/99/9999");
				
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
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements['v_pivot_excel'].value=document.getElementById('pivot').innerHTML;
			document.getElementById(nombreformulario).target = 'iframe_pivot_excel'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById('pivot').innerHTML="";document.getElementById('pivot_filter').innerHTML="";document.getElementById('div_grafico').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		</script> 
		{/literal}
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divfolio" align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Devoluciones de Clientes
										<INPUT type="hidden" id="txtFolioOculto" name="txtFolioOculto" value='{$FOLIO}'>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Nº Folio:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNumFolio" name="txtNumFolio" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										&nbsp;<input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_RevisarAbonos(xajax.getFormValues('Form1'));">
									</td>	
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Productos
									</td>
								</tr>
								<tr align="left">
									<td>
										<div id='divproductos' style="display: block;"><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divcontenedor" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Seleccion de Devolución
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Tipo Devolución:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLI-cboTipoDevolucion" name="OBLI-cboTipoDevolucion" onKeyPress="return SoloNumeros(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Observaciones:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<textarea id="txtObservacion" name="txtObservacion" cols="50" rows="4" ></textarea>
									</td>
								</TR>
							</table>
						</td>
					</tr>
					
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos de la Devolución
										<INPUT type="hidden" id="txtSaldoVenta" name="txtSaldoVenta" value=''>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Fecha Devolución:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										
										<INPUT type="text" id="OBLI-txtFechaRevision" name="OBLI-txtFechaRevision" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaPrimerVencimiento(xajax.getFormValues('Form1'));" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Fecha Descuento:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										
										<INPUT type="text" id="OBLI-txtFechaDescuento" name="OBLI-txtFechaDescuento" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario3' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Saldo Venta:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtSaldoVenta" name="OBLI-txtSaldoVenta" value='0' readonly maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Total Devolución:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtTotalDevolucion" name="OBLI-txtTotalDevolucion" value='0' readonly maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Nuevo Saldo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtNuevoSaldo" name="OBLI-txtNuevoSaldo" value='0' readonly maxLength="10" size="10">
										
										<!--
										&nbsp;&nbsp;A Favor:
										<INPUT type="text" id="OBLI-txtSaldoFavor" name="OBLI-txtSaldoFavor" value='0' readonly maxLength="10" size="10">
										!-->
										
									</td>
								</tr>
								
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Saldo a Favor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtSaldoFavor" name="OBLI-txtSaldoFavor" value='0' readonly maxLength="10" size="10">
									</td>
								</tr>
								
								
							</table>
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Nuevas Cuotas
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Forma Pago:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="hidden" id="OBLI-txtCodFormaPago" name="OBLI-txtCodFormaPago" value=''>
										<INPUT type="text" id="OBLI-txtFormaPago" name="OBLI-txtFormaPago" value='0' readonly maxLength="20" size="10">
									
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Fecha Ultimo Pago:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="txtFechaUltimoPago" name="txtFechaUltimoPago" value='0' readonly maxLength="20" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Nº de Cuotas:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtNumCuotas" name="OBLI-txtNumCuotas" value='0' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Valor Cuotas:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtValorCuotas" name="OBLI-txtValorCuotas" value='0' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Primer Vcto.:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="txtPrimerVencimiento" name="txtPrimerVencimiento" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Límite Cuotas:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLI-txtLimiteCuotas" name="OBLI-txtLimiteCuotas" value='0' readonly maxLength="10" size="10">
									</td>
								</tr>
							</table>
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
									<input type="button" id="btnGrabar" name="btnGrabar" value="Grabar Devolución" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>

							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divcontenedorcliente" align="left" style="display: none; margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos del Cliente</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div id="detallecliente" align="left" style="display: block;">
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 34%">
												<tr align="left">
													<td class="tabla-alycar-label-peq">Cliente</td>
												</tr>
												<tr align="left">
													<td id='clie1' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Vendedor</td>
												</tr>
												<tr align="left">
													<td id='clie2' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Bloqueado</td>
												</tr>
												<tr align="left">
													<td id='clie3' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
											</table>
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 33%">
												<tr align="left">
													<td class="tabla-alycar-label-peq">Domicilio</td>
												</tr>
												<tr align="left">
													<td id='clie4' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Barrio</td>
												</tr>
												<tr align="left">
													<td id='clie5' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Estado</td>
												</tr>
												<tr align="left">
													<td id='clie6' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
											</table>
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 33%">
												<tr align="left">
													<td class="tabla-alycar-label-peq">Ciudad</td>
												</tr>
												<tr align="left">
													<td id='clie7' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Localidad</td>
												</tr>
												<tr align="left">
													<td id='clie8' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq">Sector</td>
												</tr>
												<tr align="left">
													<td id='clie9' class="tabla-alycar-texto-peq">&nbsp;</td>
												</tr>
											</table>
										</div>
									</td>
								</TR>
								
								<!--
								<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
									<tr align="left">
										<td colspan="6" class="tabla-alycar-fila-botones">
											<input type="button" name="btnActualizarCliente" value="Mantenedor de Clientes >>" class="boton" onclick="xajax_LlamaMantenedorClientes(xajax.getFormValues('Form1'));">
										</td>
									</tr>
								</table>
								!-->
								
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divdetalleventa" align="left" style="display: none; margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos de la Venta</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div align="left" style="display: block;">
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Total Venta</td>
													<td id='tddet1' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Descuentos</td>
													<td id='tddet2' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Pie de Venta</td>
													<td id='tddet3' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Devoluciones</td>
													<td id='tddet4' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Traspasos</td>
													<td id='tddet5' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Crédito Actual</td>
													<td id='tddet6' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Abono Traspaso</td>
													<td id='tddet7' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Total Abonos</td>
													<td id='tddet8' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</TR>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Saldo Venta</td>
													<td id='tddet9' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</TR>
											
											</table>
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 50%">
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Sector Venta</td>
													<td id='tddet10' class="tabla-alycar-texto-peq" style="width: 60%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Forma Pago</td>
													<td id='tddet11' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Valor Cuotas</td>
													<td id='tddet12' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Nº de Cuotas</td>
													<td id='tddet13' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Fecha Venta</td>
													<td id='tddet14' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Fecha Ult. Revisión</td>
													<td id='tddet15' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Estado Tarjeta</td>
													<td id='tddet16' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Fecha Ult. Abono</td>
													<td id='tddet17' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</TR>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Monto Ult. Abono</td>
													<td id='tddet18' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</TR>
											</table>
										</div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
			
			
			<div id="imprimetarjeta" style="display: none; margin-left:2px; padding: 2px;">										

				<table class="tabla-alycar" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td id='imp' colspan='9' class="tabla-alycar-texto-peq" align='center'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Fecha:</td>
						<td id='imp1' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>	
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Sector:</td>
						<td id='imp2' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>	
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Dirección:</td>
						<td id='imp3' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>	
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Ciudad:</td>
						<td id='imp4' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Barrio:</td>
						<td id='imp5' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Cliente:</td>
						<td id='imp6' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>		
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Vendedor:</td>
						<td id='imp7' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Fecha Venta:</td>
						<td id='imp8' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Monto Venta:</td>
						<td id='imp9' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>		
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Descuento:</td>
						<td id='imp10' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Pie de Venta:</td>
						<td id='imp11' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Devoluciones:</td>
						<td id='imp12' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Traspasos:</td>
						<td id='imp13' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>	
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Saldo Venta:</td>
						<td id='imp14' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Forma de Pago:</td>
						<td id='imp15' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Total de Abonos:</td>
						<td id='imp16' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Crédito:</td>
						<td id='imp17' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td class="tabla-alycar-texto-peq" align='left' style="width: 20%">Total Saldo:</td>
						<td id='imp18' class="tabla-alycar-texto-peq" align='left'>&nbsp;</td>
					</tr>
					<tr align="left">
						<td colspan='2'>
							<div id='divproductosimp'><div>
						</td>
					</tr>
					<tr align="left">
						<td colspan='2'>
							<div id='divabonosimp'><div>
						</td>
					</tr>
				</table>
			</div>
		
		</form>
		<div id="calendar-container"></div>
	
		{literal}
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "OBLI-txtFechaRevision",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
			Calendar.setup({inputField : "txtPrimerVencimiento",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
			Calendar.setup({inputField : "OBLI-txtFechaDescuento",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario3",step: 1});
		</script>
		{/literal}
	</body>
</HTML>