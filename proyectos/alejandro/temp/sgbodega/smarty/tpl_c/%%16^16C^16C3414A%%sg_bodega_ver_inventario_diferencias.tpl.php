<?php /* Smarty version 2.6.18, created on 2017-04-27 11:05:09
         compiled from sg_bodega_ver_inventario_diferencias.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Toma Inventario </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- estilos -->
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>

		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		 <script type="text/javascript" src="../includes_js/jquery.base64.js"></script>
		
		
		<?php echo '
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLI-txtFecha\').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript" > 
			$(document).ready(function() { 
				$( "#btnExportar" ).on(\'click\',function() {
					// var test = $(\'#divabonosTI\');
					// window.open(\'data:application/vnd.ms-excel;base64,\' + $.base64.encode(test[0].outerHTML),\'Titulo\');



					//getting values of current time for generating the file name
			        var dt = new Date();
			        var day = dt.getDate();
			        var month = dt.getMonth() + 1;
			        var year = dt.getFullYear();
			        var hour = dt.getHours();
			        var mins = dt.getMinutes();
			        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
			        //creating a temporary HTML link element (they support setting file names)
			        var a = document.createElement(\'a\');
			        //getting data from our div that contains the HTML table
			        var data_type = \'data:application/vnd.ms-excel\';
			        var table_div = document.getElementById(\'divabonos\');
			        var table_html = table_div.outerHTML.replace(/ /g, \'%20\');
			        a.href = data_type + \', \' + table_html;
			        //setting the file name
			        a.download = \'exported_table_\' + postfix + \'.xls\';
			        //triggering the function
			        a.click();
			        //just in case, prevent default behaviour
			        e.preventDefault();
					
					});
				$.datepicker.regional[\'es\'] = {
					  closeText: \'Cerrar\',
					  prevText: \'<Ant\',
					  nextText: \'Sig>\',
					  currentText: \'Hoy\',
					  monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
					  monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
					  dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Mi�rcoles\', \'Jueves\', \'Viernes\', \'Sabado\'],
					  dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mie\',\'Juv\',\'Vie\',\'Sab\'],
					  dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sa\'],
					  weekHeader: \'Sm\',
					  dateFormat: \'dd/mm/yy\',
					  firstDay: 1,
					  isRTL: false,
					  showMonthAfterYear: false,
					  yearSuffix: \'\'};
			    	$.datepicker.setDefaults($.datepicker.regional[\'es\']);                            
				$(\'#OBLItxtFecha\').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				
				});
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements[\'v_pivot_excel\'].value=document.getElementById(\'pivot\').innerHTML;
			document.getElementById(nombreformulario).target = \'iframe_pivot_excel\'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById(\'pivot\').innerHTML="";document.getElementById(\'pivot_filter\').innerHTML="";document.getElementById(\'div_grafico\').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		</script> 
		'; ?>

	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			
			<div id="divcontenedor" align="left" style="display: block; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Ver inventario con diferencias</td>
								</tr>
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Fecha:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="OBLItxtFecha" name="OBLItxtFecha"  onKeyPress="eturn SoloNumeros(this, event, 0)" />
									</td>	
								</TR>
															
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
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
										<div id='divabonos'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan='16' class="grilla-tab-fila-titulo">
							<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
							<input type="button" name="btnExportar"  id="btnExportar" value="Exportar Excel" class="boton" >
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>