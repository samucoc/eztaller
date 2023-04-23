<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
			

			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
			<script src="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
			<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css">
			<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.print.css">

			
			
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">


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
			$(document).ready(function(){
				    $('#calendar').fullCalendar({
						header: {
							left: 'prev,next today',
							center: 'title',
							right: 'month,agendaWeek,agendaDay,listWeek'
								},
						defaultDate: '2017-08-01',
						editable: true,
						navLinks: true, // can click day/week names to navigate views
						eventLimit: true, // allow "more" link when too many events
						events: {
							startParam: 'start',
                    		endParam: 'end',
							url: '../includes/php/get-events.php',
							error: function() 
					            {
					                alert("error");
					            },
					            success: function()
					            {
					                console.log("successfully loaded");
					            }
						},
						loading: function(bool) {
							$('#loading').toggle(bool);
						}
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
		max-width: 900px;
		margin: 40px auto;
		padding: 0 10px;
	}

</style>
            {/literal}
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
										<label class="form-titulo">
											&nbsp;&nbsp; Agenda Matricula
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='{$TABLA}'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="{$rut_trab}"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">
                                        Fecha Diaria
                                        <label class="requerido"> * </label>
                                   	</td>
									<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="fecha_diaria" name="fecha_diaria" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="2017-08-07">
                                    </td>
                               	</tr>
										
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<a href="#" id="btnBuscar" name="btnBuscar">
											<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
										</a>
										
									</td>
								</tr>
							</table>
							<br>
						</td>
					</tr>
				</table>
			</div>

		</form>
		<div class="item">
					<div id='loading'>loading...</div>
					<div id='calendar'></div>
					<!-- <hr class="clearBoth">					
					<hr class="clearBoth">					
					<div >Historial</div>
					<div id="divabonos"></div> -->
					<br class="clearBoth">					
		</div>
                <div id="calendar-container"></div>
	</body>
</HTML>
