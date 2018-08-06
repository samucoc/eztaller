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
			$(function($) { 
				$('#OBLI-txtFecha1').mask("99/99/9999");
				$('#OBLI-txtFecha2').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			$(document).ready(function() { 
                            $("#cboPersona").autocomplete({
                                source : 'busquedas/busqueda_persona.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLI-txtCodCobrador').value = rut;
                                    }
                                });
                           	$("#cboPatente").autocomplete({
								source : 'busquedas/busqueda_vehiculo.php'
								});
                            }); 
            $(window).load(function(){
					 xajax_CargaSelect(xajax.getFormValues('Form1'),'empresa','empresas','','Todas','empe_rut', 'empe_desc', '');
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
	<body  onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
				<td>
					<form id="Form1" name="Form1" method="post" runat="server">
						<br>
						<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left" valign="middle">
								<td style="width: 7%" align='right'><img src="../images/Checklist-48.png"></td>
								<td style="width: 93%"><label class="form-titulo">Informe de Saldo Individual</label>
				</td>
				</tr>
			</table>
			<br>
			<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
					<td class="tabla-alycar-texto" style="width: 85%">
						<input name="cboPersona" id="cboPersona" value="" size="50"/>
						<input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador"></input>
					</td>	
				</tr>
								
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
					<td class="tabla-alycar-texto" style="width: 15%">
                    	<input id="cboPatente" name="cboPatente"  /> 
                    </td>
				</tr>
								
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 20%">Empresa</td>
					<td class="tabla-alycar-texto" style="width: 80%">
						<SELECT id="empresa" name="empresa" onKeyPress="return Tabula(this, event, 0)">
						</SELECT>
					</td>	
				</TR>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 20%">Departamento</td>
					<td class="tabla-alycar-texto" style="width: 80%">
						<SELECT id="depto" name="depto" onKeyPress="return Tabula(this, event, 0)">
							<option value=''>Todos</option>
							<option value='cm'>Casa Matriz</option>
							<option value='b'>Boleta</option>
						</SELECT>
					</td>	
				</TR>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 20%">Producto</td>
					<td class="tabla-alycar-texto" style="width: 80%">
						<SELECT id="producto" name="producto" onKeyPress="return Tabula(this, event, 0)">
							<option value=''>Todos</option>
							<option value='PD'>Diesel</option>
							<option value='93'>93</option>
							<option value='95'>95</option>
							<option value='97'>97</option>
						</SELECT>
					</td>	
				</TR>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 20%">Periodo</td>
					<td class="tabla-alycar-texto" style="width: 80%">
						<SELECT id="mes" name="mes" onKeyPress="return Tabula(this, event, 0)">
							<option value='1'>Enero</option>
							<option value='2'>Febrero</option>
							<option value='3'>Marzo</option>
							<option value='4'>Abril</option>
							<option value='5'>Mayo</option>
							<option value='6'>Junio</option>
							<option value='7'>Julio</option>
							<option value='8'>Agosto</option>
							<option value='9'>Septiembre</option>
							<option value='10'>Octubre</option>
							<option value='11'>Noviembre</option>
							<option value='12'>Diciembre</option>
						</SELECT>
						----
						<SELECT id="anio" name="anio" onKeyPress="return Tabula(this, event, 0)">
							<option value='2015'>2015</option>
							<option value='2016'>2016</option>
							<option value='2017'>2017</option>
							<option value='2018'>2018</option>
							<option value='2019'>2019</option>
						</SELECT>
						
					</td>	
				</TR>
				<!--<tr align="left">
					<td class="tabla-alycar-label" style="width: 20%">Quincena</td>
					<td class="tabla-alycar-texto" style="width: 80%">
						<SELECT id="quincena" name="quincena" onKeyPress="return Tabula(this, event, 0)">
							<option value='1'>1ra Quincena</option>
							<option value='2'>2da Quincena</option>
						</SELECT>
					</td>	
				</TR>
				-->
				
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							
							</table>
						</form>
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
										<div id='divabonos'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
	</body>
</HTML>
