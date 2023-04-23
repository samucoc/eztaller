<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
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
        <SCRIPT language="javascript">
			function checkAll(theForm, cName, status) {
				for (i=0,n=theForm.elements.length;i<n;i++)
				  if (theForm.elements[i].className.indexOf(cName) !=-1) {
					theForm.elements[i].checked = status;
				  }
				}
			var patron = new Array(2,2,4)
			var patron2 = new Array(1,3,3,3,3)
			function mascara(d,sep,pat,nums){
				if(d.valant != d.value){
					val = d.value
					largo = val.length
					val = val.split(sep)
					val2 = ''
					for(r=0;r<val.length;r++){
						val2 += val[r]	
					}
					if(nums){
						for(z=0;z<val2.length;z++){
							if(isNaN(val2.charAt(z))){
								letra = new RegExp(val2.charAt(z),"g")
								val2 = val2.replace(letra,"")
							}
						}
					}
					val = ''
					val3 = new Array()
					for(s=0; s<pat.length; s++){
						val3[s] = val2.substring(0,pat[s])
						val2 = val2.substr(pat[s])
					}
					for(q=0;q<val3.length; q++){
						if(q ==0){
							val = val3[q]
						}
						else{
							if(val3[q] != ""){
								val += sep + val3[q]
								}
						}
					}
					d.value = val
					d.valant = val
					}
				}			
		</SCRIPT>
        <script type="text/javascript">
			$(function($) { 
				$('#txtFecha1').mask("99/99/9999");
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
                            $('#txtFecha1,#txtFecha2').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
                             
                            });
		</script>
		<script type="text/javascript" > 
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
	<!--<body style="background:#ffffff;"> -->
		<form id="Form1" name="Form1" method="post" runat="server">
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%">
                                    	<label class="form-titulo">Asociar Beca a Alumno</label>
                                        <input type="hidden" name="NumeroRutAlumno" id="NumeroRutAlumno" value="{$NumeroRutAlumno}"/>
                                        <input type="hidden" name="CodigoCurso" id="CodigoCurso" value="{$CodigoCurso}"/>
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Alumno</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  		<input type="text" name="nombre_alumno" id="nombre_alumno" readonly="readonly" size="50"/>
                                  </td>
							  	</tr> 
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Curso</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  		<input type="text" name="NombreCurso" id="NombreCurso" readonly="readonly" size="50"/>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Per&iacute;odo</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  		<input type="text" name="anio_cursante" id="anio_cursante" readonly="readonly" size="50"/>
                                  </td>
							  	</tr>
								<tr align="left">
									<td class="tabla-alycar-label">
										<table class="tabla-alycar" cellpadding="0" cellspacing="0" >
											<tr>																							
												<td class="tabla-alycar-texto" style="width: 15%">Aranceles <div id="anio_ant"></div></td>
					  							<td class="tabla-alycar-texto" style="width: 20%">
                      								<div id="valor_pactado_cuota_0"></div>-<div id="valor_pactado_cuota_colegiatura"></div>
                      							</td>
											</tr>
										</table>
									</td>
									<td>
										<table class="tabla-alycar" cellpadding="0" cellspacing="0" >
											<tr>																							
												<td class="tabla-alycar-label" style="width: 15%"> 
													Antecedentes Acad&eacute;micos <div id="anio_academico"></div>
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													Promedio General
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													<div id="promedio_general"></div>
												</td>
											</tr>
											<tr>
												<td class="tabla-alycar-label" style="width: 15%"> 
													
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													% Asistencia
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													<div id="porc_asistencia_nominal"></div>
												</td>
											</tr>
											<tr>																							
												<td class="tabla-alycar-label" style="width: 15%"> 
													
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													Atrasos
												</td>
												<td class="tabla-alycar-label" style="width: 15%"> 
													<div id="atrasos"></div>
												</td>
											</tr>
										</table>
									</td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Tipo Beca Periodo Anterior</td>
								  <td class="tabla-alycar-label" style="width: 20%">
                                  		<div id="nombre_beca_anio_pasado"></div>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Cuotas Vencidas</td>
								  <td class="tabla-alycar-label" style="width: 20%">
                                  		<div id="cuotas_vencidas"></div>
                                  </td>
							  	</tr>
								<tr align="left" >
								  <td class="tabla-alycar-label" style="width: 15%; padding-top: 10px; padding-bottom: 10px">Tipo Beca</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  		<select name="CodigoTipoBeca" id="CodigoTipoBeca" onchange="xajax_CalculoResultados(xajax.getFormValues('Form1'))"></select>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Cuota 0</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<table>
								  		<tr>
								  			<td align="center">
								  				Arancel
								  			</td>
								  			<td align="center">
								  				Beca
								  			</td>
								  			<td align="center">
								  				Pactado
								  			</td>
								  			<td align="center">
								  				Pagado
								  			</td>
								  			<td align="center">
								  				Diferencia
								  			</td>
								  		</tr>
                                  		<tr>
								  			<td>
								  		<input type="text" name="cuota_0" id="cuota_0" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  			<td>
								  		<input type="text" name="cuota_0_beca" id="cuota_0_beca" onchange="xajax_ReCalculoResultados(xajax.getFormValues('Form1'))"size="10" style="text-align:right" />
                                  			</td>
								  			<td>
								  		<input type="text" name="cuota_0_resultado" id="cuota_0_resultado" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  			<td>
                                  				<input type="text" name="cuota_0_pagado" id="cuota_0_pagado" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  			<td>
								  				<input type="text" name="cuota_0_diferencia" id="cuota_0_diferencia" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  		</tr>
                                  	</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Colegiatura</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
								  	<table>
                                  		<tr>
								  			<td>
								  				<input type="text" name="colegiatura" id="colegiatura" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  			<td>
												<input type="text" name="colegiatura_beca" id="colegiatura_beca" onchange="xajax_ReCalculoResultados(xajax.getFormValues('Form1'))"size="10" style="text-align:right" />
                                  			</td>
								  			<td>
									      		<input type="text" name="colegiatura_resultado" id="colegiatura_resultado" readonly="readonly" size="10" style="text-align:right" />
								  			</td>
								  			<td>
                                  				<input type="text" name="colegiatura_pagado" id="colegiatura_pagado" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  			<td>
								  				<input type="text" name="colegiatura_diferencia" id="colegiatura_diferencia" readonly="readonly" size="10" style="text-align:right" />
                                  			</td>
								  		</tr>
                                  	</table>
                                  </td>
							  	</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/guardar.png' title='Actualizar Cuenta Corriente Alumno' width="32"/>
										</a>
									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
		</div>
                        <div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divabonos'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>