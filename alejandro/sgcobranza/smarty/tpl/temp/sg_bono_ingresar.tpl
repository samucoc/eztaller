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
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>
		{literal}
		<script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha').mask("99/99/9999");
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
				$('#OBLI-txtFecha').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#OBLItxtMontoIngresar").iMask({
						   type   : 'number'
						 , decDigits   : 0
						 , decSymbol   : ''
						 , groupSymbol : '.'
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
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
		<form id="Form1" name="Form1" method="post" runat="server">
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingreso de Bono<br />
								  </label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa</td>
									<td class="tabla-alycar-texto" style="width: 20%">
                                        <select name="OBLIcentro_costo" id="OBLIcentro_costo">
                                        
                                        </select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha</td>
                                	<td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="OBLI-txtFecha" name="OBLI-txtFecha" onKeyPress="return SoloNumeros(this, event, 0)"  size="10"/>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador</td>
                                	<td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="OBLItxtRut" name="OBLItxtRut" onKeyPress="return SoloNumeros(this, event, 0)"  onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sggeneral.trabajadores', 'rut', '', 'OBLItxtRut', 'OBLItxtNombres', '');" size="10"/>
										<input name="OBLItxtNombres" type="text" id="OBLItxtNombres" size="50" maxlength="50" readonly="readonly"/>
                                        <a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="xajax_CargaPopWin(xajax.getFormValues('Form1'),'sg_busqueda.php?entidad=12&obj1=OBLItxtRut&obj2=OBLItxtNombres');"></a>
									</td>	
								</tr>
                                <tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto</td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar"  onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
								</tr>
				<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Realizar Deposito</td>
									<td class="tabla-alycar-texto" >
										<select name="es_deposito" id="es_deposito">
		<option value="0">No</option>
		<option value="1">Si</option>
										</select>
									</td>
								</tr>
								<tr align="left">
                                	<td class="tabla-alycar-label" style="width: 20%">Forma Pago</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<select id="caja" name="caja" onKeyPress="return SoloNumeros(this, event, 0)">
                                        </select>
									</td>
                                </tr><tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Detalle</td>
									<td class="tabla-alycar-texto" >
										<textarea id="detalle" name="detalle" cols="100" rows="5"></textarea>
								  </td>
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
							
							</table>
					</td>
				</tr> 
                <tr>
                <td>
                        <div id='divresultado'></div>
                    </td>
                </tr>
			</table>
		</div>	
  		</form>
	</body>
</HTML>
