<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Revisión de Kardex </title>
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
			<input type="hidden" name="txtNumFolio" id="txtNumFolio" value="{$folio}"/>
			<input type="hidden" name="txtEmpresa" id="txtEmpresa" value="{$empresa}"/>
			<div id="divresultado"> 
            <div id="divcontenedorcliente" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos Generales</td>
								</tr>
								<tr align="left" >
                                    <td class="tabla-alycar-label" style="font-size:16px">Folio</td>
                                    <td class="tabla-alycar-texto" style="font-size:16px">{$folio}</td>
                                </tr>
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
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divdetalleventa" align="left" style="margin:2px; padding: 2px;">
			
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
													<td class="tabla-alycar-label-peq" style="width: 35%">Pie de Venta</td>
													<td id='tddet3' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Crédito Actual</td>
													<td id='tddet6' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Saldo Venta</td>
													<td id='tddet9' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</TR>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Fecha Venta</td>
													<td id='tddet14' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
											
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
													<td class="tabla-alycar-label-peq" style="width: 35%">Estado Tarjeta</td>
													<td id='tddet16' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
											</table>
											<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr> 
												<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos de la Aprobacion</td>
											</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Usuario Aprobacion</td>
													<td id='tddet19' class="tabla-alycar-texto-peq" style="width: 60%">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label-peq" style="width: 35%">Fecha Aprobacion</td>
													<td id='tddet20' class="tabla-alycar-texto-peq" style="width: 65%">
													</td>
												</tr>
											</table>
										</div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="divlistado" align="left" style="margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divproductos' ></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
            </div>
<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">		
            <tr>
                <td colspan='14' class="grilla-tab-fila-titulo" align="left">
                    <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
                    <!--<input type="button" name="btnExportar" value="Exportar a Excel" class="boton" onclick="enviaPivotExcel('Form1');">!-->
                </td>
            </tr>
			</table>
            </td>
        </tr>
    </table>
		</form>
	</body>
</HTML>