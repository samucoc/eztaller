<?php
/* Smarty version 3.1.33, created on 2020-10-15 21:56:30
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_mant_alumnos.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f88efbe861348_83477926',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b1ed2c142d0ecde3b6da0d1bb14a3e49d47b131e' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_mant_alumnos.tpl',
      1 => 1602809487,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f88efbe861348_83477926 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title></title>
       	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		
		<!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/common.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal.js"><?php echo '</script'; ?>
>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar.js"><?php echo '</script'; ?>
>
		<!-- librería para cargar el lenguaje deseado --> 
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/lang/calendar-es.js"><?php echo '</script'; ?>
>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar-setup.js"><?php echo '</script'; ?>
>
                
                <!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"><?php echo '</script'; ?>
>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"><?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 src="../includes_js/jquery.uploadifive.js" type="text/javascript"><?php echo '</script'; ?>
>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadifive.css">

			
			<?php echo '<script'; ?>
 type="text/javascript">
				function ocultar_fecha_rev(){
					var id = $('#OBLIReevaluacion').val();
					if (id=='1'){
						var appBanners = document.getElementsByClassName('class_fecha_reev');
						for (var i = 0; i < appBanners.length; i ++) {
						    appBanners[i].style.visibility = 'visible';
						}
					}else{
						var appBanners = document.getElementsByClassName('class_fecha_reev');
						for (var i = 0; i < appBanners.length; i ++) {
						    appBanners[i].style.visibility = 'hidden';
						}
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
            <?php echo '</script'; ?>
> 
            <?php echo '<script'; ?>
>
			  $(function() {
			    $( "#accordion" ).accordion({
			    	heightStyle: "content",
			    	collapsible:true,
				    beforeActivate: function(event, ui) {
				         // The accordion believes a panel is being opened
				        if (ui.newHeader[0]) {
				            var currHeader  = ui.newHeader;
				            var currContent = currHeader.next('.ui-accordion-content');
				         // The accordion believes a panel is being closed
				        } else {
				            var currHeader  = ui.oldHeader;
				            var currContent = currHeader.next('.ui-accordion-content');
				        }
				         // Since we've changed the default behavior, this detects the actual status
				        var isPanelSelected = currHeader.attr('aria-selected') == 'true';

				         // Toggle the panel's header
				        currHeader.toggleClass('ui-corner-all',isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top',!isPanelSelected).attr('aria-selected',((!isPanelSelected).toString()));

				        // Toggle the panel's icon
				        currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e',isPanelSelected).toggleClass('ui-icon-triangle-1-s',!isPanelSelected);

				         // Toggle the panel's content
				        currContent.toggleClass('accordion-content-active',!isPanelSelected)    
				        if (isPanelSelected) { currContent.slideUp(); }  else { currContent.slideDown(); }

				        return false; // Cancel the default action
				    }
			    });
			  });
			<?php echo '</script'; ?>
>         
			<style type="text/css">
				body, .boton, .tabla-alycar-label, .tabla-alycar-campo, select, input{
					font-size: 10px !important;

				}
			</style>              
            
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
											&nbsp;&nbsp; Ficha de Alumno <label id="alumno" name="alumno"></label>
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
											<input type="hidden" id="readonly" name="readonly" value="<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                                	<a href="#" onclick="xajax_CargaListado_alumnos_Ficha(xajax.getFormValues('Form1'))">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_alumnos_Ficha_PDF(xajax.getFormValues('Form1'))">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos PDF' width="32"/>
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
											<a href="#" id="contenedor" onclick="xajax_CargaListado_BitacorasAcademicas(xajax.getFormValues('Form1'))" title="Bit&aacute;cora Acad&eacute;mica" >
												<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora Acad&eacute;mica"  width="32" id="imagen_bitacora"  />
											</a>
											<a href="#" id="contenedor" onclick="xajax_CargaListado_Entrevistas(xajax.getFormValues('Form1'))" title="Departamento Psicolog&iacute;a" >
												<img src='../images/basicos/ficha-psicolgo.png' title="Departamento Psicolog&iacute;a"  width="32" id="imagen_bitacora"  />
											</a>
											<a href="#" id="contenedor" onclick="xajax_CargaListado_ArchivoPersonal(xajax.getFormValues('Form1'))" title="Departamento Psicolog&iacute;a" >
												<img src='../images/gest_fin/proveedores.png' title="Archivo Personal"  width="32" id="imagen_bitacora"  />
											</a>
											<a href="#" onclick="xajax_CargaListado_Contrato(xajax.getFormValues('Form1'))" title="Ver Contrato" >
												<img src='../images/fin_comp/contrato.png' title="Ver Contrato"  width="32"/>
											</a>
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
																<td class="tabla-alycar-texto" ><?php echo $_smarty_tpl->tpl_vars['anio']->value;?>

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
							                                    		 size="25" style="border: 2px solid #1B4978" />
							                                    		<input type="hidden" id="OBLIPaternoAlumno" name="OBLIPaternoAlumno">
							                                            <?php echo '<script'; ?>
 type="text/javascript">
																		var	obli = 'OBLIPaternoAlumno';
																		var combo = 'BSCPaternoAlumno';
																		var tabla = 'alumnos';
							                                            	
							                                            	$(document).ready(function() {
																				$("#"+combo).autocomplete({
																					source : 'busquedas/busqueda_'+obli+'.php',
																					select: function( event, ui ) {
																						var rut = ui.item.id;
																						document.getElementById(obli).value = rut;
																						xajax_CargaListado(xajax.getFormValues('Form1'),obli,tabla);
																						}
																					});
																				});
																			
							                                            
							                                            <?php echo '</script'; ?>
>
																		
							                                        	
																</td>
																<td 
																class="tabla-alycar-texto" colspan="2">
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
			                                                        <?php echo '<script'; ?>
 type="text/javascript">
			                                                                var input_1 = "OBLIFechaNacimiento";
			                                                                var button_1 = "cldFechaNacimiento";
			                                                                
			                                                                $(function($) { 
			                                                                		Calendar.setup({inputField : input_1, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_1 ,
																					step: 1});
			                                                                        $('#'+input_1).mask("99/99/9999");
			                                                                        $('#'+input_1).blur(function(){
			                                                                        	document.getElementById('edad').innerHTML = calcular_edad($('#'+input_1).val());
			                                                                        	});
			                                                                        }
			                                                                ); 		
			                                                                
			                                            
			                                                        <?php echo '</script'; ?>
>                                                 
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
																<td class="tabla-alycar-label" >Fecha Ingreso</td>
																<td class="tabla-alycar-texto">
                                    								<input type="text" id="OBLIFechaIngreso" name="OBLIFechaIngreso" class="OBLI-fecha" value="" onkeypress="return Tabula(this, event, 0)" size="10">
			                                                        <?php echo '<script'; ?>
 type="text/javascript">
			                                                                var input_fi = "OBLIFechaIngreso";
			                                                                var button_fi = "cldFechaIngreso";
			                                                                
			                                                                $(function($) { 
			                                                                		Calendar.setup({inputField : input_fi, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_fi ,
																					step: 1});
			                                                                        $('#'+input_fi).mask("99/99/9999");
			                                                                        }
			                                                                ); 		
			                                                                
			                                            
			                                                        <?php echo '</script'; ?>
>                                                 
																</td>
																<td class="tabla-alycar-label" >Nuevo</td>
																<td class="tabla-alycar-texto">
					                                            	<select id="OBLINuevoAntiguo" name="OBLINuevoAntiguo">
					                                            		<option >Elija</option>
					                                            		<option value="0">SI</option>
					                                            		<option value="1">NO</option>
					                                            	</select>
																</td>
																<td class="tabla-alycar-label" >Beneficio JUNAEB</td>
																<td class="tabla-alycar-texto">
					                                            	<input type="checkbox" value="1" id="OBLIBecaAlimenticia" name="OBLIBecaAlimenticia" onkeypress="return Tabula(this, event, 0)">
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
																<td class="tabla-alycar-label" >Email de Contacto</td>
																<td class="tabla-alycar-texto" colspan="3">
					                                           		<input type="text" id="OBLIEMailAlumno" name="OBLIEMailAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																	<input type="button" id="EnviarCorreo" class="button" onclick="xajax_EnviarCorreo(xajax.getFormValues('Form1'));" value="Enviar Correo"/>
																</td>
																<td class="tabla-alycar-label" >Telefono</td>
																<td class="tabla-alycar-texto">
							                                    														<input type="text" id="OBLITelefonoParticularAlumno" name="OBLITelefonoParticularAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="26"  maxlength="26">
																		
																</td>
															
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Datos Apoderado</td>
																<td class="tabla-alycar-texto" colspan="3">
					                                           		<input type="text" id="apoderado" name="apoderado" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																	
																</td>
															
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Cantidad Hermanos</td>
																<td class="tabla-alycar-texto" colspan="3">
					                                           		<input type="text" id="OBLICantidadHermanos" name="OBLICantidadHermanos" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																</td>
																<td class="tabla-alycar-label" >Edades Hermanos</td>
																<td class="tabla-alycar-texto">
							                                    	<input type="text" id="OBLITEdadesHermanos" name="OBLITEdadesHermanos" value="" onkeypress="return Tabula(this, event, 0)" size="26"  maxlength="26">
																</td>
															</tr>
															<tr align="left">
																<td class="tabla-alycar-label" >Lugar Ocupa Hermanos</td>
																<td class="tabla-alycar-texto" colspan="3">
					                                           		<input type="text" id="OBLILugarOcupaHermanos" name="OBLILugarOcupaHermanos" value="" onkeypress="return Tabula(this, event, 0)" size="45">
																</td>
																<td class="tabla-alycar-label" >Situacion Conyugal Padres</td>
																<td class="tabla-alycar-texto">
							                                    	<select id="OBLISituacionConyugalPadres" name="OBLISituacionConyugalPadres" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLISituacionConyugalPadres','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLISituacionConyugalPadres')"></select>
																</td>
															</tr>
												
													    </table>
												    </td>
												    <td style="width: 15%;">
													    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 15%; float:left">
													    	<tr align="left">
																<td class="tabla-alycar-label" >Foto</td>
																<td class="tabla-alycar-texto">
																		<?php echo '<script'; ?>
 type="text/javascript">
																		var input_1 = "OBLIFotoAlumno";
							                                            	
							                                                    $(function() {
								                                                    $('#file-name').uploadifive({
																						'buttonText' 		: 'Foto',
						                                                                'uploadScript' 		: 'uploadifive.php',
																						'auto' 				: true,
																						'onUploadComplete' 	: function(file, data){
																				            document.getElementById('img_'+input_1).src = 'uploads/'+file.name;
																							document.getElementById(input_1).value= 'uploads/'+file.name;
						        														}
						                                                            });
							                                                	});
							                                               	
							                                                    
							                                            <?php echo '</script'; ?>
> 
							                                           	<div id="queue"></div>
							                                            <img src="#" id="img_OBLIFotoAlumno" title="" width="200" height="200">
							                                            <input type="hidden" id="OBLIFotoAlumno" name="OBLIFotoAlumno" value="">
							                                            <div style="padding-left:35%">
							                                            	<input id="file-name" name="file-name" type="file" align="center" />
							                                            </div>
							                                            
																</td>	    		
															</tr>
													    </table>
												    </td>
											    </tr>
										    </table>
										  </div>
										  <h3>Antecedentes de Procedencia de Traslado</h3>
										  <div>
										  	<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
												<tr>
													<td class="tabla-alycar-label" >Clasifica</td>
													<td class="tabla-alycar-texto">
                                            			<select id="OBLIClasifica" name="OBLIClasifica">
                                            				<option value="">Elija</option>
                                            				<option value="1">SI</option>
                                            				<option value="2">NO</option>
                                            			</select>
													</td>
												</tr>
											   	<tr align="left">
													<td class="tabla-alycar-label" >Diagnostico Previo</td>
													<td class="tabla-alycar-texto">
                                            			<select id="OBLIDiagnosticoTELPrevio" name="OBLIDiagnosticoTELPrevio" >
		                                            		<option >Elija</option>
		                                            		<option value="1">TEL mixto</option>
		                                            		<option value="2">TEL expresivo</option>
		                                            		<option value="3">En observación</option>
					                                    </select>
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" style="width:14.5% ">Procedencia</td>
													<td class="tabla-alycar-texto" style="width:36% ">
                                            			<input type="text" id="OBLIProcedencia" name="OBLIProcedencia" value="" onkeypress="return Tabula(this, event, 0)" size="65">
													
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label">Fecha Diagn&oacute;stico</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIFechaDiagnostico" name="OBLIFechaDiagnostico" value="" onkeypress="return Tabula(this, event, 0)" size="65">
                                            			<?php echo '<script'; ?>
 type="text/javascript">
                                                                var input_2 = "OBLIFechaDiagnostico";
                                                                var button_2 = "cldFechaDiagnostico";
                                                                
                                                                $(function($) { 
                                                                        $('#'+input_2).mask("99/99/9999");
                                                                        Calendar.setup({inputField : input_2, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_2 ,
																					step: 1});
                                                                        }
                                                                ); 		
                                                                
                                                        <?php echo '</script'; ?>
>       
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Docente</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIDocenteAnterior" name="OBLIDocenteAnterior" value="" onkeypress="return Tabula(this, event, 0)" size="65">
													
													</td>
													<td class="tabla-alycar-label"  style="width:14% ">Registo Mineduc</td>
													<td class="tabla-alycar-texto" >
                                            			<input type="text" id="OBLIRegistroDocenteAnterior" name="OBLIRegistroDocenteAnterior" value="" onkeypress="return Tabula(this, event, 0)" size="25">
													
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Fonoaudiloga</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIFonoaudilogaAnterior" name="OBLIFonoaudilogaAnterior" value="" onkeypress="return Tabula(this, event, 0)" size="65">
													
													</td>
													<td class="tabla-alycar-label" >Registro Mineduc</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIRegistroFonoaudiologaAnterior" name="OBLIRegistroFonoaudiologaAnterior" value="" onkeypress="return Tabula(this, event, 0)" size="25">
													
													</td>
												</tr>
											</table>
										  </div>
										  <h3>Antecedentes Fonoaudiológicos</h3>
										  <div>
										    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr>
											   		<td class="tabla-alycar-label" >Diagnostico</td>
													<td class="tabla-alycar-texto" colspan="3">
		                                            	<select id="OBLIDiagnosticoTEL" name="OBLIDiagnosticoTEL" >
		                                            		<option >Elija</option>
		                                            		<option value="1">TEL mixto</option>
		                                            		<option value="2">TEL expresivo</option>
		                                            		<option value="3">En observación</option>
		                                            	</select>
													</td>
											   	</tr>
												<tr>
													<td class="tabla-alycar-label" >Fonoaudiologa</td>
													<td class="tabla-alycar-texto">
                                            			<select id="OBLIFonoaudiologa" name="OBLIFonoaudiologa" onkeypress="return Tabula(this, event, 0)" onchange="xajax_TraeValorRM(xajax.getFormValues('Form1'))">
		                                            	</select>
													</td>
													<td class="tabla-alycar-label"  style="width:14% ">Registro Mineduc</td>
													<td class="tabla-alycar-texto">
														<input type="text" name="registro_mineduc" id="registro_mineduc" size="25"/>
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Cambio Diagnostico</td>
													<td class="tabla-alycar-texto">
                                            			<select id="OBLICambioDiagnostico" name="OBLICambioDiagnostico" onkeypress="return Tabula(this, event, 0)" >
                                            				<option value="">Elija</option>
                                            				<option value="1">SI</option>
                                            				<option value="2">NO</option>
                                            				<option value="3">No Aplica</option>
		                                            	</select>
													</td>
													<td class="tabla-alycar-label"  style="width:14% ">Descripción Diagnostico</td>
													<td class="tabla-alycar-texto">
														<input type="text" name="OBLIDescripcionDiagnostico" id="OBLIDescripcionDiagnostico" size="25"/>
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Fecha Evaluaci&oacute;n</td>
													<td class="tabla-alycar-texto" >
                                            			<input type="text" id="OBLIFechaEvaluacionFonoaudiologa" name="OBLIFechaEvaluacionFonoaudiologa" value="" onkeypress="return Tabula(this, event, 0)" >
                                            			<?php echo '<script'; ?>
 type="text/javascript">
                                                                var input_3 = "OBLIFechaEvaluacionFonoaudiologa";
                                                                var button_3 = "cldFechaEvaluacionFonoaudiologa";
                                                                
                                                                $(function($) { 
                                                                        $('#'+input_3).mask("99/99/9999");
                                                                        Calendar.setup({inputField : input_3, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_3 ,
																					step: 1});
                                                                        }
                                                                ); 		
                                                                
                                            
                                                        <?php echo '</script'; ?>
>       
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Reevaluación</td>
													<td class="tabla-alycar-texto" >
                                            			<select id="OBLIReevaluacion" name="OBLIReevaluacion" onchange="ocultar_fecha_rev();">
                                            				<option value="">Elija</option>
                                            				<option value="1">SI</option>
                                            				<option value="2">NO</option>
                                            			</select>
													</td>
													<td class="tabla-alycar-label class_fecha_reev" style="visibility: hidden;">Fecha Reevaluación</td>
													<td class="tabla-alycar-texto class_fecha_reev" style="visibility: hidden;">
                                            			<input type="text" id="OBLIFechaReevaluacion" name="OBLIFechaReevaluacion" value="" onkeypress="return Tabula(this, event, 0)" >
                                            			<?php echo '<script'; ?>
 type="text/javascript">
                                                                var input_fr = "OBLIFechaReevaluacion";
                                                                var button_fr = "cldFechaReevaluacion";
                                                                
                                                                $(function($) { 
                                                                        $('#'+input_fr ).mask("99/99/9999");
                                                                        Calendar.setup({inputField : input_fr , 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_fr  ,
																					step: 1});
                                                                        }
                                                                ); 		
                                                                
                                            
                                                        <?php echo '</script'; ?>
>       
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Alta Fonoaudiológica</td>
													<td class="tabla-alycar-texto" >
                                            			<select id="OBLIAltaFonoaudiologica" name="OBLIAltaFonoaudiologica">
                                            				<option value="">Elija</option>
                                            				<option value="1">SI</option>
                                            				<option value="2">NO</option>
                                            			</select>
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label " >Descripción Alta</td>
													<td class="tabla-alycar-texto " >
                                            			<textarea id="OBLIDescripcionAlta" name="OBLIDescripcionAlta" rows="5" cols="50"></textarea>
                                            			   
													</td>
												</tr>
											</table>
										  </div>
										  <h3>Antecedentes de Salud</h3>
										  <div>
										    <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 
										        100%">
											   	<tr>
													<td class="tabla-alycar-label"  style="width:14.5% ">Pediatra</td>
													<td class="tabla-alycar-texto" style="width:36% ">
                                            			<input type="checkbox" value="1" id="OBLIChkPediatra" name="OBLIChkPediatra" onkeypress="return Tabula(this, event, 0)">
		
                                            			<input type="text" id="OBLIPediatra" name="OBLIPediatra" value="" onkeypress="return Tabula(this, event, 0)" size="60">
													
													</td>
													<td class="tabla-alycar-label"  style="width:14% " >Registo Pediatra</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIRegistroPediatra" name="OBLIRegistroPediatra" value="" onkeypress="return Tabula(this, event, 0)" size="25">
													
													</td>
												</tr>
												<tr>
													<td class="tabla-alycar-label" >Neurólogo</td>
													<td class="tabla-alycar-texto">
                                            			<input type="checkbox" value="1" id="OBLIChkNeurologo" name="OBLIChkNeurologo" onkeypress="return Tabula(this, event, 0)">
														<input type="text" id="OBLINeurologoAlumno" name="OBLINeurologoAlumno" value="" onkeypress="return Tabula(this, event, 0)" size="60">
													
													</td>
													<td class="tabla-alycar-label" >Registro Neurólogo</td>
													<td class="tabla-alycar-texto">
                                            			<input type="text" id="OBLIRegistroNeurologo" name="OBLIRegistroNeurologo" value="" onkeypress="return Tabula(this, event, 0)" size="25">
													
													</td>
												</tr>
											   		<td class="tabla-alycar-label" >Observación</td>
													<td class="tabla-alycar-texto" colspan="3">
                                            			<textarea id="OBLIObservacionSalud" name="OBLIObservacionSalud" rows="5" cols="50"></textarea>
													
													</td>
												</tr>
											   	<tr align="left">
												  <td class="tabla-alycar-label" >Previsi&oacute;n</td>
													<td class="tabla-alycar-texto">
		                                            	<select id="OBLICodigoIsapre" name="OBLICodigoIsapre" onkeypress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoIsapre','alumnos');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoIsapre')">
		                                            														</select>
															
													</td>
												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Enfermedad Cronica</td>
													<td class="tabla-alycar-texto" >
														<input type="checkbox" value="1" id="OBLIEnfermedadCronica" name="OBLIEnfermedadCronica" onkeypress="return Tabula(this, event, 0)">
		
														<input type="text" id="OBLITextEnfermedadCronica" name="OBLITextEnfermedadCronica" onkeypress="return Tabula(this, event, 0)" size="60">
		                                                	
													</td>

												</tr>
												<tr align="left">
													<td class="tabla-alycar-label" >Problema Dental </td>
													<td class="tabla-alycar-texto" >
														<input type="checkbox" value="1" id="OBLIProblemaDental" name="OBLIProblemaDental" onkeypress="return Tabula(this, event, 0)"value="1">
		
														<input type="text" id="OBLITextProblemaDental" name="OBLITextProblemaDental" onkeypress="return Tabula(this, event, 0)" size="60">
		                                                	
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
												<tr align="left">
													<td class="tabla-alycar-label" >Otros</td>
													<td class="tabla-alycar-texto">
		                                            	<input type="text" id="OBLIAntecedentesSocioeconomicoOtro" name="OBLIAntecedentesSocioeconomicoOtro" onkeypress="return Tabula(this, event, 0)" size="50">
		                                            </td>
												</tr>

											</table>
										  </div>
										</div>	
                                	</td>
                                </tr>

								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<?php if (($_smarty_tpl->tpl_vars['readonly']->value == '1')) {?>
                    <?php } else { ?>
                    <a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'))" id="btnGuardar" name="btnGuardar">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										<?php }?>
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
</HTML><?php }
}
