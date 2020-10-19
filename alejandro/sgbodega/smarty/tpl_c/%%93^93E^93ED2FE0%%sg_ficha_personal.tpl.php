<?php /* Smarty version 2.6.18, created on 2013-10-30 16:13:14
         compiled from sg_ficha_personal.tpl */ ?>
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
				$(\'#OBLIfecha_nac\').mask("99/99/9999");
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
							$("#OBLIfecha_nac").change(function(){
									var fecha = $("#OBLIfecha_nac").val();
								 	var array_fecha = fecha.split("/") ;
									
									var anio_nacim = array_fecha[2];
									var mes_nacim = array_fecha[1];
									var dia_nacim = array_fecha[0];

									var fecha_hoy = new Date();
									var ahora_anio = fecha_hoy.getYear();
									var ahora_mes = fecha_hoy.getMonth();
									var ahora_dia = fecha_hoy.getDate();
									var edad = (ahora_anio + 1900) - anio_nacim;
									if ( ahora_mes < (mes_nacim - 1)) {
										edad--;
										}
									if (((mes_nacim - 1) == ahora_mes) && (ahora_dia < dia_nacim)){ 
										edad--;
										}
									if (edad > 1900){
										edad -= 1900;
										}
								 	 document.getElementById("OBLIedad").value = edad;
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ficha Personal</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" >Apellidos</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIape_pat" id="OBLIape_pat"/> <input type="text" name="OBLIape_mat" id="OBLIape_mat" /></td>
									<td class="tabla-alycar-label" >Nombres</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLInombres" id="OBLInombres" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Rut</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIrut" id="OBLIrut" maxlength="8" onkeypress="return SoloNumeros(this, event, 0)"/> </td>
									<td class="tabla-alycar-label" >Sexo</td>
									<td class="tabla-alycar-texto" >
                                    	<select name="OBLIsexo" id="OBLIsexo" >
                                        	<option value='2'>Femenino</option>
                                        	<option value='1'>Masculino</option>
                                    	</select>
                                    </td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Direccion</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIdireccion" id="OBLIdireccion"/></td>
									<td class="tabla-alycar-label" >Ciudad</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIciudad" id="OBLIciudad" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Telefono</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLItelefono" id="OBLItelefono" onkeypress="return SoloNumeros(this, event, 0)"/></td>
									<td class="tabla-alycar-label" >Celular</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIcelular" id="OBLIcelular" onkeypress="return SoloNumeros(this, event, 0)" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Fecha Nacimiento</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIfecha_nac" id="OBLIfecha_nac" onkeypress="return SoloNumeros(this, event, 0)"/> </td>
									<td class="tabla-alycar-label" >Nacionalidad</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLInacionalidad" id="OBLInacionalidad" /></td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Edad</td>
									<td class="tabla-alycar-texto" ><input name="OBLIedad" type="text" id="OBLIedad" onkeypress="return SoloNumeros(this, event, 0)" readonly="readonly" /> </td>
									<td class="tabla-alycar-label" >Estado Civil</td>
									<td class="tabla-alycar-texto" >
                                    	<select name="OBLIestado_civil" id="OBLIestado_civil" >
											<option value="1">Soltero</option>                                        
											<option value="2">Casado</option>                                        
											<option value="3">Viudo</option>                                        
											<option value="4">Divorciado</option>                                        
                                        </select>
                                    </td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Profesion / Estudios</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIprofesion" id="OBLIprofesion"/> <input type="text" name="OBLIestudios" id="OBLIestudios" /></td>
									<td class="tabla-alycar-label" >Total Cargas</td>
									<td class="tabla-alycar-texto" >
                                    	<input type="text" name="OBLItotal_cargas" id="OBLItotal_cargas" readonly/> 
                                        <input type="button" class="boton" name="agregar_carga" id="agregar_carga" value="Mantenedor Cargas Familiares" onclick="xajax_MantCargas(xajax.getFormValues('Form1'));" />
                                    </td>
								</tr>

								<tr align="left">
									<td class="tabla-alycar-label" >Contacto Emergencia</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIcont_eme" id="OBLIcont_eme"/></td>
									<td class="tabla-alycar-label" >Fono Emergencia</td>
									<td class="tabla-alycar-texto" ><input type="text" name="OBLIfono_eme" id="OBLIfono_eme" onkeypress="return SoloNumeros(this, event, 0)"/></td>
								</tr>
							</table>
							<br />
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onclick="javascript: document.Form1.submit();">
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