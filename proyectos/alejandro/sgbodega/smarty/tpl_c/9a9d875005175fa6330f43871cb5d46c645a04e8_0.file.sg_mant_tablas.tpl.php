<?php
/* Smarty version 3.1.33, created on 2019-12-17 19:24:16
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_mant_tablas.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5df95590cffcb5_46680074',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a9d875005175fa6330f43871cb5d46c645a04e8' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_mant_tablas.tpl',
      1 => 1576621254,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df95590cffcb5_46680074 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=utf8">
		
		<!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/common.js"><?php echo '</script'; ?>
>
			<?php if ((($_smarty_tpl->tpl_vars['TABLA']->value == 'declaracion_accidente') || ($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes') || ($_smarty_tpl->tpl_vars['TABLA']->value == 'BitacorasAcademicas'))) {?>
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal.js"><?php echo '</script'; ?>
>
			
			<?php } else { ?>                               
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal_1.js"><?php echo '</script'; ?>
>
			<?php }?>
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
 src="//code.jquery.com/jquery.min.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"><?php echo '</script'; ?>
>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"><?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 src="../includes_js/jquery.uploadify.min.js" type="text/javascript"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="../includes_js/jquery.Rut.js" type="text/javascript"><?php echo '</script'; ?>
>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadify.css">
			<link rel="stylesheet" type="text/css" href="../estilos/jquery.datetimepicker.min.css">
			
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery-te-1.4.0.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.datetimepicker.full.js"><?php echo '</script'; ?>
>
			<LINK href="../includes_js/jquery-te-1.4.0.css" type="text/css" rel="stylesheet"></LINK>               
            

			
			<?php echo '<script'; ?>
 type="text/javascript">
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

			$(document).ready(function(){
				xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Postulantes');
				xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion')
				$('#rut_postulante').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.Form1.submit();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_postulante").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		document.getElementById("OBLINumeroRutAlumno").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$('#rut_profesor').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.getElementById('rut_profesor').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_profesor").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		$.ajax({
						  url: "busquedas/busqueda_existeRut_profesor.php?q="+unidades[0]+unidades[1]+unidades[2],
							})
	    				.done(function( data ) {
							if (data=='Error'){
								alert("Rut Existente");
								document.getElementById('rut_profesor').focus();
								}
							else{
								document.getElementById("OBLINumeroRutProfesor").value = unidades[0]+unidades[1]+unidades[2];
				  				}
							});
				  		}
				});
				$('#rut_testigo1').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.getElementById('rut_testigo1').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo1").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		document.getElementById("OBLINumeroRutTestigo1").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$('#rut_testigo2').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.getElementById('rut_testigo2').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo2").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		document.getElementById("OBLINumeroRutTestigo2").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$('#rut_testigo2').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.getElementById('rut_testigo2').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo2").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		document.getElementById("OBLINumeroRutTestigo2").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
			});

            <?php echo '</script'; ?>
>                        
            
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Postulantes');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion')" style="background:#ffffff;"> 
					
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
											&nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['TITULO_TABLA']->value;?>
 <label id="alumno" name="alumno"></label>
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>

							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                <?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'BitacorasAcademicas' || $_smarty_tpl->tpl_vars['TABLA']->value == 'Entrevistas')) {?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                           			<a href="#" onclick="location.href='sg_mant_alumnos.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_notas.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/promedio.png' title='Notas' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_HojaVida.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Asistencia.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/fin_comp/bitacora.png' title='Asistencia' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Apoderado.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/ficha-apoderado.png' title='Apoderados' width="32"/>
											</a>
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=BitacorasAcademicas&rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'" title="Bit&aacute;cora Acad&eacute;mica" >
												<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora Acad&eacute;mica"  width="32" id="imagen_bitacora"  />
											</a>															
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=Entrevistas&rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'" title="Departamento Psicolog&iacute;a"  >
												<img src='../images/basicos/ficha-psicolgo.png' title="Departamento Psicolog&iacute;a"  width="32" id="imagen_bitacora"  />
											</a>															
                                    	</td>
                                    </tr>
                                <?php }?>
                                <?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Profesores')) {?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="xajax_CargaListado_Profesores_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" >
												<img src='../images/fin_comp/bitacora.png' title='Certificados / Capacitaciones' width="32"/>
											</a>
										</td>
                                    </tr>
                                <?php }?>
								<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Matriculas')) {?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-label" style="width: 30%">
											Matriculados / Retirados
											
                                    	</td>
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<select id="matri_retri" name="matri_retri"  onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'matri_retri','<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
');">
												<option value="0">Todos</option>
												<option value="1">Matriculados</option>
												<option value="2">Retirados</option>
											</select>
										</td>
                                    </tr>
                                <?php }?>
								<?php if ((($_smarty_tpl->tpl_vars['TABLA']->value == 'HojasDeVidaProfesores') && ($_smarty_tpl->tpl_vars['rut_trab']->value > 0))) {?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut=<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
										</td>
                                    </tr>
                                <?php }?>
								
								<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes')) {?>
                                <tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Periodo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<div style="width:33%; float: left;">
											<select id="OBLIPeriodoPostulacion" name="OBLIPeriodoPostulacion" onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Postulantes');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion');">
											</select>
										</div>
										<div style="width: 60%; float: left; display: none;" id="estado_oculto">
											Estado :
											<select id="OBLIAutorizado" name="OBLIAutorizado" >
											</select>
										</div>
									</td>
								</tr>
								<?php }?>
 								<!---<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">C&oacute;digo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">-->
										<INPUT type="hidden" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<!--<label class="comentario">Se Asigna Autom&aacute;ticamente</label>
									</td>
								</tr>
								-->
								<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'trabajadores_tienen_cargas')) {?>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Trabajador</td>
									<td class="tabla-alycar-texto" style="width: 70%"><?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
<input type="hidden" id="OBLIrut_papa" name="OBLIrut_papa" value="<?php echo $_smarty_tpl->tpl_vars['rut_trab']->value;?>
"/></td>
								</tr>
                                <?php }?>
                                
								<?php
$__section_campos_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrCampos']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_campos_0_total = $__section_campos_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_campos'] = new Smarty_Variable(array());
if ($__section_campos_0_total !== 0) {
for ($__section_campos_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] = 0; $__section_campos_0_iteration <= $__section_campos_0_total; $__section_campos_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']++){
?>
									
									<?php if (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] != '')) {?>
									<?php if ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'PeriodoPostulacion') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes'))) {?>
												
									<?php } else { ?>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%"><?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'];?>
 
	                                            <?php if ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'OPC') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Fecha Ingreso Nota Prueba') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Fecha Real Prueba') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Observacion') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Insuficiente') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Suficiente') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Bueno') || ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Muy Bueno'))) {?>
	                                            <?php } else { ?>
													<label class="requerido"> * </label>
												<?php }?>
											</td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<?php if ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'AnoAcademico') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Pruebas'))) {?>
													<input type="hidden" name="OBLIAnoAcademico" id="OBLIAnoAcademico" value="<?php echo $_smarty_tpl->tpl_vars['anio_vigente']->value;?>
"/> 
													<?php echo $_smarty_tpl->tpl_vars['anio_vigente']->value;?>

												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'DescripcionPrueba') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Pruebas'))) {?>
													<input type="text" name="OBLIDescripcionPrueba" id="OBLIDescripcionPrueba" size="50" maxlength="50" value=""/> 
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'Semestre') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Pruebas'))) {?>
													<select id="OBLISemestre" name="OBLISemestre" ></select>
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'CodigoCurso') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Pruebas'))) {?>
													<select id="OBLICodigoCurso" name="OBLICodigoCurso" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoCurso','Pruebas');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso')"></select>
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'Curso') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'BitacorasAcademicas'))) {?>
													<input type="hidden" name="OBLICurso" id="OBLICurso" /> 
													<input type="text" name="nombre_curso" id="nombre_curso" maxLength="100" size="50" readonly="readonly" />
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'ProfesorJefe') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'BitacorasAcademicas'))) {?>
													<input type="hidden" name="OBLIProfesorJefe" id="OBLIProfesorJefe" /> 
													<input type="text" name="nombre_profesor" id="nombre_profesor" maxLength="100" size="50" readonly="readonly" />
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutAlumno') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes'))) {?>
													<input type="hidden" name="OBLINumeroRutAlumno" id="OBLINumeroRutAlumno" size="50" maxlength="50" value="" /> 
													<input type="text" name="rut_postulante" id="rut_postulante" onblur="validaRut(this.value)" />
												<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutTestigo1') {?>
													<input type="hidden" name="OBLINumeroRutTestigo1" id="OBLINumeroRutTestigo1" /> 
													<input type="text" name="rut_testigo1" id="rut_testigo1" onblur="validaRut(this.value)" />
												<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutTestigo2') {?>
													<input type="hidden" name="OBLINumeroRutTestigo2" id="OBLINumeroRutTestigo2" /> 
													<input type="text" name="rut_testigo2" id="rut_testigo2" onblur="validaRut(this.value)" />
												<?php } elseif ((($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutProfesor') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Profesores'))) {?>
													<input type="hidden" name="OBLINumeroRutProfesor" id="OBLINumeroRutProfesor" /> 
													<input type="text" name="rut_profesor" id="rut_profesor" onblur="validaRut(this.value)" />
												<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'destinatarios') {?>
													<?php if ($_smarty_tpl->tpl_vars['TABLA']->value == 'correos_apoderados') {?>
														<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" <?php if ($_smarty_tpl->tpl_vars['email']->value != '') {?> value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"<?php }?>/>
														<?php if ($_smarty_tpl->tpl_vars['email']->value != '') {?>

														<?php } else { ?>
														<select id="correos_apoderados_cursos" name="correos_apoderados_cursos" class="boton" onchange="xajax_ApoderadosCurso(xajax.getFormValues('Form1'))" >
														</select>
														<input type="button" class="boton" name="bntLimpiar" id="btnLimpiar" onclick="xajax_ApoderadosCursoEliminar(xajax.getFormValues('Form1'))" value="Limpiar Destinatarios">
														<?php }?>
														<br />
	                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" <?php if ($_smarty_tpl->tpl_vars['email']->value != '') {?> value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
;"<?php }?>/>
	                                                    <textarea id="VER<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="VER<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" rows="5" cols="100"><?php if ($_smarty_tpl->tpl_vars['email']->value != '') {
echo $_smarty_tpl->tpl_vars['email']->value;
}?></textarea>
	                                                    <?php echo '<script'; ?>
 type="text/javascript">
														var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
														var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
														var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
	                                                    
															$(document).ready(function() {
																$("#OBLIcuerpo").jqte();
																$("#"+combo).autocomplete({
																	source : 'busquedas/busqueda_'+obli+'_apoderados.php',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		rut = rut +';';
																		rut = rut.replace(/(^\s*)|(\s*$)/g,""); 
																		$("#"+obli).append(rut);
																		//$("#"+VER).append(rut);
																		}
																	});
																});
	                                                    <?php echo '</script'; ?>
>
														
													<?php } else { ?>
														<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
														<input type="button" class="boton" name="incluir" id="incluir" value="Incluir Todos"
															onclick="xajax_Todos(xajax.getFormValues('Form1'))"></input>
														<input type="button" class="boton" name="quitar" id="quitar" value="Quitar Todos"
															onclick="xajax_Quitar(xajax.getFormValues('Form1'))"></input>
														<br />
	                                                    <textarea id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" rows="5" cols="100"></textarea>
	                                                    <?php echo '<script'; ?>
 type="text/javascript">
														var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
														var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
														var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
	                                                    
															$(document).ready(function() {
																$("#OBLIcuerpo").jqte();
																$("#"+combo).autocomplete({
																	source : 'busquedas/busqueda_'+obli+'.php',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		rut = rut +';';
																		$("#"+obli).append(rut);
																		//$("#"+VER).append(rut);
																		}
																	});
																});
	                                                    <?php echo '</script'; ?>
>
														
													<?php }?>
                                            	<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'SELECT')) {?>
													<SELECT id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
','<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
')" > 
                                                    </SELECT>
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'FECHA')) {?>
													<?php if ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'FechaNacimientoProfesor') {?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input_1 = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button_1 = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input_1, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_1 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_1).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
													<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'IngresoFuncionario') {?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input_2 = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button_2 = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input_2, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_2 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_2).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
													<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'FechaVencimientoCertAntecende') {?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input_3 = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button_3 = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input_3, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_3 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_3).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
													<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'FechaNacimiento') {?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input_4 = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button_4 = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input_4, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_4 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_4).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
													<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'fechaAgenda') {?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" 
														onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
','AgendaMatricula');"
														>
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99/99/9999");
	                                                                    }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
													<?php } else { ?>
														<INPUT type="text"  id="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input = "FCH<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                
	                                                                var button = "cld<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>                                                                               
	                                                        
	                                            	<?php }?>
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'HORA')) {?>
													<?php if ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'horaAgenda') {?>
															<INPUT type="text"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='<?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input = "OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                $(document).ready(function() {
	                                                                    $('#'+input).mask("99:99");
																		$("#"+input).blur( 	function(){
																			var hora = $('#'+input).val();
		                                                                    var fecha = $('#FCHfechaAgenda').val();
		                                                                    $.ajax({
																				url: "busquedas/buscar_fecha_tomada_agenda_matricula.php?fecha="+fecha+"&hora="+hora, 
																				success: function(data){
																					if (data=='1'){
																			        	}
																			        else{
																			        	alert("Fecha y Hora no disponible");
																			        	document.Form1.submit();
																			        	}
																			    	}
																				});
		                                                                    });
	                                                                    });
	                                                        <?php echo '</script'; ?>
>
	                                                        
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'HoraInicio') {?>
	                                                	<INPUT type="text"  id="OBLIHoraInicio" name="OBLIHoraInicio" class="OBLI-fecha" value='<?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
                                                                $(function($) { 
                                                                        $('#OBLIHoraInicio').mask("99:99:99");
                                                                        }
                                                                ); 		
	                                                        <?php echo '</script'; ?>
>
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'HoraFin') {?>
	                                                	<INPUT type="text"  id="OBLIHoraFin" name="OBLIHoraFin" class="OBLI-fecha" value='<?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
                                                                $(function($) { 
                                                                        $('#OBLIHoraFin').mask("99:99:99");
                                                                        }
                                                                ); 		
	                                                        <?php echo '</script'; ?>
>
	                                                <?php } else { ?>
	                                                	<INPUT type="text"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" class="OBLI-fecha" value='<?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                                var input = "OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
	                                                                
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99:99:99");
	                                                                        }
	                                                                ); 		
	                                                        <?php echo '</script'; ?>
>
	                                                        
	                                                <?php }?>
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'FECHATIEMPO')) {?>
													<INPUT type="text"  id="FT<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="FT<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
                                                        <?php echo '<script'; ?>
 type="text/javascript">
	                                                        var input_ft_1 = "FT<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
                                                        	
                                                        	jQuery.datetimepicker.setLocale('es');
                                                        	jQuery('#'+input_ft_1).datetimepicker({
                                                        		i18n:{
																	  de:{
																	   months:[
																	    'Enero','Febrero','Marzo','Abril',
																	    'Mayp','Junio','Julio','Agosto',
																	    'Septiembre','Octubre','Noviembre','Diciembre',
																	   ],
																	   dayOfWeek:[
																	    "Lu", "Ma", "Mie", "Ju", 
																	    "Vi", "Sa", "Do",
																	   ]
																	  }
																	 },
                                                        		format:'d/m/Y H:i:s'
                                                        	});
                                                        <?php echo '</script'; ?>
>                                                              
                                                        
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'PASSWORD')) {?>
													<INPUT type="password"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'USUARIO')) {?>
													<INPUT type="text"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'NUMERO')) {?>
													<?php if (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Coeficiente Prueba')) {?>
													<INPUT type="text"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													<?php } else { ?>
													<INPUT type="text"  id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													<?php }?>
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'NOTA')) {?>
													<?php if (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['titulo'] == 'Coeficiente Prueba')) {?>
														<INPUT type="text"  id="NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	<?php } else { ?>
	                                            		<INPUT type="text"  id="NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'LenguajeObtiene') {?>
													<?php echo '<script'; ?>
 type="text/javascript">
														var input_1 = "NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
														
	                                                        $(function() {
	                                                            $('#'+input_1).on('blur',function(){
	                                                               	var nota  = $('#'+input_1).val();
	                                                               	if (nota>0){
		                                                            	if ((nota>='1')&&(nota<='7')){

		                                                            	}
		                                                            	else{
		                                                            		alert("Ingrese nota valida");
		                                                            		document.getElementById(input_1).value="";
		                                                            		document.getElementById(input_1).focus();
		                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    
	                                                <?php echo '</script'; ?>
> 
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'MatematicaObtiene') {?>
													<?php echo '<script'; ?>
 type="text/javascript">
														var input_2 = "NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
														
	                                                        $(function() {
	                                                            $('#'+input_2).on('blur',function(){
	                                                               	var nota  = $('#'+input_2).val();
	                                                            	if (nota>0){
			                                                            if ((nota>='1')&&(nota<='7')){

		                                                            	}
		                                                            	else{
		                                                            		alert("Ingrese nota valida");
		                                                            		document.getElementById(input_2).value="";
		                                                            		document.getElementById(input_2).focus();
		                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    
													<?php echo '</script'; ?>
> 
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'LenguajePresenta') {?>
													<?php echo '<script'; ?>
 type="text/javascript">
														var input_3 = "NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
														
	                                                        $(function() {
	                                                            $('#'+input_3).on('blur',function(){
	                                                               	var nota  = $('#'+input_3).val();
	                                                            	if (nota>0){
		                                                            if ((nota>='1')&&(nota<='7')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_3).value="";
	                                                            		document.getElementById(input_3).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    
													<?php echo '</script'; ?>
> 
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'MatematicaPresenta') {?>
													<?php echo '<script'; ?>
 type="text/javascript">
														var input_4 = "NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
														
	                                                        $(function() {
	                                                            $('#'+input_4).on('blur',function(){
	                                                               	var nota  = $('#'+input_4).val();
	                                                            	if (nota>0){
		                                                            if ((nota>='1')&&(nota<='7')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_4).value="";
	                                                            		document.getElementById(input_4).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    
													<?php echo '</script'; ?>
> 
	                                                <?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'UltimoPromedio') {?>
													<?php echo '<script'; ?>
 type="text/javascript">
														var input_5 = "NOTA<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
														
	                                                        $(function() {
	                                                            $('#'+input_5).on('blur',function(){
	                                                               	var nota  = $('#'+input_5).val();
	                                                            	if (nota>0){
		                                                            if ((nota>='1')&&(nota<='7')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_5).value="";
	                                                            		document.getElementById(input_5).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    
													<?php echo '</script'; ?>
> 
	                                                <?php }?>
													    
												<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'RUT')) {?>
													<INPUT type="text" class="rut" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='' />
                                                <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'OPC')) {?>														<INPUT type="text" class="rut" id="<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='.' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'CHECK')) {?>
													<INPUT type="checkbox" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="1"/>
                                                <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'AREA')) {?>
													<textarea id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" rows="3" cols="115" <?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Entrevistas')) {?> maxlength="325" <?php }?> ><?php if ($_smarty_tpl->tpl_vars['email']->value != '') {?>Sr(a). <?php echo $_smarty_tpl->tpl_vars['nombre_apoderado']->value;?>
, <br/> Apoderado de <?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
<br>del curso <?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
<br><br><br>Atentamente, <br>Inspectoria General<br>Colegio Nuevo Milenio<?php }?></textarea>
                        <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'FOTO')) {?>
													<?php echo '<script'; ?>
 type="text/javascript">
													var input_foto_1 = "OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
													
                                                        $(function() {
                                                            $('#file-name').uploadify({
                                                                'swf'      			: 'uploadify.swf',
                                                                'uploader' 			: 'uploadify.php',
																'buttonText' 		: 'Subir Foto',
																'onUploadSuccess' 	: function(file, data, response){
														            document.getElementById('img_'+input_foto_1).src = 'uploads/'+file.name;
																	document.getElementById(input_foto_1).value= 'uploads/'+file.name;
        														}
                                                            });
                                                        });
                                                    <?php echo '</script'; ?>
> 
                                                    
                                                    <div id="queue"></div>
                                                    <input id="file-name" name="file-name" type="file" />
                                                    <img src="#" id="img_OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"  name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value=""  />
		                    <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'ARCHIVO')) {?>
								<?php echo '<script'; ?>
 type="text/javascript">
								var input_foto_1 = "OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
";
								
                                    $(function() {
                                        $('#file-name').uploadify({
                                            'swf'      			: 'uploadify.swf',
                                            'uploader' 			: 'uploadify.php',
											'buttonText' 		: 'Subir Archivo',
											'onUploadSuccess' 	: function(file, data, response){
																document.getElementById(input_foto_1).value= 'uploads/fotos_alumnos/'+file.name;
											}
                                        });
                                    });
	                        	<?php echo '</script'; ?>
> 
	                        	
	                        <input id="file-name" name="file-name" type="file" />
	                        <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"  name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value=""  />
                        <?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['objeto'] == 'BUSCA')) {?>
                        		<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes')) {?>
                        			<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
                                    <?php echo '<script'; ?>
 type="text/javascript">
															var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
		                                                    
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : 'busquedas/busqueda_'+obli+'_postulantes.php',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues('Form1'),obli,tabla);
																			}
																		});
																	});
		                                                    <?php echo '</script'; ?>
>
															
														<?php } elseif (($_smarty_tpl->tpl_vars['TABLA']->value == 'HojasDeVida')) {?>
		                                        			<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                    <?php echo '<script'; ?>
 type="text/javascript">
															var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
		                                                    
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : 'busquedas/busqueda_'+obli+'.php',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues('Form1'),obli,tabla);
																			xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso'); 
																			}
																		});
																	});
		                                                    <?php echo '</script'; ?>
>
															
														<?php } elseif (($_smarty_tpl->tpl_vars['TABLA']->value == 'AgendaMatricula')) {?>
		                                        			<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                        			<br>
		                                                    <input type="text" id="apoderado_nombre" name="apoderado_nombre" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" />
		                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                    <?php echo '<script'; ?>
 type="text/javascript">
															var	obli 	= 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var combo 	= 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var apo 	= 'apoderado_nombre';
															var tabla 	= '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
		                                                    
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : 'busquedas/busqueda_'+obli+'.php',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			var periodo = '2018';
																			if (periodo=='Elija'){
																				alert("Elija un Periodo");
																				}
																			else{
																				$.ajax({
																					url: "busquedas/buscar_matricula_condicionada.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																					success: function(data){
																				        if (data=='1'){
																							$.ajax({
																								url: "busquedas/buscar_cuotas_impagas.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																								success: function(data){
																							        if (data=='1'){
																							        	$.ajax({
																											url: "busquedas/buscar_agenda_matricula.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																											success: function(data){
																										        if (data=='1'){
																										        	$.ajax({
																														url: "busquedas/buscar_apoderado_alumno.php?NumeroRutAlumno="+rut+"&periodo="+periodo,
																														success: function(data){
																															document.getElementById(apo).value = data;
																															}
																														});
																										        	}
																										        else{
																										        	alert("Alumno con fecha tomada.");
																										        	document.Form1.submit();
																										        	}
																										    	}
																											});
																							        	}
																							        else{
																							        	alert("Alumno con deuda.");
																							        	//document.Form1.submit();
																							        	}
																							    	}
																								});
																				        	}
																				        else{
																				        	alert("Alumno con matricula condicionada.");
																				        	document.Form1.submit();
																				        	}
																				    	}
																					});																				
																				}
																			}
																		});
																	});
		                                                    <?php echo '</script'; ?>
>
															
														<?php } elseif (($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutAlumno') && ($_smarty_tpl->tpl_vars['TABLA']->value == 'Eximisiones')) {?>
																<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                        <?php echo '<script'; ?>
 type="text/javascript">
																var	obli_2 = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var combo_2 = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
			                                                    
																	$(document).ready(function() {
																		$("#"+combo_2).autocomplete({
																			source : 'busquedas/busqueda_alumno.php',
																			select: function( event, ui ) {
																				var rut_2 = ui.item.id;
																				document.getElementById(obli_2).value = rut_2;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    <?php echo '</script'; ?>
>
																
														<?php } elseif (($_smarty_tpl->tpl_vars['TABLA']->value == 'Profesores')) {?>
		                                        			<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                    <?php echo '<script'; ?>
 type="text/javascript">
															var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
		                                                    
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : 'busquedas/busqueda_'+obli+'.php',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			var ncorr = ui.item.ncorr;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues('Form1'),obli,tabla);
																			xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso'); 
																			xajax_TraeValor(xajax.getFormValues('Form1'),ncorr); 
																			}
																		});
																	});
		                                                    <?php echo '</script'; ?>
>
															
														<?php } elseif ($_smarty_tpl->tpl_vars['TABLA']->value == 'declaracion_accidente') {?>
															<?php if ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutAlumno') {?>
																<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                        <?php echo '<script'; ?>
 type="text/javascript">
																var	obli_1 = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var combo_1 = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
			                                                    
																	$(document).ready(function() {
																		$("#"+combo_1).autocomplete({
																			source : 'busquedas/busqueda_'+obli_1+'.php',
																			select: function( event, ui ) {
																				var rut_1 = ui.item.id;
																				document.getElementById(obli_1).value = rut_1;
																				//$("#"+VER).append(rut);
																				}
			                                                    			});
																		});
																<?php echo '</script'; ?>
>
																
															<?php } elseif ($_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'] == 'NumeroRutTestigo1') {?>
																<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                        <?php echo '<script'; ?>
 type="text/javascript">
																var	obli_2 = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var combo_2 = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
			                                                    
																	$(document).ready(function() {
																		$("#"+combo_2).autocomplete({
																			source : 'busquedas/busqueda_'+obli_2+'.php',
																			select: function( event, ui ) {
																				var rut_2 = ui.item.id;
																				document.getElementById(obli_2).value = rut_2;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    <?php echo '</script'; ?>
>
																
															<?php } else { ?>
																<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                        <?php echo '<script'; ?>
 type="text/javascript">
																var	obli_3 = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var combo_3 = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
																var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
			                                                    
																	$(document).ready(function() {
																		$("#"+combo_3).autocomplete({
																			source : 'busquedas/busqueda_'+obli_3+'.php',
																			select: function( event, ui ) {
																				var rut_3 = ui.item.id;
																				document.getElementById(obli_3).value = rut_3;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    <?php echo '</script'; ?>
>
																
															<?php }?>
																											
		                                        		<?php } else { ?>
															<input type="text" id="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
"/>
		                                                    <?php echo '<script'; ?>
 type="text/javascript">
															var	obli = 'OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var combo = 'BSC<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
';
															var tabla = '<?php echo $_smarty_tpl->tpl_vars['TABLA']->value;?>
';
		                                                    
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
															
														<?php }?>	
												<?php } else { ?>
													<INPUT type="text" id="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" name="OBLI<?php echo $_smarty_tpl->tpl_vars['arrCampos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_campos']->value['index'] : null)]['campo'];?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												
                                                
												<?php }?>	
											</td>
										</tr>
										<?php }?>
									<?php }?>
								<?php
}
}
?>
	                            						
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	<?php if (($_smarty_tpl->tpl_vars['readonly']->value == '1')) {?>
                                        <?php } else { ?>
                                        <a href="#" onclick="javascript: ValidaFormularioMantenedor();" id="btnGuardar" name="btnGuardar">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										<?php }?>
										<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Profesores')) {?>
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
											</a>										
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>										
										<?php } elseif (($_smarty_tpl->tpl_vars['TABLA']->value == 'HojasDeVidaProfesores')) {?>
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=HojasDeVidaProfesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>	
										<?php } else { ?>
											<?php if (($_smarty_tpl->tpl_vars['readonly']->value == '1')) {?>
	                                        <?php } else { ?>
											<a href="#" onclick="javascript: document.Form1.submit();">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>
											<?php }?>
										<?php }?>
										<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Cursos')) {?>
                               	            <a href="#" style="cursor: hand;"><img src="../images/gest_fin/respaldos.png" border=0 title="Malla Curricular" onclick="xajax_CursoMallaCurricular(xajax.getFormValues('Form1'))" width="32"></a>
                                        <?php }?>
										<?php if (($_smarty_tpl->tpl_vars['TABLA']->value == 'Postulantes')) {?>
                                        <a href="#" onclick="xajax_ApoderadoPostulante(xajax.getFormValues('Form1'))">
											<img src='../images/gest_fin/proveedores.png' title='Asociar Apoderado' width="32"/>
										</a>
                                        <?php }?>
										
										<label class="requerido"> (*) </label>Informaci&oacute;n Obligatoria			
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
