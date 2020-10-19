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
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
		
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
				$('#OBLIfecha_ing, #OBLIfecha_cont, #OBLIfecha_ter_cont, #OBLIfecha_fin, #OBLIcal_vac ').mask("99/99/9999");
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
                            $('#OBLIfecha_nac').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                }); 
                           
                            $("#cboPersona").autocomplete({
                                source : 'busquedas/busqueda_persona.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLI-txtCodCobrador').value = rut;
                                    $.ajax({
                                          url: "busquedas/buscar_cupo_persona.php?rut="+rut,
                                          success: function(datos){
                                                document.getElementById('OBLItxtMonto_1').value = datos;
                                            }
                                        });
                                    }
                                });
								$("#tipo_pr").change(function () {
									if (($("#tipo_pr :selected").val()=='3')){
										$(".oculto").show();
										}
									else{
										$(".oculto").hide();
										}
								});
							$("#OBLIcal_vac").change(function(){
									var fecha = $("#OBLIcal_vac").val();
								 	$.ajax({
										url: 'busquedas/calculo_vacas.php?fecha='+fecha,
										success : function(data){
											document.getElementById("OBLIdias_vacas").value = data;
											}
										});
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
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ficha Previsional</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" >Apellidos</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIape_pat" id="OBLIape_pat" readonly="readonly"/> <input type="text" name="OBLIape_mat" id="OBLIape_mat" readonly="readonly"/></td>
									<td class="tabla-alycar-label" >Nombres</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLInombres" id="OBLInombres" readonly="readonly"/></td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" >Rut</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIrut" id="OBLIrut" maxlength="8" onkeypress="return SoloNumeros(this, event, 0)" readonly="readonly"/> </td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >AFP</td>
									<td class="tabla-alycar-texto" ><select name="OBLIAfp" id="OBLIAfp"></select></td>
									<td class="tabla-alycar-label" >Institucion de Salud</td>
									<td class="tabla-alycar-texto" ><select name="OBLIsalud" id="OBLIsalud">
									  </select></td>
								</tr>


								<tr align="left">
								  <td class="tabla-alycar-label" >Porcentaje Cotizacion</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="OBLIporc_cot" id="OBLIporc_cot" /></td>
									<td class="tabla-alycar-label" >Porcentaje Cotizacion</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLImonto_salud" id="OBLImonto_salud" /></td>
								</tr>

								<tr align="left">
								  <td class="tabla-alycar-label" >Porcentaje Cotizacion Adicional</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="porc_cot_adi" id="porc_cot_adi" /></td>
								  <td class="tabla-alycar-label" >Monto plan UF</td>
								  <td class="tabla-alycar-texto" ><input  type="text" id="plan_uf" name="plan_uf"/></td>
								</tr>

								<tr align="left">
								  <td class="tabla-alycar-label" >Monto Cotizacion Voluntaria</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="monto_cot_vol" id="monto_cot_vol" onkeypress="return SoloNumeros(this, event, 0)"/></td>
								  <td class="tabla-alycar-label" >Monto plan pesos</td>
								  <td class="tabla-alycar-texto" ><input type="text"  id="plan_pesos" name="plan_pesos"/></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" >&nbsp;</td>
								  <td class="tabla-alycar-texto" >&nbsp;</td>
								  <td class="tabla-alycar-label" >&nbsp;</td>
									<td class="tabla-alycar-texto" >&nbsp;</td>
								</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" >Ahorro Voluntario</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="ahorro_vol" id="ahorro_vol"/>
								    &nbsp;</td>
								  <td class="tabla-alycar-label" >Caja Compensacion</td>
								  <td class="tabla-alycar-texto" ><select name="OBLIcaja_compensacion" id="OBLIcaja_compensacion">
								    </select></td>
							  </tr>

								<tr align="left">
								  <td class="tabla-alycar-label" >Seguro Cesantia</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="seguro_cesantia" id="seguro_cesantia"/></td>
								  <td class="tabla-alycar-label" >&nbsp;</td>
								  <td class="tabla-alycar-texto" >&nbsp;</td>
							  </tr>

							</table>
							<br />
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							
							</table>
                            <br />
                            <div id='divdetalle' style="display: block;">
								<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr align="left">
										<td colspan='2'>
											<div id='divresultado'></div>
										</td>
									</TR>
								</table>
							
							</div>	
							
						</form>
					</td>
				</tr>
			</table>
		</div>		
	</body>
</HTML>