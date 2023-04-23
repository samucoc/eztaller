<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=utf8">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			{if (($TABLA=='declaracion_accidente')||($TABLA=='Postulantes')||($TABLA=='BitacorasAcademicas')||($TABLA=='CertificacionesProfesores')||($TABLA=='ArchivoPersonalAlumnos'))}
			<script type="text/javascript" src="submodal/subModal.js"></script>
			
			{else}                               
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
			{/if}
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
            <script src="../includes_js/jquery.uploadifive.js" type="text/javascript"></script>
			<script src="../includes_js/jquery.Rut.js" type="text/javascript"></script>
			<link rel="stylesheet" type="text/css" href="../estilos/jquery.datetimepicker.min.css">
			
			<script type="text/javascript" src="../includes_js/jquery-te-1.4.0.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.datetimepicker.full.js"></script>
			<LINK href="../includes_js/jquery-te-1.4.0.css" type="text/css" rel="stylesheet"></LINK>               
            <link rel="stylesheet" type="text/css" href="../estilos/uploadifive.css">
			

            {literal}
			<script type="text/javascript">
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
			function calcularEdad(fecha) {
		        // Si la fecha es correcta, calculamos la edad

		        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
		            fecha = formatDate(fecha, "yyyy-MM-dd");
		        }

		        var values = fecha.split("-");
		        var dia = values[2];
		        var mes = values[1];
		        var ano = values[0];

		        // cogemos los valores actuales
		        var fecha_hoy = new Date();
		        var ahora_ano = fecha_hoy.getYear();
		        var ahora_mes = fecha_hoy.getMonth() + 1;
		        var ahora_dia = fecha_hoy.getDate();

		        // realizamos el calculo
		        var edad = (ahora_ano + 1900) - ano;
		        if (ahora_mes < mes) {
		            edad--;
		        }
		        if ((mes == ahora_mes) && (ahora_dia < dia)) {
		            edad--;
		        }
		        if (edad > 1900) {
		            edad -= 1900;
		        }

		        // calculamos los meses
		        var meses = 0;

		        if (ahora_mes > mes && dia > ahora_dia)
		            meses = ahora_mes - mes - 1;
		        else if (ahora_mes > mes)
		            meses = ahora_mes - mes
		        if (ahora_mes < mes && dia < ahora_dia)
		            meses = 12 - (mes - ahora_mes);
		        else if (ahora_mes < mes)
		            meses = 12 - (mes - ahora_mes + 1);
		        if (ahora_mes == mes && dia > ahora_dia)
		            meses = 11;

		        // calculamos los dias
		        var dias = 0;
		        if (ahora_dia > dia)
		            dias = ahora_dia - dia;
		        if (ahora_dia < dia) {
		            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
		            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
		        }

		        return edad + " años, " + meses + " meses y " + dias + " días";
		    }
		    function esNumero(strNumber) {
			    if (strNumber == null) return false;
			    if (strNumber == undefined) return false;
			    if (typeof strNumber === "number" && !isNaN(strNumber)) return true;
			    if (strNumber == "") return false;
			    if (strNumber === "") return false;
			    var psInt, psFloat;
			    psInt = parseInt(strNumber);
			    psFloat = parseFloat(strNumber);
			    return !isNaN(strNumber) && !isNaN(psFloat);
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
				  		document.Form1.submit();
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
						  		document.Form1.submit();
								}
							else{
								document.getElementById("OBLINumeroRutProfesor").value = unidades[0]+unidades[1]+unidades[2];
				  				}
							});
				  		}
				});
				$('#rut_carga').Rut({
				  on_error: function(){ 
				  		alert('Rut incorrecto'); 
				  		document.Form1.submit();
				  	},
				  on_success: function(){
				  		var cadena  = document.getElementById("rut_carga").value;
				  		var nombres = cadena.split("-");;
				  		var unidades = nombres[0].split('.');
				  		document.getElementById("OBLINumeroRutCargaTestigo1").value = unidades[0]+unidades[1]+unidades[2];
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

            </script>                        
            {/literal}
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
											&nbsp;&nbsp; {$TITULO_TABLA} <label id="alumno" name="alumno"></label>
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='{$TABLA}'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="{$rut_trab}"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>

							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                {if ($TABLA=='BitacorasAcademicas' || $TABLA=='Entrevistas' || $TABLA=='ArchivoPersonalAlumnos')}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                           			<a href="#" onclick="location.href='sg_mant_alumnos.php?rut={$rut_trab}&readonly={$readonly}'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_notas.php?rut={$rut_trab}&readonly={$readonly}'">
												<img src='../images/gest_esc/promedio.png' title='Notas' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_HojaVida.php?rut={$rut_trab}&readonly={$readonly}'">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Asistencia.php?rut={$rut_trab}&readonly={$readonly}'">
												<img src='../images/fin_comp/bitacora.png' title='Asistencia' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Apoderado.php?rut={$rut_trab}&readonly={$readonly}'">
												<img src='../images/gest_esc/ficha-apoderado.png' title='Apoderados' width="32"/>
											</a>
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=BitacorasAcademicas&rut={$rut_trab}&readonly={$readonly}'" title="Bit&aacute;cora Acad&eacute;mica" >
												<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora Acad&eacute;mica"  width="32" id="imagen_bitacora"  />
											</a>															
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=Entrevistas&rut={$rut_trab}&readonly={$readonly}'" title="Departamento Psicolog&iacute;a"  >
												<img src='../images/basicos/ficha-psicolgo.png' title="Departamento Psicolog&iacute;a"  width="32" id="imagen_bitacora"  />
											</a>															
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=ArchivoPersonalAlumnos&rut={$rut_trab}&readonly={$readonly}'" title="Archivo Personal"  >
												<img src='../images/gest_fin/proveedores.png' title="Archivo Personal"  width="32" id="imagen_bitacora"  />
											</a>															
                                    	</td>
                                    </tr>
                                {/if}
                                {if ($TABLA=='Profesores')}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
                                    		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut={$rut_trab}'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
		                            		<a href="#" onclick="xajax_CargaListado_Profesores_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_Certificados(xajax.getFormValues('Form1'))">
												<img src='../images/fin_comp/bitacora.png' title='Certificados / Capacitaciones' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_CargasFamiliaresProfesores(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/proveedores.png' title='Cargas Familiares' width="32"/>
											</a>
										</td>
                                    </tr>
                                {/if}
								{if ($TABLA=='Matriculas')}
                                	<tr align="left">
                                    	<td class="tabla-alycar-label" style="width: 30%">
											Matriculados / Retirados
											
                                    	</td>
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<select id="matri_retri" name="matri_retri"  onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'matri_retri','{$TABLA}');">
												<option value="0">Todos</option>
												<option value="1">Matriculados</option>
												<option value="2">Retirados</option>
											</select>
										</td>
                                    </tr>
                                {/if}
								{if (($TABLA=='HojasDeVidaProfesores')&&($rut_trab>0))}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut={$rut_trab}'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_Certificados(xajax.getFormValues('Form1'))">
												<img src='../images/fin_comp/bitacora.png' title='Certificados / Capacitaciones' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_CargasFamiliaresProfesores(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/proveedores.png' title='Cargas Familiares' width="32"/>
											</a>
										</td>
                                    </tr>

                                {/if}
								{if (($TABLA=='CertificacionesProfesores')&&($rut_trab>0))}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut={$rut_trab}'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_Certificados(xajax.getFormValues('Form1'))">
												<img src='../images/fin_comp/bitacora.png' title='Certificados / Capacitaciones' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_CargasFamiliaresProfesores(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/proveedores.png' title='Cargas Familiares' width="32"/>
											</a>
										</td>
                                    </tr>
                                {/if}
								{if (($TABLA=='CargasFamiliaresProfesores')&&($rut_trab>0))}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                            		<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores&rut={$rut_trab}'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Funcionarios' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_HojaVida(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_Certificados(xajax.getFormValues('Form1'))">
												<img src='../images/fin_comp/bitacora.png' title='Certificados / Capacitaciones' width="32"/>
											</a>
											<a href="#" onclick="xajax_CargaListado_Profesores_CargasFamiliaresProfesores(xajax.getFormValues('Form1'))">
												<img src='../images/gest_fin/proveedores.png' title='Cargas Familiares' width="32"/>
											</a>
										</td>
                                    </tr>
                                {/if}
							
 								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">C&oacute;digo:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<label class="comentario">Se Asigna Autom&aacute;ticamente</label>
									</td>
								</tr>
								
								{if ($TABLA == trabajadores_tienen_cargas)}
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Trabajador</td>
									<td class="tabla-alycar-texto" style="width: 70%">{$rut}<input type="hidden" id="OBLIrut_papa" name="OBLIrut_papa" value="{$rut_trab}"/></td>
								</tr>
                                {/if}
                                
								{section name=campos loop=$arrCampos}
									
									{if ($arrCampos[campos].titulo != '')}
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">{$arrCampos[campos].titulo} 
	                                            {if (($arrCampos[campos].objeto == 'OPC')||
	                                            		($arrCampos[campos].titulo =='Fecha Ingreso Nota Prueba')||
	                                            		($arrCampos[campos].titulo =='Fecha Real Prueba')||
	                                            		($arrCampos[campos].titulo =='Observacion')||
	                                            		($arrCampos[campos].titulo =='Insuficiente')||
	                                            		($arrCampos[campos].titulo =='Suficiente')||
	                                            		($arrCampos[campos].titulo =='Bueno')||
	                                            		($arrCampos[campos].titulo =='Muy Bueno')||
	                                            		($arrCampos[campos].titulo =='DATOS PERSONALES')||
	                                            		($arrCampos[campos].titulo =='EVALUACIÓN'))}
	                                            {else}
													<label class="requerido"> * </label>
												{/if}
											</td>
											<td class="tabla-alycar-texto" style="width: 70%">
												{if (($TABLA=='Postulantes')&&($arrCampos[campos].campo=='PeriodoPostulacion'))}
													<div style="width:33%; float: left;">
														<select id="OBLIPeriodoPostulacion" name="OBLIPeriodoPostulacion" onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion','Postulantes');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLIPeriodoPostulacion');">
														</select>
													</div>
													<div style="width: 60%; float: left; display: none;" id="estado_oculto">
														Estado :
														<select id="OBLIAutorizado" name="OBLIAutorizado"  style="width: 60%; float: left; display: none;" >
														</select>
													</div>
												{elseif (($arrCampos[campos].campo=='AnoAcademico')&&($TABLA=='Pruebas'))}
													<input type="hidden" name="OBLIAnoAcademico" id="OBLIAnoAcademico" value="{$anio_vigente}"/> 
													{$anio_vigente}
												{elseif (($arrCampos[campos].campo=='DescripcionPrueba')&&($TABLA=='Pruebas'))}
													<input type="text" name="OBLIDescripcionPrueba" id="OBLIDescripcionPrueba" size="50" maxlength="50" value=""/> 
												{elseif (($arrCampos[campos].campo=='Semestre')&&($TABLA=='Pruebas'))}
													<select id="OBLISemestre" name="OBLISemestre" ></select>
												{elseif (($arrCampos[campos].campo=='CodigoCurso')&&($TABLA=='Pruebas'))}
													<select id="OBLICodigoCurso" name="OBLICodigoCurso" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLICodigoCurso','Pruebas');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLICodigoCurso')"></select>
												{elseif (($arrCampos[campos].campo=='Curso')&&($TABLA=='BitacorasAcademicas'))}
													<input type="hidden" name="OBLICurso" id="OBLICurso" /> 
													<input type="text" name="nombre_curso" id="nombre_curso" maxLength="100" size="50" readonly="readonly" />
												{elseif (($arrCampos[campos].campo=='ProfesorJefe')&&($TABLA=='BitacorasAcademicas'))}
													<input type="hidden" name="OBLIProfesorJefe" id="OBLIProfesorJefe" /> 
													<input type="text" name="nombre_profesor" id="nombre_profesor" maxLength="100" size="50" readonly="readonly" />
												{elseif (($arrCampos[campos].campo=='NumeroRutAlumno')&&($TABLA=='Postulantes'))}
													<input type="hidden" name="OBLINumeroRutAlumno" id="OBLINumeroRutAlumno" size="50" maxlength="50" value="" /> 
													<input type="text" name="rut_postulante" id="rut_postulante" onblur="validaRut(this.value)" />
												{elseif $arrCampos[campos].campo=='NumeroRutTestigo1'}
													<input type="hidden" name="OBLINumeroRutTestigo1" id="OBLINumeroRutTestigo1" /> 
													<input type="text" name="rut_testigo1" id="rut_testigo1" onblur="validaRut(this.value)" />
												{elseif $arrCampos[campos].campo=='NumeroRutTestigo2'}
													<input type="hidden" name="OBLINumeroRutTestigo2" id="OBLINumeroRutTestigo2" /> 
													<input type="text" name="rut_testigo2" id="rut_testigo2" onblur="validaRut(this.value)" />
												{elseif (($arrCampos[campos].campo=='NumeroRutProfesor')&&($TABLA=='Profesores'))}
													<input type="hidden" name="OBLINumeroRutProfesor" id="OBLINumeroRutProfesor" /> 
													<input type="text" name="rut_profesor" id="rut_profesor" onblur="validaRut(this.value)" />
												{elseif (($arrCampos[campos].campo=='NumeroRutCarga')&&($TABLA=='CargasFamiliaresProfesores'))}
													<input type="hidden" name="OBLINumeroRutCarga" id="OBLINumeroRutCarga" /> 
													<input type="text" name="rut_carga" id="rut_carga" onblur="validaRut(this.value)" />
												{elseif $arrCampos[campos].campo=='destinatarios'}
													{if $TABLA=='correos_apoderados'}
														<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" {if $email != ''} value="{$email}"{/if}/>
														{if $email != ''}

														{else}
														<select id="correos_apoderados_cursos" name="correos_apoderados_cursos" class="boton" onchange="xajax_ApoderadosCurso(xajax.getFormValues('Form1'))" >
														</select>
														<input type="button" class="boton" name="bntLimpiar" id="btnLimpiar" onclick="xajax_ApoderadosCursoEliminar(xajax.getFormValues('Form1'))" value="Limpiar Destinatarios">
														{/if}
														<br />
	                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" {if $email != ''} value="{$email};"{/if}/>
	                                                    <textarea id="VER{$arrCampos[campos].campo}" name="VER{$arrCampos[campos].campo}" rows="5" cols="100">{if $email != ''}{$email}{/if}</textarea>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI{$arrCampos[campos].campo}';
														var combo = 'BSC{$arrCampos[campos].campo}';
														var tabla = '{$TABLA}';
	                                                    {literal}
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
	                                                    </script>
														{/literal}
													{else}
														<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
														<input type="button" class="boton" name="incluir" id="incluir" value="Incluir Todos"
															onclick="xajax_Todos(xajax.getFormValues('Form1'))"></input>
														<input type="button" class="boton" name="quitar" id="quitar" value="Quitar Todos"
															onclick="xajax_Quitar(xajax.getFormValues('Form1'))"></input>
														<br />
	                                                    <textarea id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" rows="5" cols="100"></textarea>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI{$arrCampos[campos].campo}';
														var combo = 'BSC{$arrCampos[campos].campo}';
														var tabla = '{$TABLA}';
	                                                    {literal}
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
	                                                    </script>
														{/literal}
													{/if}
                                            	{elseif ($arrCampos[campos].objeto == 'SELECT')}
													<SELECT id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}','{$TABLA}');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}')" > 
                                                    </SELECT>
												{elseif ($arrCampos[campos].objeto == 'FECHA')}
													{if $arrCampos[campos].campo == 'FechaNacimientoProfesor'}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                    <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                    <div id="edad_{$arrCampos[campos].campo}"></div>
	                                                        <script type="text/javascript">
	                                                                var input_1 = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button_1 = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input_1, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_1 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                    $('#'+input_1).mask("99/99/9999");
	                                                                    }); 		
	                                                        </script>                                                                               
	                                                        {/literal}
													{elseif $arrCampos[campos].campo == 'IngresoFuncionario'}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                    <div id="edad_{$arrCampos[campos].campo}"></div>
	                                                    
	                                                        <script type="text/javascript">
	                                                                var input_2 = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button_2 = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input_2, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_2 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_2).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
													{elseif $arrCampos[campos].campo == 'FechaVencimientoCertAntecende'}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_3 = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button_3 = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input_3, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_3 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_3).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
													{elseif $arrCampos[campos].campo == 'FechaNacimiento'}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input_4 = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button_4 = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input_4, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button_4 ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input_4).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
													{elseif $arrCampos[campos].campo == 'fechaAgenda'}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" value='00/00/0000' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" 
														onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'FCH{$arrCampos[campos].campo}','AgendaMatricula');"
														>
	                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99/99/9999");
	                                                                    }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
													{else}
														<INPUT type="text"  id="FCH{$arrCampos[campos].campo}" name="FCH{$arrCampos[campos].campo}" class="OBLI-fecha" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
	                                                        <script type="text/javascript">
	                                                                var input = "FCH{$arrCampos[campos].campo}";
	                
	                                                                var button = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
	                                            	{/if}
												{elseif ($arrCampos[campos].objeto == 'HORA')}
													{if $arrCampos[campos].campo == 'horaAgenda'}
															<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" class="OBLI-fecha" value='{$smarty.now|date_format:"%H:%M:%S"}' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI{$arrCampos[campos].campo}";
	                                                                {literal}
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
	                                                        </script>
	                                                        {/literal}
	                                                {elseif $arrCampos[campos].campo == 'HoraInicio'}
	                                                	<INPUT type="text"  id="OBLIHoraInicio" name="OBLIHoraInicio" class="OBLI-fecha" value='{$smarty.now|date_format:"%H:%M:%S"}' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
                                                                $(function($) { 
                                                                        $('#OBLIHoraInicio').mask("99:99:99");
                                                                        }
                                                                ); 		
	                                                        </script>
	                                                {elseif $arrCampos[campos].campo == 'HoraFin'}
	                                                	<INPUT type="text"  id="OBLIHoraFin" name="OBLIHoraFin" class="OBLI-fecha" value='{$smarty.now|date_format:"%H:%M:%S"}' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
                                                                $(function($) { 
                                                                        $('#OBLIHoraFin').mask("99:99:99");
                                                                        }
                                                                ); 		
	                                                        </script>
	                                                {else}
	                                                	<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" class="OBLI-fecha" value='{$smarty.now|date_format:"%H:%M:%S"}' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99:99:99");
	                                                                        }
	                                                                ); 		
	                                                        </script>
	                                                        {/literal}
	                                                {/if}
												{elseif ($arrCampos[campos].objeto == 'FECHATIEMPO')}
													<INPUT type="text"  id="FT{$arrCampos[campos].campo}" name="FT{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" >
                                                        <script type="text/javascript">
	                                                        var input_ft_1 = "FT{$arrCampos[campos].campo}";
                                                        	{literal}
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
                                                        </script>                                                              
                                                        {/literal}
												{elseif ($arrCampos[campos].objeto == 'PASSWORD')}
													<INPUT type="password"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												{elseif ($arrCampos[campos].objeto == 'USUARIO')}
													<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='{$usuario}' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
												{elseif ($arrCampos[campos].objeto == 'NUMERO')}
													{if ($arrCampos[campos].titulo =='Coeficiente Prueba')}
													<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													{else}
													<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
													{/if}
												{elseif ($arrCampos[campos].objeto == 'NOTA')}
													{if ($arrCampos[campos].titulo =='Coeficiente Prueba')}
														<INPUT type="text"  id="NOTA{$arrCampos[campos].campo}" name="NOTA{$arrCampos[campos].campo}" value='1' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	{else}
	                                            		<INPUT type="text"  id="NOTA{$arrCampos[campos].campo}" name="NOTA{$arrCampos[campos].campo}" value='0' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50" >
	                                            	{/if}
													{if $arrCampos[campos].campo=='LenguajeObtiene'}
													<script type="text/javascript">
														var input_1 = "NOTA{$arrCampos[campos].campo}";
														{literal}
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
	                                                    {/literal}
	                                                </script> 
	                                                {elseif $arrCampos[campos].campo=='MatematicaObtiene'}
													<script type="text/javascript">
														var input_2 = "NOTA{$arrCampos[campos].campo}";
														{literal}
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
	                                                    {/literal}
													</script> 
	                                                {elseif $arrCampos[campos].campo=='LenguajePresenta'}
													<script type="text/javascript">
														var input_3 = "NOTA{$arrCampos[campos].campo}";
														{literal}
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
	                                                    {/literal}
													</script> 
	                                                {elseif $arrCampos[campos].campo=='MatematicaPresenta'}
													<script type="text/javascript">
														var input_4 = "NOTA{$arrCampos[campos].campo}";
														{literal}
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
	                                                    {/literal}
													</script> 
	                                                {elseif $arrCampos[campos].campo=='UltimoPromedio'}
													<script type="text/javascript">
														var input_5 = "NOTA{$arrCampos[campos].campo}";
														{literal}
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
	                                                    {/literal}
													</script> 
	                                                {/if}
													    
												{elseif ($arrCampos[campos].objeto == 'RUT')}
													<INPUT type="text" class="rut" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' />
                                                {elseif ($arrCampos[campos].objeto == 'OPC')}														<INPUT type="text" class="rut" id="{$arrCampos[campos].campo}" name="{$arrCampos[campos].campo}" value='.' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                {elseif ($arrCampos[campos].objeto == 'CHECK')}
													<INPUT type="checkbox" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="1"/>
                                                {elseif ($arrCampos[campos].objeto == 'AREA')}
													<textarea id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" rows="3" cols="115" {if ($TABLA=='Entrevistas')} maxlength="325" {/if} >{if $email!=''}Sr(a). {$nombre_apoderado}, <br/> Apoderado de {$nombre_alumno}<br>del curso {$nombre_curso}<br><br><br>Atentamente, <br> Josselyn Campos- Catalina Calderón<br/>Equipo Directivo<br/>Escuela Especial de Lenguaje</br>Arcoíris<br/>{/if}</textarea>
                        {elseif ($arrCampos[campos].objeto == 'FOTO')}
													<script type="text/javascript">
													var input_foto_1 = "OBLI{$arrCampos[campos].campo}";
													{literal}
                                                        $(function() {
                                                            $('#file-name').uploadifive({
                                                                'uploadScript' 		: 'uploadifive.php',
																'auto' 				: true,
																'buttonText' 		: 'Documento',
																'onUploadComplete' 	: function(file, data){
														            document.getElementById('img_'+input_foto_1).src = 'uploads/'+file.name;
																	document.getElementById(input_foto_1).value= 'uploads/'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    {/literal}
                                                    <div id="queue"></div>
                                                    <input id="file-name" name="file-name" type="file" />
                                                    <img src="#" id="img_OBLI{$arrCampos[campos].campo}" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}"  name="OBLI{$arrCampos[campos].campo}" value=""  />
		                    {elseif ($arrCampos[campos].objeto == 'ARCHIVO')}
								<script type="text/javascript">
								var input_foto_1 = "OBLI{$arrCampos[campos].campo}";
								{literal}
                                    $(function() {
                                        $('#file-name').uploadifive({
                                            'uploadScript' 		: 'uploadifive.php',
                                            'buttonText' 		: 'Archivo',
											'auto' 				: true,
											'onUploadSuccess' 	: function(file, data){
																document.getElementById(input_foto_1).value= 'uploads/fotos_alumnos/'+file.name;
											}
                                        });
                                    });
	                        	</script> 
	                        	{/literal}
	                        <input id="file-name" name="file-name" type="file" />
	                        <input type="hidden" id="OBLI{$arrCampos[campos].campo}"  name="OBLI{$arrCampos[campos].campo}" value=""  />
                        {elseif ($arrCampos[campos].objeto == 'BUSCA')}
                        		{if ($TABLA=='Postulantes')}
                        			<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
                                    <script type="text/javascript">
															var	obli = 'OBLI{$arrCampos[campos].campo}';
															var combo = 'BSC{$arrCampos[campos].campo}';
															var tabla = '{$TABLA}';
		                                                    {literal}
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
		                                                    </script>
															{/literal}
														{elseif ($TABLA=='HojasDeVida')}
		                                        			<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI{$arrCampos[campos].campo}';
															var combo = 'BSC{$arrCampos[campos].campo}';
															var tabla = '{$TABLA}';
		                                                    {literal}
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
		                                                    </script>
															{/literal}
														{elseif ($TABLA=='AgendaMatricula')}
		                                        			<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                        			<br>
		                                                    <input type="text" id="apoderado_nombre" name="apoderado_nombre" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" />
		                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                    <script type="text/javascript">
															var	obli 	= 'OBLI{$arrCampos[campos].campo}';
															var combo 	= 'BSC{$arrCampos[campos].campo}';
															var apo 	= 'apoderado_nombre';
															var tabla 	= '{$TABLA}';
		                                                    {literal}
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
		                                                    </script>
															{/literal}
														{elseif ($arrCampos[campos].campo=='NumeroRutAlumno')&&($TABLA=='Eximisiones')}
																<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                        <script type="text/javascript">
																var	obli_2 = 'OBLI{$arrCampos[campos].campo}';
																var combo_2 = 'BSC{$arrCampos[campos].campo}';
																var tabla = '{$TABLA}';
			                                                    {literal}
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
			                                                    </script>
																{/literal}
														{elseif ($TABLA=='Profesores')}
		                                        			<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI{$arrCampos[campos].campo}';
															var combo = 'BSC{$arrCampos[campos].campo}';
															var tabla = '{$TABLA}';
		                                                    {literal}
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
		                                                    </script>
															{/literal}
														{elseif $TABLA=='declaracion_accidente'}
															{if $arrCampos[campos].campo=='NumeroRutAlumno'}
																<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                        <script type="text/javascript">
																var	obli_1 = 'OBLI{$arrCampos[campos].campo}';
																var combo_1 = 'BSC{$arrCampos[campos].campo}';
																var tabla = '{$TABLA}';
			                                                    {literal}
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
																</script>
																{/literal}
															{elseif $arrCampos[campos].campo=='NumeroRutTestigo1'}
																<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                        <script type="text/javascript">
																var	obli_2 = 'OBLI{$arrCampos[campos].campo}';
																var combo_2 = 'BSC{$arrCampos[campos].campo}';
																var tabla = '{$TABLA}';
			                                                    {literal}
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
			                                                    </script>
																{/literal}
															{else}
																<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
			                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                        <script type="text/javascript">
																var	obli_3 = 'OBLI{$arrCampos[campos].campo}';
																var combo_3 = 'BSC{$arrCampos[campos].campo}';
																var tabla = '{$TABLA}';
			                                                    {literal}
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
			                                                    </script>
																{/literal}
															{/if}
																											
		                                        		{else}
															<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
		                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
		                                                    <script type="text/javascript">
															var	obli = 'OBLI{$arrCampos[campos].campo}';
															var combo = 'BSC{$arrCampos[campos].campo}';
															var tabla = '{$TABLA}';
		                                                    {literal}
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
		                                                    </script>
															{/literal}
														{/if}	
												{elseif ($arrCampos[campos].objeto == 'linea')}
												{else}
													<INPUT type="text" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												
                                                
												{/if}	
											</td>
										</tr>
									{/if}
								{/section}
	                            						
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	{if ($readonly=='1')}
                                        {else}
                                        <a href="#" onclick="javascript: ValidaFormularioMantenedor();" id="btnGuardar" name="btnGuardar">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										{/if}
										{if ($TABLA=='Profesores')}
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
											</a>										
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=Profesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>										
										{elseif ($TABLA=='HojasDeVidaProfesores')}
											<a href="#" onclick="location.href='sg_mant_tablas.php?tbl=HojasDeVidaProfesores'">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>	
										{else}
											{if ($readonly=='1')}
	                                        {else}
											<a href="#" onclick="javascript: document.Form1.submit();">
												<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
											</a>
											{/if}
										{/if}
										{if ($TABLA == 'Cursos')}
                               	            <a href="#" style="cursor: hand;"><img src="../images/gest_fin/respaldos.png" border=0 title="Malla Curricular" onclick="xajax_CursoMallaCurricular(xajax.getFormValues('Form1'))" width="32"></a>
                                        {/if}
										{if ($TABLA == 'Postulantes')}
                                        <a href="#" onclick="xajax_ApoderadoPostulante(xajax.getFormValues('Form1'))">
											<img src='../images/gest_fin/proveedores.png' title='Asociar Apoderado' width="32"/>
										</a>
                                        {/if}
										
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