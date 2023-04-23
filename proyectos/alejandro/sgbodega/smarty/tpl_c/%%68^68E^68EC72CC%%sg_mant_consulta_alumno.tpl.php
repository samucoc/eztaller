<?php /* Smarty version 2.6.18, created on 2017-04-10 11:38:02
         compiled from sg_mant_consulta_alumno.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		
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
                
                <!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
            <script src="../includes_js/jquery.uploadify.min.js" type="text/javascript"></script>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadify.css">

			<?php echo '
			<script type="text/javascript">
	   			function ImprimeDiv(id)
				{
						var c, tmp;
					
					  	c = document.getElementById(id);
						  
					   	temp = window.open(" ","Impresion.");
					  
					   	temp.document.open();
					   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
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
				function calcular_edad(fecha) {
					var fechaActual = new Date()
					var diaActual = fechaActual.getDate();
					var mmActual = fechaActual.getMonth() + 1;
					var yyyyActual = fechaActual.getFullYear();
					FechaNac = fecha.split("/");
					var diaCumple = FechaNac[0];
					var mmCumple = FechaNac[1];
					var yyyyCumple = FechaNac[2];
					//retiramos el primer cero de la izquierda
					if (mmCumple.substr(0,1) == 0) {
					mmCumple= mmCumple.substring(1, 2);
					}
					//retiramos el primer cero de la izquierda
					if (diaCumple.substr(0, 1) == 0) {
					diaCumple = diaCumple.substring(1, 2);
					}
					var edad = yyyyActual - yyyyCumple;

					//validamos si el mes de cumpleaños es menor al actual
					//o si el mes de cumpleaños es igual al actual
					//y el dia actual es menor al del nacimiento
					//De ser asi, se resta un año
					if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
						edad--;
						}
					return edad;
					};
            </script> 
            <script>
			  $(function() {
			    $( "#accordion" ).accordion({
			    	heightStyle: "content",
			    	collapsible:true,
				    beforeActivate: function(event, ui) {
				         // The accordion believes a panel is being opened
				        if (ui.newHeader[0]) {
				            var currHeader  = ui.newHeader;
				            var currContent = currHeader.next(\'.ui-accordion-content\');
				         // The accordion believes a panel is being closed
				        } else {
				            var currHeader  = ui.oldHeader;
				            var currContent = currHeader.next(\'.ui-accordion-content\');
				        }
				         // Since we\'ve changed the default behavior, this detects the actual status
				        var isPanelSelected = currHeader.attr(\'aria-selected\') == \'true\';

				         // Toggle the panel\'s header
				        currHeader.toggleClass(\'ui-corner-all\',isPanelSelected).toggleClass(\'accordion-header-active ui-state-active ui-corner-top\',!isPanelSelected).attr(\'aria-selected\',((!isPanelSelected).toString()));

				        // Toggle the panel\'s icon
				        currHeader.children(\'.ui-icon\').toggleClass(\'ui-icon-triangle-1-e\',isPanelSelected).toggleClass(\'ui-icon-triangle-1-s\',!isPanelSelected);

				         // Toggle the panel\'s content
				        currContent.toggleClass(\'accordion-content-active\',!isPanelSelected)    
				        if (isPanelSelected) { currContent.slideUp(); }  else { currContent.slideDown(); }

				        return false; // Cancel the default action
				    }
			    });
			  });
			</script>         
			<style type="text/css">
				body, .boton, .tabla-alycar-label, .tabla-alycar-campo, select, input{
					font-size: 10px !important;

				}
			</style>              
            '; ?>

                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server" enctype="multipart/form-data">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Database-Add-48.png"></td>
									<td style="width: 93%">
										<label class="form-titulo">
											&nbsp;&nbsp; Consulta Ficha de Alumno <label id="alumno" name="alumno"></label>
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $this->_tpl_vars['TABLA']; ?>
'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="<?php echo $this->_tpl_vars['rut_trab']; ?>
"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                                	<a href="#" onclick="location.href='sg_mant_consulta_alumno.php?tbl=alumnos'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_alumnos_Notas(xajax.getFormValues('Form1'))">
												<img src='../images/gest_esc/promedio.png' title='Notas' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_alumnos_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_alumnos_Asistencia(xajax.getFormValues('Form1'))">
												<img src='../images/fin_comp/bitacora.png' title='Asistencia' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_alumnos_Apoderado(xajax.getFormValues('Form1'))">
												<img src='../images/gest_esc/ficha-apoderado.png' title='Apoderados' width="32"/>
											</a>
                                    	</td>
                                    </tr>
                                <tr>
	                               	<td colspan="2">
                                		<div id="accordion">
										  <h3>Datos Personales</h3>
										  <div>
										    <table>
											    <tr>
												    <td style="width: 70%">
													    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
													    	<tr align="left" valign="top">
													    		<td class="tabla-alycar-label" >Periodo</td>
																<td class="tabla-alycar-texto" ><?php echo $this->_tpl_vars['anio']; ?>

					                                            </td>
																<td class="tabla-alycar-label" >Curso</td>
																<td class="tabla-alycar-texto" >
			    													<select id="OBLICodigoCurso" name="OBLICodigoCurso" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoCurso','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso')"></select>
																</td>
																<td class="tabla-alycar-label" >Matricula - Lista</td>
																	<td class="tabla-alycar-texto" >
			                                            			<input type="text" id="NumeroLista" name="NumeroLista" value="" onkeypress="return SoloNumeros(this, event, 0)" size="10" readonly="">
																</td>
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" colspan="2">Apellidos </td>
																<td class="tabla-alycar-texto" colspan="2">
							                                    		<input type="text" id="BSCPaternoAlumno" name="BSCPaternoAlumno" onkeypress="return Tabula(this, event, 0)" 
							                                    		 size="25"/>
							                                            <input type="hidden" id="OBLIPaternoAlumno" name="OBLIPaternoAlumno">
							                                            <script type="text/javascript">
																		var	obli = 'OBLIPaternoAlumno';
																		var combo = 'BSCPaternoAlumno';
																		var tabla = 'alumnos';
							                                            	<?php echo '
							                                            	$(document).ready(function() {
																				$("#"+combo).autocomplete({
																					source : \'busquedas/busqueda_\'+obli+\'.php\',
																					select: function( event, ui ) {
																						var rut = ui.item.id;
																						document.getElementById(obli).value = rut;
																						xajax_CargaListado(xajax.getFormValues(\'Form1\'),obli,tabla);
																						}
																					});
																				});
																			'; ?>

							                                            
							                                            </script>
																		
							                                        	
																</td>
																<td class="tabla-alycar-texto" colspan="2">
							                                    	<input type="text" id="OBLIMaternoAlumno" name="OBLIMaternoAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="25" >
																</td>
															</tr>
															<tr>
																<td class="tabla-alycar-label" >Nombres Alumnos</td>
																<td class="tabla-alycar-texto" colspan="3">
							                                    														<input type="text" id="OBLINombresAlumno" name="OBLINombresAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																		
																</td>
																<td class="tabla-alycar-label" >Rut Alumno</td>
																<td class="tabla-alycar-texto">
																	<input type="text" id="OBLINumeroRutAlumno" name="OBLINumeroRutAlumno" value="" onkeypress="return SoloNumeros(this, event, 0)" size="10"> - 
																	<input type="text" id="OBLIDigitoRutAlumno" name="OBLIDigitoRutAlumno" value="" onkeypress="return SoloNumeros(this, event, 0)" size="3">
																	<input type="hidden" id="OBLIMatriculado" name="OBLIMatriculado" value="" onkeypress="return SoloNumeros(this, event, 0)" size="3">
																	

																</td>
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Fecha Nacimiento</td>
																<td class="tabla-alycar-texto">
                                            														<input type="text" id="OBLIFechaNacimiento" name="OBLIFechaNacimiento" class="OBLI-fecha" value="" onkeypress="return Tabula(this, event, 0)" size="10">
					                                                        <script type="text/javascript">
					                                                                var input = "OBLIFechaNacimiento";
					                                                                var button = "cldFechaNacimiento";
					                                                                <?php echo '
					                                                                $(function($) { 
					                                                                        $(\'#\'+input).mask("99/99/9999");
					                                                                        $(\'#\'+input).blur(function(){
					                                                                        	document.getElementById(\'edad\').innerHTML = calcular_edad($(\'#\'+input).val());
					                                                                        	});
					                                                                        }
					                                                                ); 		
					                                                                '; ?>

					                                            
					                                                        </script>                                                 
																</td>
																<td class="tabla-alycar-label" >Edad</td>
																<td class="tabla-alycar-texto" id="edad" name="edad">
																
																</td>
                                            					<td class="tabla-alycar-label" >Sexo</td>
																<td class="tabla-alycar-texto">
					                                            														<select id="OBLISexoAlumno" name="OBLISexoAlumno" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLISexoAlumno','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLISexoAlumno')"></select>
																		
																</td>
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Alumno PIE</td>
																<td class="tabla-alycar-texto">
					                                            														<input type="checkbox" value="1" id="OBLIPIE" name="OBLIPIE" onkeypress="return Tabula(this, event, 0)" >
					                                                	
																</td>
																<td class="tabla-alycar-label" >Alumno SEP</td>
																<td class="tabla-alycar-texto">
					                                            														<input type="checkbox" value="1" id="OBLISEP" name="OBLISEP" onkeypress="return Tabula(this, event, 0)" >
					                                                	
																</td>

																<td class="tabla-alycar-label" >Nuevo</td>
																<td class="tabla-alycar-texto">
					                                            	<select id="OBLINuevoAntiguo" name="OBLINuevoAntiguo">
					                                            		<option >Elija</option>
					                                            		<option value="0">SI</option>
					                                            		<option value="1">NO</option>
					                                            	</select>
					                                                	
																</td>

																
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Origien Indigena</td>
																<td class="tabla-alycar-texto">
					                                            														<input type="checkbox" value="1" id="OBLIOrigenIndigena" name="OBLIOrigenIndigena" onkeypress="return Tabula(this, event, 0)"value="1">
					                                                	
																</td>
																<td class="tabla-alycar-texto" colspan="5">
					                                            														<input type="text" id="OBLITextOrigenIndigena" name="OBLITextOrigenIndigena" onkeypress="return Tabula(this, event, 0)" size="50">
					                                                	
																</td>

															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Direccion</td>	
																<td class="tabla-alycar-texto" colspan="3">
							                                    														<input type="text" id="OBLIDireccionParticularAlumno" name="OBLIDireccionParticularAlumno" value="" onkeypress="return Tabula(this, event, 0)"
							                                    														size="45">
																		
																</td>
																<td class="tabla-alycar-label" >Comuna</td>
																<td class="tabla-alycar-texto">
					                                            														<select id="OBLICodigoComuna" name="OBLICodigoComuna" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoComuna','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoComuna')"></select>
																		
																</td>
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Email</td>
																<td class="tabla-alycar-texto" colspan="3">
					                                            														<input type="text" id="OBLIEMailAlumno" name="OBLIEMailAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																		
																</td>
																<td class="tabla-alycar-label" >Telefono</td>
																<td class="tabla-alycar-texto">
							                                    														<input type="text" id="OBLITelefonoParticularAlumno" name="OBLITelefonoParticularAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="26"  maxlength="26">
																		
																</td>
															
															</tr>
													    </table>
												    </td>
												    <td style="width: 15%;">
													    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 15%; float:left">
													    	<tr align="left">
																<td class="tabla-alycar-label" >Foto</td>
																<td class="tabla-alycar-texto">
																		<script type="text/javascript">
																		var input_1 = "OBLIFotoAlumno";
							                                            	<?php echo '
							                                                    $(function() {
								                                                    $(\'#file-name\').uploadify({
								                                                        \'swf\'      			: \'uploadify.swf\',
								                                                        \'uploader\' 			: \'uploadify.php\',
																						\'buttonText\' 		: \'Subir Foto\',
																						\'onUploadSuccess\' 	: function(file, data, response){
																				            document.getElementById(\'img_\'+input_1).src = \'uploads/\'+file.name;
																							document.getElementById(input_1).value= \'uploads/\'+file.name;
																						}
								                                                    });
							                                                	});
							                                               	'; ?>

							                                                    
							                                            </script> 
							                                           	<div id="queue"></div>
							                                            <input id="file-name" name="file-name" type="file" />
							                                             <img src="#" id="img_OBLIFotoAlumno" title="" width="200" height="200">
							                                            <input type="hidden" id="OBLIFotoAlumno" name="OBLIFotoAlumno" value="">
																</td>	    		
															</tr>
													    </table>
												    </td>
											    </tr>
										    </table>
										  </div>
										  <h3>Antecedentes Acad&eacute;micos</h3>
										  <div>
										  	<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr align="left">
													<td class="tabla-alycar-label" >Ultimo Promedio</td>
													<td class="tabla-alycar-texto">
                                            														<input type="text" id="OBLIUltimoPromedio" name="OBLIUltimoPromedio" value="" onkeypress="return Tabula(this, event, 0)">
													
													</td>
													<td class="tabla-alycar-label" >Alumno Repitente</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIAlumnoRepitente" name="OBLIAlumnoRepitente" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Colegio Anterior</td>
													<td class="tabla-alycar-texto">
                                            														<input type="text" id="OBLIColegioAnterior" name="OBLIColegioAnterior" value="" onkeypress="return Tabula(this, event, 0)" size="50">
													
													</td>
												</tr>
											</table>
										  </div>
										  <h3>Antecedentes Psicopedag&oacute;gicos</h3>
										  <div>
										    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr align="left">
													<td class="tabla-alycar-label" >Evaluacion Diferenciada</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIEvaluacionDiferenciada" name="OBLIEvaluacionDiferenciada" onkeypress="return Tabula(this, event, 0)" >
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextEvaluacionDiferenciada" name="OBLITextEvaluacionDiferenciada" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Diagnostico Aprendizaje</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIDiagnosticoAprendizaje" name="OBLIDiagnosticoAprendizaje" onkeypress="return Tabula(this, event, 0)" >
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextDiagnosticoAprendizaje" name="OBLITextDiagnosticoAprendizaje" onkeypress="return Tabula(this, event, 0)"  size="50">
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Diagnostico Psicologico</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIDiagnosticoPsicologico" name="OBLIDiagnosticoPsicologico" onkeypress="return Tabula(this, event, 0)" >
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextDiagnosticoPsicologico" name="OBLITextDiagnosticoPsicologico" onkeypress="return Tabula(this, event, 0)"  size="50">
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Diagnostico Neurologico</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIDiagnosticoNeurologico" name="OBLIDiagnosticoNeurologico" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextDiagnosticoNeurologico" name="OBLITextDiagnosticoNeurologico" onkeypress="return Tabula(this, event, 0)"  size="50">
		                                                	
													</td>
												</tr>
												<tr>																					<td class="tabla-alycar-label" >Tratamiento Otro</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLITratamientoOtro" name="OBLITratamientoOtro" onkeypress="return Tabula(this, event, 0)" >
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextTratamientoOtro" name="OBLITextTratamientoOtro" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>


												</tr>
											</table>
										  </div>
										  <h3>Antecedentes de Salud</h3>
										  <div>
										    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr align="left">
												  <td class="tabla-alycar-label" >Previsi&oacute;n</td>
													<td class="tabla-alycar-texto">
		                                            														<select id="OBLICodigoIsapre" name="OBLICodigoIsapre" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoIsapre','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoIsapre')">
		                                            														</select>
															
													</td>
													<td class="tabla-alycar-label" >Alumna Embarazada</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIAlumnaEmbarazada" name="OBLIAlumnaEmbarazada" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Enfermedad Cronica</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIEnfermedadCronica" name="OBLIEnfermedadCronica" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextEnfermedadCronica" name="OBLITextEnfermedadCronica" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>

												</tr>
												<tr>
													<td class="tabla-alycar-label" >Problema Ver</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIProblemaVer" name="OBLIProblemaVer" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextProblemaVer" name="OBLITextProblemaVer" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Problema Oir</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIProblemaOir" name="OBLIProblemaOir" onkeypress="return Tabula(this, event, 0)"value="1">
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextProblemaOir" name="OBLITextProblemaOir" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Problema Dental type="checkbox" value="1" </td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIProblemaDental" name="OBLIProblemaDental" onkeypress="return Tabula(this, event, 0)"value="1">
		                                                	
													</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="text" id="OBLITextProblemaDental" name="OBLITextProblemaDental" onkeypress="return Tabula(this, event, 0)" size="50">
		                                                	
													</td>
												</tr>
												</table>
										  </div>
										  <h3>Antecedentes Socioecon&oacute;micos</h3>
										  <div>
										    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr align="left">
													<td class="tabla-alycar-label" >Vive Con</td>
													<td class="tabla-alycar-texto">
		                                            														<select id="OBLIViveCon" name="OBLIViveCon" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIViveCon','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLIViveCon')"></select>
															
													</td>

												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Beca Alimenticia</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIBecaAlimenticia" name="OBLIBecaAlimenticia" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Beneficio Chile Solidario</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIBeneficioChileSolidario" name="OBLIBeneficioChileSolidario" onkeypress="return Tabula(this, event, 0)">
		                                                	
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Vulnerable</td>
													<td class="tabla-alycar-texto">
		                                            														<input type="checkbox" value="1" id="OBLIVulnerable" name="OBLIVulnerable" onkeypress="return Tabula(this, event, 0)">
		                                            </td>
												</tr>

											</table>
										  </div>
										</div>	
                                	</td>
                                </tr>

								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
 										<a href="#" onclick="javascript: document.Form1.submit();">
											<img src='../images/basicos/buscar.png' title='Otra Busqueda' width="32"/>
										</a>
									&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria		
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
                <div id="calendar-container"></div>
	</body>
</HTML>