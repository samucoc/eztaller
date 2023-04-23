<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
           <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		      
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        
		{literal}
                <script type="text/javascript">
			$(function($) { 
				$('#fecha_pago').mask("99/99/9999");
				$('#txtFecha2').mask("99/99/9999");
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
                                  dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S�b'],
                                  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S�'],
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
							 $("#OBLI-cboAlumno").autocomplete({
                                source : 'busquedas/busqueda_alumno.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLIRutAlumno').value = rut;
                                    }
                                });
                             
                            });
		</script>
		<script type="text/javascript" > 
                        function verificaValor(temp){
                            if (temp==''){
                                document.getElementById('OBLI-txtCodCobrador').value="";
                                }
                            }
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
			function exportar_excel(id_form, id_tabla)
			{
				 // Obtiene el contenido de la tabla indicada
				 var tabla = $("#" + id_tabla).html();
				 // A�ade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el c�digo en PHP
				 $("#" + id_form).submit();
			}
 		</script> 
 		<style>
 			.enmarcado{
				border:1px solid #FF0000; /* ancho - tipo - color */
				margin:3px; /* distancia entre el borde y el contenido */
				width:50px /* el ancho de la img */
			}
		{/literal}
			{if ($enmarcado!='0')}
		{literal}
				#contenedor{
				   position:relative; /*Establece un sistema de coordenadas para sus elementos "hijo"*/
				}

				#contenedor:before {
				    content: url('../images/tick.png');
				    display:block;
				    width: 48px;
				    height:48px;
				    position:absolute;
				    left: 10px;
				    top: -50%;
				}

		{/literal}
			{/if}
		{literal}	
 		</style>
		{/literal}
	
	</HEAD>
	<body onload="xajax_CargaListado(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
		<form id="Form1" name="Form1" method="post" runat="server">
		<div id="divcontenedor" align="left">
			<table class="curvar" style="width:100%; padding-top:5px; padding-button:20px; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/gest_esc/ficha-alumno.png" /></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Cartola Alumno</label>
                                      	<input type="hidden" name="OBLIRutAlumno" id="OBLIRutAlumno" value="{$rut_alumno}"/>
                                
                                    </td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
		</div>
                        <div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
                            <table border="0" class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                	<td class="grilla-tab-fila-titulo" colspan="4">
                                		<a href="#" onclick="ImprimeDiv('divabonos_imp');">
											<img src='../images/fin_comp/cartola.png' title='Ver Cartola' width="48"/>
										</a>
										<a href="#" onclick="ImprimeDiv('divabonos_movimientos_imp');" title='Pagar'>
											<img src='../images/fin_comp/pagos.png'  title='Ver Detalle Pago' width="48"/>
										</a>
										<a href="#" onclick='showPopWin("sg_alumnos_cobranza_pago.php?rut_alumno={$rut_alumno}", "Ingresar Pago", 800, 600, null);' title='Pagar'>
											<img src='../images/fin_comp/pago.png'  title='Pagar' width="48"/>
										</a>
										<a href="#" onclick='showPopWin("sg_confirmar_alumnos_imprimir_contrato.php?rut_alumno={$rut_alumno}", "Imprime Contrato", 800, 600, null);' title="Ver Contrato" >
											<img src='../images/fin_comp/contrato.png' title="Ver Contrato"  width="48"/>
										</a>
										<a href="#" onclick='showPopWin("sg_alumnos_imprimir_certificado_beca.php?rut_alumno={$rut_alumno}", "Imprime Certificado Beca", 800, 600, null);' title="Ver Certificado Beca" >
											<img src='../images/fin_comp/beca.png' title="Ver Certificado Beca"  width="48"/>
										</a>
									    <a href="#" id="contenedor" onclick='showPopWin("sg_mant_tablas.php?tbl=Bitacoras&rut={$rut_alumno}", "Bitacoras", 800, 600, null);' title="Bit&aacute;coras del Alumno" >
											<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora de Cobranza"  width="48" id="imagen_bitacora"  />
										</a>
									</td>
                                    <td class="grilla-tab-fila-titulo" align="center">
                                    	<a href="#" onclick='showPopWin("../../sige/sitio/sg_mant_consulta_alumno.php?tbl=alumnos&rut={$rut_alumno}", "Consulta Ficha Alumnos", 1200, 600, null);' title="Consulta Ficha Alumnos" >
											<img src='../images/gest_esc/ficha-alumno.png' title="Consulta Ficha Alumnos"  width="48"/>
										</a>										
                                    </td>
                                    <td class="grilla-tab-fila-titulo" align="center">
                                        <a href="#" onclick="xajax_Volver(xajax.getFormValues('Form1'),'{$rut_alumno}');">
                                        	<img src='../images/basicos/salida.png' title="Volver"  width="48"/>
										</a>

                                    </td>
                                    <td class="grilla-tab-fila-titulo" >
                                    	Cambiar A&ntilde;o
                                    	<select id="anio_buscar" name="anio_buscar" onchange="xajax_CambiarAnio(xajax.getFormValues('Form1'));">
                                    		
                                    	</select>
                                    </td>
                                </tr>
							</table>
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="justify" valign="top">
									<td colspan="2">
										<div id='divabonos'><div>
									</td>
									<td colspan="2" style="display:none">
										<div id='divabonos_imp'><div>
									</td>
								</TR>
                            </table>
                            <table border="0" class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
                                  <tr>
                                	<td colspan="2" style="display:none">
										<div id='divabonos_movimientos' ><div>
									</td>
                                	<td colspan="2" style="display:none">
										<div id='divabonos_movimientos_imp' ><div>
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