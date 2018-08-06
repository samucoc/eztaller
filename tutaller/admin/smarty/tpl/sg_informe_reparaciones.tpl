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
                            
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>		
		{literal}
                <script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha1').mask("99/99/9999");
				$('#OBLI-txtFecha2').mask("99/99/9999");
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
                            $('#OBLI-txtFecha1,#OBLI-txtFecha2').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                }); 
                            $("#cboPersona").autocomplete({
                                source : 'busquedas/busqueda_persona.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('rut_trabajador').value = rut;
                                    }
                                });
                            $("#cboPatente").autocomplete({
                                source : 'busquedas/busqueda_vehiculo.php'
                                });
                            $("#cboMecanico").autocomplete({
                                source : 'busquedas/busqueda_mecanico.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('rut_mecanico').value = rut;
                                    }
                                });
                            }); 		
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
	<body  onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Checklist-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Informe de Reparaciones</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Codigo Reparacion:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="detalle_repara_ncorr" id="detalle_repara_ncorr" value="" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="cboPatente" id="cboPatente" value="" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="cboPersona" id="cboPersona" value="" />
                                        <input type="hidden" name="rut_trabajador" id="rut_trabajador"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Mecanico:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="cboMecanico" id="cboMecanico" value="" />
                                        <input type="hidden" name="rut_mecanico" id="rut_mecanico"></input>
									</td>	
								</tr>
                                <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Nro Documento:</td>
							      <td class="tabla-alycar-texto" ><input type="text" id="documento" name="documento" value='' onkeypress="return SoloNumeros(this, event, 0)"  /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Forma de Pago:
							        <label class="requerido"> * </label></td>
							      <td class="tabla-alycar-texto" style=""><select id="cboPago" name="cboPago" onkeypress="return SoloNumeros(this, event, 0)" >
							        <option value="">Todos</option>
							        <option value="Efectivo">Efectivo</option>
							        <option value="Cheque">Cheque</option>
							        <option value="3">Transferencia</option>
							        <option value="4">Tarjeta Credito</option>
							        </select></td>
							      <td class="tabla-alycar-label" > Numero Cheque:</td>
							      <td class="tabla-alycar-texto" ><input type="text" id="nro_boleta" name="nro_boleta" onkeypress="return SoloNumeros(this, event, 0)" /></td>
						        </tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLI-txtFecha1" name="OBLI-txtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10" />
										    al
                                        <INPUT type="text" id="OBLI-txtFecha2" name="OBLI-txtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10" />
									</td>	
								</tr>
								<tr align="left">
									<td colspan="4" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
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
										<div id='divabonos'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
	</body>
</HTML>