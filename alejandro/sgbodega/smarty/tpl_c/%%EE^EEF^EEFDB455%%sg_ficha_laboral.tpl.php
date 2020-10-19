<?php /* Smarty version 2.6.18, created on 2013-11-06 16:30:12
         compiled from sg_ficha_laboral.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
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
		
		<?php echo '
		
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLIfecha_ing, #OBLIfecha_cont, #OBLIfecha_ter_cont, #OBLIfecha_fin, #OBLIcal_vac \').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			$(document).ready(function() { 
                            $.datepicker.regional[\'es\'] = {
                                  closeText: \'Cerrar\',
                                  prevText: \'<Ant\',
                                  nextText: \'Sig>\',
                                  currentText: \'Hoy\',
                                  monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
                                  monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
                                  dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Miércoles\', \'Jueves\', \'Viernes\', \'Sábado\'],
                                  dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mié\',\'Juv\',\'Vie\',\'Sáb\'],
                                  dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sá\'],
                                  weekHeader: \'Sm\',
                                  dateFormat: \'dd/mm/yy\',
                                  firstDay: 1,
                                  isRTL: false,
                                  showMonthAfterYear: false,
                                  yearSuffix: \'\'};
                           $.datepicker.setDefaults($.datepicker.regional[\'es\']);                            
                            $(\'#OBLIfecha_nac\').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                }); 
                           
                            $("#cboPersona").autocomplete({
                                source : \'busquedas/busqueda_persona.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'OBLI-txtCodCobrador\').value = rut;
                                    $.ajax({
                                          url: "busquedas/buscar_cupo_persona.php?rut="+rut,
                                          success: function(datos){
                                                document.getElementById(\'OBLItxtMonto_1\').value = datos;
                                            }
                                        });
                                    }
                                });
								$("#tipo_pr").change(function () {
									if (($("#tipo_pr :selected").val()==\'3\')){
										$(".oculto").show();
										}
									else{
										$(".oculto").hide();
										}
								});
							$("#OBLIcal_vac").change(function(){
									var fecha = $("#OBLIcal_vac").val();
								 	$.ajax({
										url: \'busquedas/calculo_vacas.php?fecha=\'+fecha,
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
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
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

		'; ?>

	
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ficha Laboral</label></td>
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
									<td class="tabla-alycar-label" >Cargo</td>
									<td class="tabla-alycar-texto" ><input name="OBLIcargo" type="text" id="OBLIcargo" size="75"/></td>
									<td class="tabla-alycar-label" >Area</td>
									<td class="tabla-alycar-texto" ><select name="OBLIarea" id="OBLIarea"></select></td>
								</tr>


								<tr align="left">
									<td class="tabla-alycar-label" >Empresa</td>
									<td class="tabla-alycar-texto" ><select name="OBLIempresa" id="OBLIempresa"></select></td>
									<td class="tabla-alycar-label" >Fecha Ingreso</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIfecha_ing" id="OBLIfecha_ing" onkeypress="return SoloNumeros(this, event, 0)"/></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Fecha Contrato</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIfecha_cont" id="OBLIfecha_cont" onkeypress="return SoloNumeros(this, event, 0)"/></td>
									<td class="tabla-alycar-label" >Fecha Termino Contrato</td>
									<td class="tabla-alycar-texto" ><input type="text" name="fecha_ter_cont" id="fecha_ter_cont" onkeypress="return SoloNumeros(this, event, 0)" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Fecha Finiquito</td>
									<td class="tabla-alycar-texto" ><input type="text" name="fecha_fin" id="fecha_fin" onkeypress="return SoloNumeros(this, event, 0)"/> </td>
									<td class="tabla-alycar-label" >Causa Finiquito</td>
									<td class="tabla-alycar-texto" ><input type="text" name="finiquito" id="finiquito" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Estado Empleado</td>
									<td class="tabla-alycar-texto" ><select name="est_emp" id="est_emp"></select></td>
									<td class="tabla-alycar-label" >Fecha Calculo Vacaciones</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIcal_vac" id="OBLIcal_vac" onkeypress="return SoloNumeros(this, event, 0)"/>  </td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Dias Vacaciones</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIdias_vacas" id="OBLIdias_vacas" onkeypress="return SoloNumeros(this, event, 0)"/> </td>
									<td class="tabla-alycar-label" >Asignacion Materiales</td>
									<td class="tabla-alycar-texto" >
                                    
                                    	  <input type="checkbox" name="celular" id="celular"/> 
                                    	  Celular
                                   	  <br />
                                    	  <input type="checkbox" name="auto" id="auto"/> 
                                    	  Auto
                                   	  <br />
                                    	  <input type="checkbox" name="moto" id="moto"/> 
                                    	  Moto
                                   	  <br />
                                    	  <input type="checkbox" name="asig_caja" id="asig_caja"/> 
                                    	  Asignacion Caja
									   </td>
								</tr>

								<tr align="left">
								  <td class="tabla-alycar-label" >&nbsp;</td>
								  <td class="tabla-alycar-texto" >&nbsp;</td>
								  <td class="tabla-alycar-texto" >Monto Asignacion Caja</td>
								  <td class="tabla-alycar-texto" ><input type="text" name="monto_asig_caja" id="monto_asig_caja" onkeypress="return SoloNumeros(this, event, 0)"/></td>
							  </tr>
								<tr align="left">
									<td class="tabla-alycar-label" >Tipo de Pago Remuneracion</td>
									<td class="tabla-alycar-texto" ><select name="tipo_pr" id="tipo_pr"></select></td>
								</tr>
								<tr align="left" class="oculto" style="display:none">
									<td class="tabla-alycar-label" >Nro Cuenta</td>
									<td class="tabla-alycar-texto" ><input type="text" name="nro_cuenta" id="nro_cuenta"/></td>
									<td class="tabla-alycar-label" >Tipo Cuenta</td>
									<td class="tabla-alycar-texto" ><select name="tipo_cuenta" id="tipo_cuenta"></select></td>
								</tr>
								<tr align="left" class="oculto" style="display:none">
									<td class="tabla-alycar-label" >Banco</td>
									<td class="tabla-alycar-texto" ><select name="banco" id="banco"></select></td>
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