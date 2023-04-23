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
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
            {literal}
			<script type="text/javascript">
                $(function($) { 
                    $('#txtFecha1, #txtFecha2').mask("99/99/9999");
                    }
                ); 		
            </script>
            <script>
            $(document).ready(function() { 
				$.datepicker.regional['es'] = {
					  closeText: 'Cerrar',
					  prevText: 'Ant',
					  nextText: 'Sig',
					  currentText: 'Hoy',
					  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
					  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
					  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
					  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
					  weekHeader: 'Sm',
					  dateFormat: 'dd/mm/yy',
					  firstDay: 1,
					  isRTL: false,
					  showMonthAfterYear: false,
					  yearSuffix: ''};
			    $.datepicker.setDefaults($.datepicker.regional['es']);                            
				$('#txtFecha1,#txtFecha2').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				});
            
            </script>
            {/literal}         
	
	</HEAD>
	<body style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img width="48" height="48" src="../images/SURTIDOR GASOIL 2.bmp"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Informe de ordenes de compras</label></td>
								</tr>
							</table>
							<br>
                            <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							  <tr align="left">
							    <td class="tabla-alycar-label"  width="20%" style="width: 10%">Fecha</td>
							    <td class="tabla-alycar-texto"  width="30%" style="width: 20%">
                                	<input type="text" id="txtFecha1" name="txtFecha1" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" />
                                    al
                                    <input type="text" id="txtFecha2" name="txtFecha2" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" />
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Estado</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<select name="estado" id="estado">
                                    	<option value=''>TODOS</option>
                                        <option value="PENDIENTE">PENDIENTE</option>
                                        <option value='AUTORIZADO'>AUTORIZADO</option>
                                        <option value="CANCELADO">RECHAZADO</option>
                                        <option value="AUTORIZADO-FP">AUTORIZADO FORMAS PAGO</option>
                                        <option value="RECEPCION-PENDIENTE-PRODUCTOS">RECEPCION PARCIAL PRODUCTOS</option>
                                        <option value="RECEPCION-PRODUCTOS">RECEPCION COMPLETA PRODUCTOS</option>
                                    </select>
                                </td>
						      </tr>
                              <tr>
  							    <td class="tabla-alycar-label"  width="20%" style="width: 10%">Nro Orden de Compra</td>
							    <td class="tabla-alycar-texto"  width="30%" style="width: 20%" colspan="3">
									<input type="text" name="nro_oc" id="nro_oc"/>
                                </td>

                              
                              </tr>
                              <tr>
                              	<td colspan="4" class="tabla-alycar-label" >
                                	<input type="button" name="btnGrabar" id="btnGrabar" value="Buscar" class="boton" onclick="ValidaFormularioMantenedor();"/>
                                </td>
                              </tr>
                             </table>
						</form>
					</td>
				</tr>
			</table>
		</div>					
		        <div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divabonos'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		<div id="calendar-container"></div>
	
	</body>
</HTML>
