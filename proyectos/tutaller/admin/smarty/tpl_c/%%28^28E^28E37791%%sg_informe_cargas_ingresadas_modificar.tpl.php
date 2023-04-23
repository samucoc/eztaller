<?php /* Smarty version 2.6.18, created on 2016-04-21 16:37:47
         compiled from sg_informe_cargas_ingresadas_modificar.tpl */ ?>
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
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
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
				$(\'#fecha\').mask("99/99/9999");
				}
			); 		
		</script>		
		<script type="text/javascript">
			$(document).ready(function() {
				var ahora = new Date() ;
				$.datepicker.regional[\'es\'] = {
					  closeText: \'Cerrar\',
					  prevText: \'<Ant\',
					  nextText: \'Sig>\',
					  currentText: \'Hoy\',
					  monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
					  monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
					  dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Mi�rcoles\', \'Jueves\', \'Viernes\', \'S�bado\'],
					  dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mi�\',\'Juv\',\'Vie\',\'S�b\'],
					  dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'S�\'],
					  weekHeader: \'Sm\',
					  dateFormat: \'dd/mm/yy\',
					  firstDay: 1,
					  isRTL: false,
					  showMonthAfterYear: false,
					  yearSuffix: \'\'};
			    	$.datepicker.setDefaults($.datepicker.regional[\'es\']);                            
				$(\'#fecha\').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy",
					  minDate: -ahora.getDate()+1
					}); 
				$("#nombre_trabajador").autocomplete({
					source : \'busquedas/busqueda_persona.php\',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById(\'trabajador\').value = rut;
						}
					});
				$("#boleta").change(function(){
					var tipo  = $("#boleta option:selected").val();
					if (tipo==1){
						$(\'.boleta_div\').css("display","table-cell");
						}
					else{
						$(\'.boleta_div\').css("display","none");
						}
					});
				$("#patente").autocomplete({
					source : \'busquedas/busqueda_vehiculo.php\'
					});
				$("#monto").iMask({
						   type   : \'number\'
						 , decDigits   : 0
						 , decSymbol   : \'\'
						 , groupSymbol : \'.\'
				 });
				
				}); 
				function replaceAll( text, busca, reemplaza ){
						while (text.toString().indexOf(busca) != -1)
							text = text.toString().replace(busca,reemplaza);
						return text;
					  } 
				function verificaValor(temp){
                            if (temp==\'\'){
                                document.getElementById(\'trabajador\').value="";
                                }
                            }   
		</script>
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresi�n.");
				  
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
				 // A�ade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el c�digo en PHP
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
									<td style="width: 7%" align='right'><img width="48" height="48" src="../images/SURTIDOR GASOIL 2.bmp"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Modificar Carga y Devoluciones de Combustible a Vehiculo</label>
									<input type="hidden" id="ncorr" name="ncorr" value='<?php echo $this->_tpl_vars['ncorr']; ?>
'> </input>
									</td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Carga:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                        <select id="tipo" name="tipo" onKeyPress="return SoloNumeros(this, event, 0)" >
                                        	<option id="" value="1">Normal</option>
                                        	<option id="" value="2">Extra</option>
                                        	<option id="" value="5">Reversa de Consumo</option>
                                        	<option id="" value="6">Devoluciones de Asignacion</option>
                                        	<option id="" value="7">Reversa de Asignacion</option>
                                        </select>
                                     </td>	
                                     </tr>
				     <tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Boleta:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                        <select id="boleta" name="boleta" onKeyPress="return SoloNumeros(this, event, 0)" >
	<option value="0">Sin Boleta</option>
	<option value="1">Con Boleta</option>
	
</select>
                                     </td>	
                                    <td class="boleta_div tabla-alycar-label" style="display:none; width: 15%">
                                        Numero Boleta:<label class="requerido"> * </label>
                                    </td>
                                    <td class="boleta_div tabla-alycar-texto" style="display:none;">
                                            <input type="text" id="nro_boleta" name="nro_boleta" onKeyPress="return SoloNumeros(this, event, 0)" />
                                    </td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:<label class="requerido"> * </label></td>
                                    <td class="tabla-alycar-texto" style="width: 20%">
                                    	<input name="fecha" id="fecha" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="">
                                    	<input name="nombre_trabajador" id="nombre_trabajador" />
                                        <input type="hidden" name="trabajador" id="trabajador" ></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 15%">
                                    	<input id="patente" name="patente" /> 
                                    </td>	
	
								</tr>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Monto:<label class="requerido"> * </label></td>
					<td class="tabla-alycar-texto" >
						<INPUT type="text" id="monto" name="monto"  onKeyPress="return SoloNumeros(this, event, 0)" value="<?php echo $this->_tpl_vars['carga_monto']; ?>
" />
					</td>
				                </tr>
				
								<tr>
                                	<td class="tabla-alycar-label" style="width: 15%">Observacion :</td>
									<td colspan="3" class="tabla-alycar-texto" style="">
                                       <textarea name="observacion" cols="50" rows="5" id="observacion"></textarea>
                                  </td>	
                                </tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
    
    <input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
   									&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
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