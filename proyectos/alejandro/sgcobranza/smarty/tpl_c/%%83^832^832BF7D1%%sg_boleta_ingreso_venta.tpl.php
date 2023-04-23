<?php /* Smarty version 2.6.18, created on 2013-04-01 16:32:37
         compiled from sg_boleta_ingreso_venta.tpl */ ?>
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
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>
		<?php echo '
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLI-txtFecha\').mask("99/99/9999");
				}
			); 		
		</script>		
		<script type="text/javascript">
			$(document).ready(function() { 
                            $.datepicker.regional[\'es\'] = {
                                  closeText: \'Cerrar\',
                                  prevText: \'<Ant\',
                                  nextText: \'Sig>\',
                                  currentText: \'Hoy\',
                                  monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
                                  monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
                                  dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Miércoles\', \'Jueves\', \'Viernes\', \'Sábado\'],
                                  dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mié\',\'Juv\',\'Vie\',\'Sáb\'],
                                  dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sá\'],
                                  weekHeader: \'Sm\',
                                  dateFormat: \'dd/mm/yy\',
                                  firstDay: 1,
                                  isRTL: false,
                                  showMonthAfterYear: false,
                                  yearSuffix: \'\'};
                           $.datepicker.setDefaults($.datepicker.regional[\'es\']);                            
                            $(\'#OBLI-txtFecha\').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                }); 
                            $(\'#OBLI-txtFecha\').on(\'blur\', function(){
								});
							$("#cboPersona").autocomplete({
                                source : \'busquedas/busqueda_persona.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'OBLI-txtCodCobrador\').value = rut;
                                    $.ajax({
                                        url:\'busquedas/busqueda_cupo_x_rut.php?patente=\'+rut,
                                        success: function(data){
                                            document.getElementById(\'OBLItxtMontoDisponible\').value = data;
                                            document.getElementById(\'oculto_OBLItxtMontoDisponible\').value = data;
                                            }
                                        });
                                    }
                                });
                            $("#OBLIempresa").autocomplete({
                                source : \'busquedas/busqueda_empresa.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
									var valor = ui.item.value;
                                    document.getElementById(\'nombre_empresa\').value = valor;
                                    document.getElementById(\'rut_empresa\').value = rut;
									}
                                });								
                            $("#cboPatente").autocomplete({
                                source : \'busquedas/busqueda_vehiculo.php\',
                                select: function( event, ui ) {
                                    var patente = ui.item.value;
                                    $.ajax({
                                        url:\'busquedas/busqueda_rut_x_patente.php?patente=\'+patente,
                                        success: function(data){
                                            document.getElementById(\'pers_asig\').value = data;
                                            }
                                        });
                                    }
                                });
                            $("#OBLItxtMontoIngresar, #OBLItxtMontoDisponible").iMask({
                                       type   : \'number\'
                                     , decDigits   : 0
                                     , decSymbol   : \'\'
                                     , groupSymbol : \'.\'
                             });
                            $("#OBLItxtMontoIngresar").blur(function(){
                                    var valor1 = $("#OBLItxtMontoIngresar").val();
                                    valor1=replaceAll(valor1, ".", "" );
                                    var valor2 = $("#oculto_OBLItxtMontoDisponible").val();
                                    var valor_entregar = valor2-valor1;
                                    document.getElementById("OBLItxtMontoDisponible").value = valor_entregar;
                                  });
                            }); 
                            function replaceAll( text, busca, reemplaza ){
                                    while (text.toString().indexOf(busca) != -1)
                                        text = text.toString().replace(busca,reemplaza);
                                    return text;
                                  }    
		</script>
		<script type="text/javascript" > 
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

		'; ?>

	
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
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingreso de Boleta</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa:</td>
									<td class="tabla-alycar-texto" style="width: 20%">
                                        <input name="OBLIempresa" type="text" id="OBLIempresa" value="<?php echo $this->_tpl_vars['nombre_empresa']; ?>
" size="50"/>
                                        <input type="hidden" id="nombre_empresa" name="nombre_empresa"  value="<?php echo $this->_tpl_vars['nombre_empresa']; ?>
"/>
                                        <input type="hidden" id="rut_empresa" name="rut_empresa"  value="<?php echo $this->_tpl_vars['empresa']; ?>
"/>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Boleta:</td>
									<td class="tabla-alycar-texto" style="width: 15%">
                                     	<input id="boleta" name="boleta"  /> 
                                                                        </td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:</td>
                                	<td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="OBLI-txtFecha" name="OBLI-txtFecha" onKeyPress="return SoloNumeros(this, event, 0)"  />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Mes Contable:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										Mes:
										<SELECT id="cboMes" name="cboMes" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
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
										&nbsp;&nbsp;
										Año:
										<SELECT id="cboAnio" name="cboAnio" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='2011'>2011</option>
											<option value='2012'>2012</option>
											<option value='2013'>2013</option>
											<option value='2014'>2014</option>
											<option value='2015'>2015</option>
											<option value='2016'>2016</option>
										</SELECT>
										
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto:</td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar"  onKeyPress="return SoloNumeros(this, event, 0)">
									</td>
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>		
	</body>
</HTML>