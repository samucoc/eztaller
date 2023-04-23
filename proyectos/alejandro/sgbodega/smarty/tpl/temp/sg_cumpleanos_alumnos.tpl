<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Informe de Precargas </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
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
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>

		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
					
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	

    
	{literal}
	<script>
            $(function($) { 
                    $('#fecha').mask("99/99/9999");
                    }
            ); 	
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
                            $('#fecha').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd-mm-yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : 'busquedas/busqueda_alumno.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLIRutAlumno').value = rut;
                                    }
                                });
                             
                            });
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
	</script>
	{/literal}
	</HEAD>
	<body style="background:#ffffff;" onload="xajax_CargaPagina(xajax.getFormValues('Form1'));"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Cumplea&ntilde;os de Alumnos</td>
									<input type="hidden" id="arr_folios" name="arr_folios"/>
                					<input type="hidden" id="arr_folios_vdet" name="arr_folios_vdet"/>
								</tr>
								
								<tr align="left">
									<td class="tabla-alycar-label" >Fecha</td>
									<td class="tabla-alycar-texto" >
										<!--<select name="dia" id="dia">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
											<option value="29">29</option>
											<option value="30">30</option>
											<option value="31">31</option>
										</select>
										de -->
										<select name="mes" id="mes">
											<option value="1">Enero</option>
											<option value="2">Febrero</option>
											<option value="3">Marzo</option>
											<option value="4">Abril</option>
											<option value="5">Mayo</option>
											<option value="6">Junio</option>
											<option value="7">Julio</option>
											<option value="8">Agosto</option>
											<option value="9">Septiembre</option>
											<option value="10">Octubre</option>
											<option value="11">Noviembre</option>
											<option value="12">Diciembre</option>
										</select>
									</td>
								</TR>
								
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
										</a>
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
	</body>
</HTML>