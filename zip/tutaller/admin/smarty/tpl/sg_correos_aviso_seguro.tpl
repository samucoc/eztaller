<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
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
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>		
		{literal}
 		<script type="text/javascript">
			$(document).ready(function() { 
				 $("#cboPersona_1").autocomplete({
					source : 'busquedas/busqueda_persona_email.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('rut_trabajador_1').value = rut;
						}
					});
				 $("#cboPersona_2").autocomplete({
					source : 'busquedas/busqueda_persona_email.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('rut_trabajador_2').value = rut;
						}
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
				   tmp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
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

		{/literal}
	
	</HEAD>
	<body  style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/email.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Aviso de Seguro</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" >Usuario:</td>
									<td class="tabla-alycar-texto" >
                                        <input name="cboPersona_1" id="cboPersona_1" value="" />
                                        <input type="hidden" name="rut_trabajador_1" id="rut_trabajador_1"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" >2do Usuario:</td>
									<td class="tabla-alycar-texto" >
                                        <input name="cboPersona_2" id="cboPersona_2" value="" />
                                        <input type="hidden" name="rut_trabajador_2" id="rut_trabajador_2"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" >Dias de anticipacion:</td>
									<td class="tabla-alycar-texto" >
                                        <input name="dias_anticipa" id="dias_anticipa" value="" onKeyPress="return SoloNumeros(this, event, 0)"/>
									</td>	
                                    <td class="tabla-alycar-texto"  >
                                    	Tantos dias antes del primer dia del mes de vencimiento
                                    </td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" >Repeticion:</td>
									<td class="tabla-alycar-texto" >
                                        <input name="repeticion" id="repeticion" value="" onKeyPress="return SoloNumeros(this, event, 0)"/>
									</td>	
                                    <td class="tabla-alycar-texto"  >
                                    	Cada tantos dias se repita el aviso
                                    </td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</HTML>