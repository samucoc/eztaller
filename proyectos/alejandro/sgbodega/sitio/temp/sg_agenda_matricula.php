<?php
ob_start();
session_start();

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<title></title>
			<meta charset='utf-8' />		
			

			<link href='../includes_js/fullcalendar.min.css' rel='stylesheet' />
			<link href='../includes_js/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<script src='../includes_js/moment.min.js'></script>
			<script src='../includes_js/jquery.min.js'></script>
			<script src='../includes_js/fullcalendar.min.js'></script>
			<script src='../includes_js/locale-all.js'></script>
			
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.css" />
	
		    
		    <script src='../includes_js/jquery.maskedinput.1.3.1.js'></script>
			    <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

			<script type="text/javascript">
	   			$(document).ready(function(){
				    $('#calendar').fullCalendar({
						header: {
							left: 'prev,next today',
							center: 'title',
							right: 'month,agendaDay'
								},
						defaultView: 'month',
						locale: 'es',
						editable: false,
						eventLimit: true, // allow "more" link when too many events
						events: 
							<?php 
								$sql = "SELECT am_ncorr, fechaAgenda, horaAgenda, concat(fechaAgenda,' ',horaAgenda) as fechahora,
												concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno) as alumno, 
												observacion
										FROM AgendaMatricula
											inner join alumnos".$anio."
												on alumnos".$anio.".NumeroRutAlumno = AgendaMatricula.NumeroRutAlumno";
								$res = mysql_query($sql, $conexion) or die(mysql_error());
								$i=0;
								//mysql_query('SET NAMES utf8');
								$data = '[';
								while ($row = mysql_fetch_assoc($res)) {
									$titulo = $row['alumno'];
									$start = $row['fechahora'];
									$end = $row['fechahora'];
									$observacion = $row['observacion'];
									
									$data .= "{'title' : '".utf8_encode($titulo)."','description' : '".utf8_encode($titulo. ' - '.$observacion)."','start':'".$start."','end':'".$end."'},";
									$i++;
								}
								$data = substr($data, 0, strlen($data)-1);
								echo $data .="]";
							?>
						,
						eventRender: function (event, element) {
					        element.attr('href', 'javascript:void(0);');
					        element.click(function() {
					            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
					            $("#eventInfo").html(event.description);
					            $("#eventContent").dialog({ modal: true, title: event.title, width:480});
					        });
					    },
					    dayClick: function(date, jsEvent, view) {
				    		$("#eventAgregar").dialog({ modal: true, title: date.title, height:600, width:800});
						    }
						});
				    $.datepicker.regional['es'] = {
				         closeText: 'Cerrar',
				         prevText: '< Ant',
				         nextText: 'Sig >',
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
				         yearSuffix: ''
				         };
				    $.datepicker.setDefaults($.datepicker.regional['es']);    
				    $('#fechaAgenda').datepicker({
				        dateFormat:"dd/mm/yy"
				    	});
					$('#horaAgenda').mask("99:99");
					$("#horaAgenda").blur( 	function(){
						var hora = $('#horaAgenda').val();
	                    var fecha = $('#fechaAgenda').val();
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
		<style>
			body {
				margin: 0;
				padding: 0;
				font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
				font-size: 14px;
			}

			#script-warning {
				display: none;
				background: #eee;
				border-bottom: 1px solid #ddd;
				padding: 0 10px;
				line-height: 40px;
				text-align: center;
				font-weight: bold;
				font-size: 12px;
				color: red;
			}

			#loading {
				display: none;
				position: absolute;
				top: 10px;
				right: 10px;
			}

			#calendar {
				max-width: 100%;
				margin: 40px auto;
				padding: 0 10px;
			}

		</style>
	</HEAD>
	<body style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server" >
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Database-Add-48.png"></td>
									<td style="width: 93%">
										<label class="form-titulo">Agenda Matricula</label>
									</td>
								</tr>
							</table>
							<br>
							<div id="eventContent" title="Event Details" style="display:none;">
							    Fecha Hora: <span id="startTime"></span><br>
							    <p id="eventInfo"></p>
							</div>
							<div id="eventAgregar" title="Agregar Agenda" style="display:none;">
							    <div style="float: left; text-align: left; width: 30%">Fecha</div>
							    <div style="float: left; text-align: left; width: 60%">
							    	<input type="text" id="fechaAgenda" name="fechaAgenda" />
							    </div>
							    <br style="clear:both"/>
							    <div style="float: left; text-align: left;  width: 30%">Hora</div>
							    <div style="float: left; text-align: left; width: 60%">
							    	<input type="text" id="horaAgenda" name="horaAgenda" />
							    </div>
							    <br style="clear:both"/>
							    <div style="float: left; text-align: left; width: 30%">Alumno</div>
							    <div style="float: left; text-align: left; width: 60%">
	    				<input type="text" id="BSCNumeroRutAlumno" name="BSCNumeroRutAlumno" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    <input type="hidden" id="OBLINumeroRutAlumno" name="OBLINumeroRutAlumno">
                                    <script type="text/javascript">
									var	obli = 'OBLINumeroRutAlumno';
									var combo = 'BSCNumeroRutAlumno';
									var tabla = 'AgendaMatricula';
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
												$("#BSCNumeroRutAlumno").autocomplete("option", "appendTo", "#eventAgregar");
											});
                                    </script>
							    </div>
							    <br style="clear:both"/>
							    <div style="float: left; text-align: left; width: 30%">Observación</div>
							    <div style="float: left; text-align: left; width: 60%">
									<input type="text" id="OBLIobservacion" name="OBLIobservacion" value="" maxlength="100" size="50">
								</div>
							    <br style="clear:both"/>
							</div>
							<div class="item">
										<div id='calendar'></div>
							</div>
						</td>
					</tr>
				</table>
			</div>

		</form>
		
		
	</body>
</HTML>

	