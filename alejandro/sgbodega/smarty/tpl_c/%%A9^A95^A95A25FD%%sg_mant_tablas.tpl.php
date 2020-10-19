<?php /* Smarty version 2.6.18, created on 2019-06-26 20:36:55
         compiled from sg_mant_tablas.tpl */ ?>
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
			<?php if (( ( $this->_tpl_vars['TABLA'] == 'declaracion_accidente' ) || ( $this->_tpl_vars['TABLA'] == 'Postulantes' ) )): ?>
			<script type="text/javascript" src="submodal/subModal.js"></script>
			
			<?php else: ?>                               
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
			<?php endif; ?>
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
		

			<script src="//code.jquery.com/jquery.min.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
            <script src="../includes_js/jquery.uploadify.min.js" type="text/javascript"></script>
			<script src="../includes_js/jquery.Rut.js" type="text/javascript"></script>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadify.css">
			<link rel="stylesheet" type="text/css" href="../estilos/jquery.datetimepicker.min.css">
			
			<script type="text/javascript" src="../includes_js/jquery-te-1.4.0.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.datetimepicker.full.js"></script>
			<LINK href="../includes_js/jquery-te-1.4.0.css" type="text/css" rel="stylesheet"></LINK>               
            

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

			$(document).ready(function(){
				xajax_CargaListado(xajax.getFormValues(\'Form1\'),\'OBLIPeriodoPostulacion\',\'Postulantes\');
				xajax_CargaSelect_1(xajax.getFormValues(\'Form1\'),\'OBLIPeriodoPostulacion\')
				$(\'#rut_postulante\').Rut({
				  on_error: function(){ 
				  		alert(\'Rut incorrecto\'); 
				  		document.Form1.submit();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_postulante").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split(\'.\');
				  		document.getElementById("OBLINumeroRutAlumno").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$(\'#rut_profesor\').Rut({
				  on_error: function(){ 
				  		alert(\'Rut incorrecto\'); 
				  		document.getElementById(\'rut_profesor\').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_profesor").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split(\'.\');
				  		$.ajax({
						  url: "busquedas/busqueda_existeRut_profesor.php?q="+unidades[0]+unidades[1]+unidades[2],
							})
	    				.done(function( data ) {
							if (data==\'Error\'){
								alert("Rut Existente");
								document.getElementById(\'rut_profesor\').focus();
								}
							else{
								document.getElementById("OBLINumeroRutProfesor").value = unidades[0]+unidades[1]+unidades[2];
				  				}
							});
				  		}
				});
				$(\'#rut_testigo1\').Rut({
				  on_error: function(){ 
				  		alert(\'Rut incorrecto\'); 
				  		document.getElementById(\'rut_testigo1\').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo1").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split(\'.\');
				  		document.getElementById("OBLINumeroRutTestigo1").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$(\'#rut_testigo2\').Rut({
				  on_error: function(){ 
				  		alert(\'Rut incorrecto\'); 
				  		document.getElementById(\'rut_testigo2\').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo2").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split(\'.\');
				  		document.getElementById("OBLINumeroRutTestigo2").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
				$(\'#rut_testigo2\').Rut({
				  on_error: function(){ 
				  		alert(\'Rut incorrecto\'); 
				  		document.getElementById(\'rut_testigo2\').focus();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_testigo2").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split(\'.\');
				  		document.getElementById("OBLINumeroRutTestigo2").value = unidades[0]+unidades[1]+unidades[2];
				  		}
				});
			});

            </script>                        
            '; ?>

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
											&nbsp;&nbsp; <?php echo $this->_tpl_vars['TITULO_TABLA']; ?>
 <label id="alumno" name="alumno"></label>
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
                                <?php if (( $this->_tpl_vars['TABLA'] == 'BitacorasAcademicas' || $this->_tpl_vars['TABLA'] == 'Entrevistas' )): ?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                           			<a href="#" onclick="location.href='sg_mant_alumnos.php?rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_notas.php?rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'">
												<img src='../images/gest_esc/promedio.png' title='Notas' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_HojaVida.php?rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Asistencia.php?rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'">
												<img src='../images/fin_comp/bitacora.png' title='Asistencia' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Apoderado.php?rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'">
												<img src='../images/gest_esc/ficha-apoderado.png' title='Apoderados' width="32"/>
											</a>
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=BitacorasAcademicas&rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'" title="Bit&aacute;cora Acad&eacute;mica" >
												<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora Acad&eacute;mica"  width="32" id="imagen_bitacora"  />
											</a>															
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=Entrevistas&rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
&readonly=<?php echo $this->_tpl_vars['readonly']; ?>
'" title="Entrevistas y Seguimiento del Alumno" >
												<img src='../images/gest_fin/proveedores.png' title="Entrevistas y Seguimiento del Alumno"  width="32" id="imagen_bitacora"  />
											</a>															
                                    	</td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (( $this->_tpl_vars['TABLA'] == 'Profesores' )): ?>
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
                                <?php endif; ?>
								<?php if (( $this->_tpl_vars['TABLA'] == 'Matriculas' )): ?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-label" style="width: 30%">
											Matriculados / Retirados
											
                                    	</td>
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<select id="matri_retri" name="matri_retri"  onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'matri_retri','<?php echo $this->_tpl_vars['TABLA']; ?>
');">
												<option value="0">Todos</option>
												<option value="1">Matriculados</option>
												<option value="2">Retirados</option>
											</select>
										</td>
                                    </tr>
                                <?php endif; ?>
								<?php if (( ( $this->_tpl_vars['TABLA'] == 'HojasDeVidaProfesores' ) && ( $this->_tpl_vars['rut_trab'] > 0 ) )): ?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut=<?php echo $this->_tpl_vars['rut_trab']; ?>
'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
										</td>
                                    </tr>
                                <?php endif; ?>
								
								<?php if (( $this->_tpl_vars['TABLA'] == 'Postulantes' )): ?>
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
								<?php endif; ?>
 								<!---<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">C&oacute;digo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">-->
										<INPUT type="hidden" id="txtNcorr" name="txtNcorr" size="10" readonly>
										<input type="hidden" id="readonly" name="readonly" value="<?php echo $this->_tpl_vars['readonly']; ?>
"/>
										&nbsp;
										<!--<label class="comentario">Se Asigna Autom&aacute;ticamente</label>
									</td>
								</tr>
								-->
								<?php if (( $this->_tpl_vars['TABLA'] == trabajadores_tienen_cargas )): ?>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Trabajador</td>
									<td class="tabla-alycar-texto" style="width: 70%"><?php echo $this->_tpl_vars['rut']; ?>
<input type="hidden" id="OBLIrut_papa" name="OBLIrut_papa" value="<?php echo $this->_tpl_vars['rut_trab']; ?>
"/></td>
								</tr>
                                <?php endif; ?>
                                
								<?php unset($this->_sections['campos']);
$this->_sections['campos']['name'] = 'campos';
$this->_sections['campos']['loop'] = is_array($_loop=$this->_tpl_vars['arrCampos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['campos']['show'] = true;
$this->_sections['campos']['max'] = $this->_sections['campos']['loop'];
$this->_sections['campos']['step'] = 1;
$this->_sections['campos']['start'] = $this->_sections['campos']['step'] > 0 ? 0 : $this->_sections['campos']['loop']-1;
if ($this->_sections['campos']['show']) {
    $this->_sections['campos']['total'] = $this->_sections['campos']['loop'];
    if ($this->_sections['campos']['total'] == 0)
        $this->_sections['campos']['show'] = false;
} else
    $this->_sections['campos']['total'] = 0;
if ($this->_sections['campos']['show']):

            for ($this->_sections['campos']['index'] = $this->_sections['campos']['start'], $this->_sections['campos']['iteration'] = 1;
                 $this->_sections['campos']['iteration'] <= $this->_sections['campos']['total'];
                 $this->_sections['campos']['index'] += $this->_sections['campos']['step'], $this->_sections['campos']['iteration']++):
$this->_sections['campos']['rownum'] = $this->_sections['campos']['iteration'];
$this->_sections['campos']['index_prev'] = $this->_sections['campos']['index'] - $this->_sections['campos']['step'];
$this->_sections['campos']['index_next'] = $this->_sections['campos']['index'] + $this->_sections['campos']['step'];
$this->_sections['campos']['first']      = ($this->_sections['campos']['iteration'] == 1);
$this->_sections['campos']['last']       = ($this->_sections['campos']['iteration'] == $this->_sections['campos']['total']);
?>
									
									<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] != '' )): ?>
									<?php if (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'PeriodoPostulacion' ) && ( $this->_tpl_vars['TABLA'] == 'Postulantes' ) )): ?>
												
									<?php else: ?>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%"><?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo']; ?>
 
	                                            <?php if (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'OPC' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Fecha Ingreso Nota Prueba' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Fecha Real Prueba' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Observacion' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Insuficiente' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Suficiente' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Bueno' ) || ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Muy Bueno' ) )): ?>
	                                            <?php else: ?>
													<label class="requerido"> * </label>
												<?php endif; ?>
											</td>
											<td class="tabla-alycar-texto" style="width: 70%">
												<?php if (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'AnoAcademico' ) && ( $this->_tpl_vars['TABLA'] == 'Pruebas' ) )): ?>
													<input type="hidden" name="OBLIAnoAcademico" id="OBLIAnoAcademico" value="<?php echo $this->_tpl_vars['anio_vigente']; ?>
"/> 
													<?php echo $this->_tpl_vars['anio_vigente']; ?>

												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'DescripcionPrueba' ) && ( $this->_tpl_vars['TABLA'] == 'Pruebas' ) )): ?>
													<input type="text" name="OBLIDescripcionPrueba" id="OBLIDescripcionPrueba" size="50" maxlength="50" value=""/> 
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'Semestre' ) && ( $this->_tpl_vars['TABLA'] == 'Pruebas' ) )): ?>
													<select id="OBLISemestre" name="OBLISemestre" ></select>
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'CodigoCurso' ) && ( $this->_tpl_vars['TABLA'] == 'Pruebas' ) )): ?>
													<select id="OBLICodigoCurso" name="OBLICodigoCurso" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoCurso','Pruebas');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso')"></select>
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutAlumno' ) && ( $this->_tpl_vars['TABLA'] == 'Postulantes' ) )): ?>
													<input type="hidden" name="OBLINumeroRutAlumno" id="OBLINumeroRutAlumno" size="50" maxlength="50" value="" /> 
													<input type="text" name="rut_postulante" id="rut_postulante" onblur="validaRut(this.value)" />
												<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutTestigo1'): ?>
													<input type="hidden" name="OBLINumeroRutTestigo1" id="OBLINumeroRutTestigo1" /> 
													<input type="text" name="rut_testigo1" id="rut_testigo1" onblur="validaRut(this.value)" />
												<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutTestigo2'): ?>
													<input type="hidden" name="OBLINumeroRutTestigo2" id="OBLINumeroRutTestigo2" /> 
													<input type="text" name="rut_testigo2" id="rut_testigo2" onblur="validaRut(this.value)" />
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutApoderado' ) && ( $this->_tpl_vars['TABLA'] == 'BitacorasAcademicas' ) )): ?>
													<input type="hidden" name="OBLINumeroRutApoderado" id="OBLINumeroRutApoderado" /> 
													<input type="text" name="nombre_apoderado" id="nombre_apoderado"  size="50" maxlength="50" value="" readonly="readonly" />
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'Curso' ) && ( $this->_tpl_vars['TABLA'] == 'BitacorasAcademicas' ) )): ?>
													<input type="hidden" name="OBLICurso" id="OBLICurso" /> 
													<input type="text" name="nombre_curso" id="nombre_curso"  size="50" maxlength="50" value="" readonly="readonly" />
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'ProfesorJefe' ) && ( $this->_tpl_vars['TABLA'] == 'BitacorasAcademicas' ) )): ?>
													<input type="hidden" name="OBLIProfesorJefe" id="OBLIProfesorJefe" /> 
													<input type="text" name="nombre_profesor" id="nombre_profesor"  size="50" maxlength="50" value="" readonly="readonly" />
												<?php elseif (( ( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutProfesor' ) && ( $this->_tpl_vars['TABLA'] == 'Profesores' ) )): ?>
													<input type="hidden" name="OBLINumeroRutProfesor" id="OBLINumeroRutProfesor" /> 
													<input type="text" name="rut_profesor" id="rut_profesor" onblur="validaRut(this.value)" />
												<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'destinatarios'): ?>
													<?php if ($this->_tpl_vars['TABLA'] == 'correos_apoderados'): ?>
														<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" <?php if ($this->_tpl_vars['email'] != ''): ?> value="<?php echo $this->_tpl_vars['email']; ?>
"<?php endif; ?>/>
														<?php if ($this->_tpl_vars['email'] != ''): ?>

														<?php else: ?>
														<select id="correos_apoderados_cursos" name="correos_apoderados_cursos" class="boton" onchange="xajax_ApoderadosCurso(xajax.getFormValues('Form1'))" >
														</select>
														<input type="button" class="boton" name="bntLimpiar" id="btnLimpiar" onclick="xajax_ApoderadosCursoEliminar(xajax.getFormValues('Form1'))" value="Limpiar Destinatarios">
														<?php endif; ?>
														<br />
	                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" <?php if ($this->_tpl_vars['email'] != ''): ?> value="<?php echo $this->_tpl_vars['email']; ?>
;"<?php endif; ?>/>
	                                                    <textarea id="VER<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="VER<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" rows="5" cols="100"><?php if ($this->_tpl_vars['email'] != ''): ?><?php echo $this->_tpl_vars['email']; ?>
<?php endif; ?></textarea>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
	                                                    <?php echo '
															$(document).ready(function() {
																$("#OBLIcuerpo").jqte();
																$("#"+combo).autocomplete({
																	source : \'busquedas/busqueda_\'+obli+\'_apoderados.php\',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		rut = rut +\';\';
																		rut = rut.replace(/(^\\s*)|(\\s*$)/g,""); 
																		$("#"+obli).append(rut);
																		//$("#"+VER).append(rut);
																		}
																	});
																});
	                                                    </script>
														'; ?>

													<?php else: ?>
														<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
														<input type="button" class="boton" name="incluir" id="incluir" value="Incluir Todos"
															onclick="xajax_Todos(xajax.getFormValues('Form1'))"></input>
														<input type="button" class="boton" name="quitar" id="quitar" value="Quitar Todos"
															onclick="xajax_Quitar(xajax.getFormValues('Form1'))"></input>
														<br />
	                                                    <textarea id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" rows="5" cols="100"></textarea>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
	                                                    <?php echo '
															$(document).ready(function() {
																$("#OBLIcuerpo").jqte();
																$("#"+combo).autocomplete({
																	source : \'busquedas/busqueda_\'+obli+\'.php\',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		rut = rut +\';\';
																		$("#"+obli).append(rut);
																		//$("#"+VER).append(rut);
																		}
																	});
																});
	                                                    </script>
														'; ?>

													<?php endif; ?>
                                            	<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'SELECT' )): ?>
													<SELECT id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
','<?php echo $this->_tpl_vars['TABLA']; ?>
');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
')" > 
                                                    </SELECT>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'FECHA' )): ?>
													<?php if ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'FechaNacimientoProfesor'): ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_1 = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button_1 = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input_1, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_1 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input_1).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

													<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'IngresoFuncionario'): ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_2 = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button_2 = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input_2, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_2 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input_2).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

													<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'FechaVencimientoCertAntecende'): ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_3 = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button_3 = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input_3, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_3 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input_3).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

													<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'FechaNacimiento'): ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_4 = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button_4 = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input_4, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_4 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input_4).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

													<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'fechaAgenda'): ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" 
														onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
','AgendaMatricula');"
														>
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input).mask("99/99/9999");
	                                                                    }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

													<?php else: ?>
														<INPUT type="text"  id="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input = "FCH<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                
	                                                                var button = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

	                                            	<?php endif; ?>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'HORA' )): ?>
													<?php if ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'horaAgenda'): ?>
															<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00:00' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                $(document).ready(function() {
	                                                                    $(\'#\'+input).mask("99:99");
																		$("#"+input).blur( 	function(){
																			var hora = $(\'#\'+input).val();
		                                                                    var fecha = $(\'#FCHfechaAgenda\').val();
		                                                                    $.ajax({
																				url: "busquedas/buscar_fecha_tomada_agenda_matricula.php?fecha="+fecha+"&hora="+hora, 
																				success: function(data){
																					if (data==\'1\'){
																			        	}
																			        else{
																			        	alert("Fecha y Hora no disponible");
																			        	document.Form1.submit();
																			        	}
																			    	}
																				});
		                                                                    });
	                                                                    });
	                                                        </script>
	                                                        '; ?>

	                                                <?php else: ?>
	                                                	<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='00:00:00' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                $(function($) { 
	                                                                        $(\'#\'+input).mask("99:99:99");
	                                                                        }
	                                                                ); 		
	                                                        </script>
	                                                        '; ?>

	                                                <?php endif; ?>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'FECHATIEMPO' )): ?>
													<INPUT type="text"  id="FT<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="FT<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
                                                        <script type="text/javascript">
	                                                        var input_ft_1 = "FT<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
                                                        	<?php echo '
                                                        	jQuery.datetimepicker.setLocale(\'es\');
                                                        	jQuery(\'#\'+input_ft_1).datetimepicker({
                                                        		i18n:{
																	  de:{
																	   months:[
																	    \'Enero\',\'Febrero\',\'Marzo\',\'Abril\',
																	    \'Mayp\',\'Junio\',\'Julio\',\'Agosto\',
																	    \'Septiembre\',\'Octubre\',\'Noviembre\',\'Diciembre\',
																	   ],
																	   dayOfWeek:[
																	    "Lu", "Ma", "Mie", "Ju", 
																	    "Vi", "Sa", "Do",
																	   ]
																	  }
																	 },
                                                        		format:\'d/m/Y H:i:s\'
                                                        	});
                                                        </script>                                                              
                                                        '; ?>

												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'PASSWORD' )): ?>
													<INPUT type="password"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'USUARIO' )): ?>
													<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='<?php echo $this->_tpl_vars['usuario']; ?>
' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'NUMERO' )): ?>
													<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Coeficiente Prueba' )): ?>
													<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													<?php else: ?>
													<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													<?php endif; ?>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'NOTA' )): ?>
													<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] == 'Coeficiente Prueba' )): ?>
														<INPUT type="text"  id="NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	<?php else: ?>
	                                            		<INPUT type="text"  id="NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	<?php endif; ?>
													<?php if ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'LenguajeObtiene'): ?>
													<script type="text/javascript">
														var input_1 = "NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
														<?php echo '
	                                                        $(function() {
	                                                            $(\'#\'+input_1).on(\'blur\',function(){
	                                                               	var nota  = $(\'#\'+input_1).val();
	                                                               	if (nota>0){
		                                                            	if ((nota>=\'1\')&&(nota<=\'7\')){

		                                                            	}
		                                                            	else{
		                                                            		alert("Ingrese nota valida");
		                                                            		document.getElementById(input_1).value="";
		                                                            		document.getElementById(input_1).focus();
		                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    '; ?>

	                                                </script> 
	                                                <?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'MatematicaObtiene'): ?>
													<script type="text/javascript">
														var input_2 = "NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
														<?php echo '
	                                                        $(function() {
	                                                            $(\'#\'+input_2).on(\'blur\',function(){
	                                                               	var nota  = $(\'#\'+input_2).val();
	                                                            	if (nota>0){
			                                                            if ((nota>=\'1\')&&(nota<=\'7\')){

		                                                            	}
		                                                            	else{
		                                                            		alert("Ingrese nota valida");
		                                                            		document.getElementById(input_2).value="";
		                                                            		document.getElementById(input_2).focus();
		                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    '; ?>

													</script> 
	                                                <?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'LenguajePresenta'): ?>
													<script type="text/javascript">
														var input_3 = "NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
														<?php echo '
	                                                        $(function() {
	                                                            $(\'#\'+input_3).on(\'blur\',function(){
	                                                               	var nota  = $(\'#\'+input_3).val();
	                                                            	if (nota>0){
		                                                            if ((nota>=\'1\')&&(nota<=\'7\')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_3).value="";
	                                                            		document.getElementById(input_3).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    '; ?>

													</script> 
	                                                <?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'MatematicaPresenta'): ?>
													<script type="text/javascript">
														var input_4 = "NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
														<?php echo '
	                                                        $(function() {
	                                                            $(\'#\'+input_4).on(\'blur\',function(){
	                                                               	var nota  = $(\'#\'+input_4).val();
	                                                            	if (nota>0){
		                                                            if ((nota>=\'1\')&&(nota<=\'7\')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_4).value="";
	                                                            		document.getElementById(input_4).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    '; ?>

													</script> 
	                                                <?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'UltimoPromedio'): ?>
													<script type="text/javascript">
														var input_5 = "NOTA<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
														<?php echo '
	                                                        $(function() {
	                                                            $(\'#\'+input_5).on(\'blur\',function(){
	                                                               	var nota  = $(\'#\'+input_5).val();
	                                                            	if (nota>0){
		                                                            if ((nota>=\'1\')&&(nota<=\'7\')){

	                                                            	}
	                                                            	else{
	                                                            		alert("Ingrese nota valida");
	                                                            		document.getElementById(input_5).value="";
	                                                            		document.getElementById(input_5).focus();
	                                                            	}
	                                                            	}
	                                                            });
	                                                        });
	                                                    '; ?>

													</script> 
	                                                <?php endif; ?>
													    
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'RUT' )): ?>
													<INPUT type="text" class="rut" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' />
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'OPC' )): ?>											<INPUT type="text" class="rut" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='.' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'CHECK' )): ?>
													<INPUT type="checkbox" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="1"/>
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'AREA' )): ?>
													<textarea id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" rows="3" cols="115"><?php if ($this->_tpl_vars['email'] != ''): ?>Sr(a). <?php echo $this->_tpl_vars['nombre_apoderado']; ?>
, <br/> Apoderado de <?php echo $this->_tpl_vars['nombre_alumno']; ?>
<br>del curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
<br><br><br>Atentamente, <br>Inspectoria General<br>Colegio Nuevo Milenio<?php endif; ?></textarea>
                        <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'FOTO' )): ?>
													<script type="text/javascript">
													var input_foto_1 = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
													<?php echo '
                                                        $(function() {
                                                            $(\'#file-name\').uploadify({
                                                                \'swf\'      			: \'uploadify.swf\',
                                                                \'uploader\' 			: \'uploadify.php\',
																\'buttonText\' 		: \'Subir Foto\',
																\'onUploadSuccess\' 	: function(file, data, response){
														            document.getElementById(\'img_\'+input_foto_1).src = \'uploads/\'+file.name;
																	document.getElementById(input_foto_1).value= \'uploads/\'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    '; ?>

                                                    <div id="queue"></div>
                                                    <input id="file-name" name="file-name" type="file" />
                                                    <img src="#" id="img_OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"  name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value=""  />
		                    <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'ARCHIVO' )): ?>
								<script type="text/javascript">
								var input_foto_1 = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
								<?php echo '
                                    $(function() {
                                        $(\'#file-name\').uploadify({
                                            \'swf\'      			: \'uploadify.swf\',
                                            \'uploader\' 			: \'uploadify.php\',
											\'buttonText\' 		: \'Subir Archivo\',
											\'onUploadSuccess\' 	: function(file, data, response){
																document.getElementById(input_foto_1).value= \'uploads/fotos_alumnos/\'+file.name;
											}
                                        });
                                    });
	                        	</script> 
	                        	'; ?>

	                        <input id="file-name" name="file-name" type="file" />
	                        <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"  name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value=""  />
                        <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'BUSCA' )): ?>
                        		<?php if (( $this->_tpl_vars['TABLA'] == 'Postulantes' )): ?>
                        			<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
                                    <script type="text/javascript">
															var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
		                                                    <?php echo '
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : \'busquedas/busqueda_\'+obli+\'_postulantes.php\',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues(\'Form1\'),obli,tabla);
																			}
																		});
																	});
		                                                    </script>
															'; ?>

														<?php elseif (( $this->_tpl_vars['TABLA'] == 'HojasDeVida' )): ?>
		                                        			<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
		                                                    <?php echo '
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : \'busquedas/busqueda_\'+obli+\'.php\',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues(\'Form1\'),obli,tabla);
																			xajax_CargaSelect_1(xajax.getFormValues(\'Form1\'),\'OBLICodigoCurso\'); 
																			}
																		});
																	});
		                                                    </script>
															'; ?>

														<?php elseif (( $this->_tpl_vars['TABLA'] == 'AgendaMatricula' )): ?>
		                                        			<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                        			<br>
		                                                    <input type="text" id="apoderado_nombre" name="apoderado_nombre" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" />
		                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                    <script type="text/javascript">
															var	obli 	= 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var combo 	= 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var apo 	= 'apoderado_nombre';
															var tabla 	= '<?php echo $this->_tpl_vars['TABLA']; ?>
';
		                                                    <?php echo '
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : \'busquedas/busqueda_\'+obli+\'.php\',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			document.getElementById(obli).value = rut;
																			var periodo = \'2018\';
																			if (periodo==\'Elija\'){
																				alert("Elija un Periodo");
																				}
																			else{
																				$.ajax({
																					url: "busquedas/buscar_matricula_condicionada.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																					success: function(data){
																				        if (data==\'1\'){
																							$.ajax({
																								url: "busquedas/buscar_cuotas_impagas.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																								success: function(data){
																							        if (data==\'1\'){
																							        	$.ajax({
																											url: "busquedas/buscar_agenda_matricula.php?NumeroRutAlumno="+rut+"&periodo="+periodo, 
																											success: function(data){
																										        if (data==\'1\'){
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
		                                                    </script>
															'; ?>

														<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutAlumno' ) && ( $this->_tpl_vars['TABLA'] == 'Eximisiones' )): ?>
																<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                        <script type="text/javascript">
																var	obli_2 = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var combo_2 = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
			                                                    <?php echo '
																	$(document).ready(function() {
																		$("#"+combo_2).autocomplete({
																			source : \'busquedas/busqueda_alumno.php\',
																			select: function( event, ui ) {
																				var rut_2 = ui.item.id;
																				document.getElementById(obli_2).value = rut_2;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    </script>
																'; ?>

														<?php elseif (( $this->_tpl_vars['TABLA'] == 'Profesores' )): ?>
		                                        			<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
		                                                    <?php echo '
																$(document).ready(function() {
																	$("#"+combo).autocomplete({
																		source : \'busquedas/busqueda_\'+obli+\'.php\',
																		select: function( event, ui ) {
																			var rut = ui.item.id;
																			var ncorr = ui.item.ncorr;
																			document.getElementById(obli).value = rut;
																			xajax_CargaListado(xajax.getFormValues(\'Form1\'),obli,tabla);
																			xajax_CargaSelect_1(xajax.getFormValues(\'Form1\'),\'OBLICodigoCurso\'); 
																			xajax_TraeValor(xajax.getFormValues(\'Form1\'),ncorr); 
																			}
																		});
																	});
		                                                    </script>
															'; ?>

														<?php elseif ($this->_tpl_vars['TABLA'] == 'declaracion_accidente'): ?>
															<?php if ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutAlumno'): ?>
																<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                        <script type="text/javascript">
																var	obli_1 = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var combo_1 = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
			                                                    <?php echo '
																	$(document).ready(function() {
																		$("#"+combo_1).autocomplete({
																			source : \'busquedas/busqueda_\'+obli_1+\'.php\',
																			select: function( event, ui ) {
																				var rut_1 = ui.item.id;
																				document.getElementById(obli_1).value = rut_1;
																				//$("#"+VER).append(rut);
																				}
			                                                    			});
																		});
																</script>
																'; ?>

															<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutTestigo1'): ?>
																<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                        <script type="text/javascript">
																var	obli_2 = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var combo_2 = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
			                                                    <?php echo '
																	$(document).ready(function() {
																		$("#"+combo_2).autocomplete({
																			source : \'busquedas/busqueda_\'+obli_2+\'.php\',
																			select: function( event, ui ) {
																				var rut_2 = ui.item.id;
																				document.getElementById(obli_2).value = rut_2;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    </script>
																'; ?>

															<?php else: ?>
																<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                        <script type="text/javascript">
																var	obli_3 = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var combo_3 = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
																var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
			                                                    <?php echo '
																	$(document).ready(function() {
																		$("#"+combo_3).autocomplete({
																			source : \'busquedas/busqueda_\'+obli_3+\'.php\',
																			select: function( event, ui ) {
																				var rut_3 = ui.item.id;
																				document.getElementById(obli_3).value = rut_3;
																				//$("#"+VER).append(rut);
																				}
																			});
																		});
			                                                    </script>
																'; ?>

															<?php endif; ?>
																											
		                                        		<?php else: ?>
															<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
															var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
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
		                                                    </script>
															'; ?>

														<?php endif; ?>	
												<?php else: ?>
													<INPUT type="text" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												
                                                
												<?php endif; ?>	
											</td>
										</tr>
										<?php endif; ?>
									<?php endif; ?>
								<?php endfor; endif; ?>
	                            						
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	<?php if (( $this->_tpl_vars['volver'] == 'si' ) && ( ( $this->_tpl_vars['TABLA'] == 'clientes' ) || ( $this->_tpl_vars['TABLA'] == 'proveedores' ) || ( $this->_tpl_vars['TABLA'] == 'prestadores' ) )): ?>
                                        	<input type="button" class="boton" value="Volver"name="btnVolver" onclick="document.location.href='<?php echo $this->_tpl_vars['pagina_volver']; ?>
?nombre_empresa=<?php echo $this->_tpl_vars['nombre_empresa']; ?>
&empresa=<?php echo $this->_tpl_vars['empresa']; ?>
&fecha=<?php echo $this->_tpl_vars['fecha']; ?>
&cliente=<?php echo $this->_tpl_vars['cliente']; ?>
&rut=<?php echo $this->_tpl_vars['rut']; ?>
&nro_factura=<?php echo $this->_tpl_vars['nro_factura']; ?>
&neto=<?php echo $this->_tpl_vars['neto']; ?>
&iva=<?php echo $this->_tpl_vars['iva']; ?>
&total=<?php echo $this->_tpl_vars['total']; ?>
'"/>
                                        <?php endif; ?>
                                        <?php if (( $this->_tpl_vars['readonly'] == '1' && $this->_tpl_vars['TABLA'] != 'BitacorasAcademicas' )): ?>
                                        <?php else: ?>
                                        <a href="#" onclick="javascript: ValidaFormularioMantenedor();" id="btnGuardar" name="btnGuardar">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['TABLA'] == 'Profesores' )): ?>
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
											</a>										
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>										
										<?php elseif (( $this->_tpl_vars['TABLA'] == 'HojasDeVidaProfesores' )): ?>
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=HojasDeVidaProfesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>	
										<?php else: ?>
											<?php if (( $this->_tpl_vars['readonly'] == '1' && $this->_tpl_vars['TABLA'] != 'BitacorasAcademicas' )): ?>
	                                        <?php else: ?>
											<a href="#" onclick="javascript: document.Form1.submit();">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>
											<?php endif; ?>
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['TABLA'] == 'Cursos' )): ?>
                               	            <a href="#" style="cursor: hand;"><img src="../images/gest_fin/respaldos.png" border=0 title="Malla Curricular" onclick="xajax_CursoMallaCurricular(xajax.getFormValues('Form1'))" width="32"></a>
                                        <?php endif; ?>
										<?php if (( $this->_tpl_vars['TABLA'] == 'Postulantes' )): ?>
                                        <a href="#" onclick="xajax_ApoderadoPostulante(xajax.getFormValues('Form1'))">
											<img src='../images/gest_fin/proveedores.png' title='Asociar Apoderado' width="32"/>
										</a>
                                        <?php endif; ?>
										
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
</HTML>