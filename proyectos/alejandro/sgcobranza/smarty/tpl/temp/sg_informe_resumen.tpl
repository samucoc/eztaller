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
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
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
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
		
		{literal}
		
		<script type="text/javascript">
			$(function($) { 
				$('#OBLItxtFecha1').mask("99/99/9999");
				$('#OBLItxtFecha2').mask("99/99/9999");
				$("#OBLIcboPersona").autocomplete({
                                source : 'busquedas/busqueda_persona.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLItxtCodCobrador').value = rut;
                                    }
                                });
				}
			); 		
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
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Search files-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Informe Resumen</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
																<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="OBLIcboPersona" id="OBLIcboPersona" value="" onchange="verificaValor(this.value)" size="50"/>
                                        <input type="hidden" name="OBLItxtCodCobrador" id="OBLItxtCodCobrador"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLItxtFecha1" name="OBLItxtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10" />
									    al
                                        <INPUT type="text" id="OBLItxtFecha2" name="OBLItxtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10" />
									</td>	
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
								</tr>
							
							</table>
							<div id='divlistado' style="display: none;">
								<table class="tabla-alycar" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr align="left">
                                    	<td class="tabla-alycar-label" colspan="2">Informe Resumen</td>
									</tr>
                                    <tr align="left">
										<td class="tabla-alycar-label" style="width: 15%">Trabajador</td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="trabajador"></div>
										</td>									
                                    </TR>
                                    <tr align="left">
										<td class="tabla-alycar-label" style="width: 15%">Anticipo</td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="anticipo"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_1"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_cob_sup"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_2"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_cob_co"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_pie_vendedor"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_pie_vendedor"></div>
										</td>									
                                    </TR> 
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_ae"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_ae"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_vpv"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_vpv"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_ae_1"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_ae_1"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_cv"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_cv"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_vc"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_vc"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_m"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_m"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_sv"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_sv"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_o"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_o"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_cp"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_cp"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_ft"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_ft"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_pc"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_pc"></div>
										</td>									
                                    </TR>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 15%"><div id="texto_total"></div></td>
										<td class="tabla-alycar-texto" style="width: 85%"><div id="total_total"></div>
										</td>									
                                    </TR>
								</table>
							</div>	
						</form>
					</td>
				</tr>
				<tr>
					<td>
						<div id="divbotones" align="left" style="margin:0px; padding: 0px;">
								<table class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
									<tr>
                                        <td colspan='16' class="grilla-tab-fila-titulo">
                                            <!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
                                            <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divlistado');">
                                                    <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                                                    <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                                                    <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
                                        </td>
                                    </tr>
								</table>
						</div>
					</td>
				</tr>
			</table>
		</div>		
		
	</body>
</HTML>
