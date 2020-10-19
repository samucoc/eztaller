<?php /* Smarty version 2.6.18, created on 2019-11-19 20:58:31
         compiled from sg_alumnos_cobranza_pago.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
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
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        
		<?php echo '
                <script type="text/javascript">
			$(function($) { 
				$(\'#fecha_pago\').mask("99/99/9999");
				$(\'#fecha_cheque\').mask("99/99/9999");
				$("#tr_cheque_1").hide();
				$("#tr_cheque_2").hide();
				}
			); 		
		</script>
		<script type="text/javascript">
			$(document).ready(function() { 
					$("#btnPagar").click(function(){
						$("#btnPagar").attr("disabled", true);
					});
					
					$("#forma_pago").change(function(){
						var forma_pago = $("#forma_pago option:selected").val();
						if (forma_pago == \'2\'){
							$("#tr_cheque_1").show();
							$("#tr_cheque_2").show();
							}
						else{
							$("#tr_cheque_1").hide();
							$("#tr_cheque_2").hide();
							}
						});
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
                            $(\'#fecha_pago,#fecha_cheque\').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : \'busquedas/busqueda_alumno.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'OBLIRutAlumno\').value = rut;
                                    }
                                });
                 $(\'#btnAgregarCheque\').click(function(){
					var nro_cheque = $("#nro_cheque").val(); 
					var banco_cheque = $("#banco_cheque option:selected").val(); 
					var banco_cheque_2 = $("#banco_cheque option:selected").text(); 
					var fecha_cheque = $(\'#fecha_cheque\').val();
					var valor_cheque = $("#valor_cheque").val(); 
					var id_repuesto = "";
					if ((nro_cheque!=\'\')&&(banco_cheque!=\'\')&&(fecha_cheque!=\'\')&&(valor_cheque!=\'\')){
						str = \'<tr id="presu_\'+nro_cheque+\'" align="left"><td class="tabla-alycar-texto" width="40%"><input type="hidden" name="id_repuesto_ant" id="id_repuesto_ant_\'+nro_cheque+\'" value="\'+nro_cheque+\'" />\'+nro_cheque+\' </td><td class="tabla-alycar-texto" width="15%">\'+banco_cheque_2+\'</td><td class=" tabla-alycar-texto" width="15%">\'+fecha_cheque+\'</td><td class="tabla-alycar-texto" width="15%"><input type="hidden" name="vt_ant" id="vt_ant_\'+nro_cheque+\'" value="\'+valor_cheque+\'"/>\'+valor_cheque+\'</td><td class="tabla-alycar-texto" width="15%"><a href="#" onclick="borrarFila(\'+nro_cheque+\'); return false">Eliminar</a></td></tr>\';
						//alert(str);
						$(\'#detalle\').append(str);
						$(\'#detalle\').show();
						str ="";
						//$("#btnGrabar").show();
						if (document.getElementById("arr_repuesto").value!=\'\') {
							if (nro_cheque!=\'\'){
								document.getElementById("arr_repuesto").value = document.getElementById("arr_repuesto").value +\',\'+nro_cheque;
								}
							else{
								document.getElementById("arr_repuesto").value = document.getElementById("arr_repuesto").value +\',\'+nro_cheque;	
								}
								}
						else
							{
							if (nro_cheque!=\'\'){
								document.getElementById("arr_repuesto").value = nro_cheque;
								}
							else{
								document.getElementById("arr_repuesto").value = nro_cheque;	
								}
							}
						
						if (document.getElementById("arr_nom_repuesto").value!=\'\') 
							document.getElementById("arr_nom_repuesto").value = document.getElementById("arr_nom_repuesto").value +\',\'+banco_cheque;
						else
							document.getElementById("arr_nom_repuesto").value = banco_cheque;
							
						if (document.getElementById("arr_cant").value!=\'\') 
							document.getElementById("arr_cant").value = document.getElementById("arr_cant").value +\',\'+fecha_cheque;
						else
							document.getElementById("arr_cant").value = fecha_cheque;
						
						if (document.getElementById("arr_pu").value!=\'\') 
							document.getElementById("arr_pu").value = document.getElementById("arr_pu").value +\',\'+valor_cheque;
						else
							document.getElementById("arr_pu").value = valor_cheque;
		
						if (document.getElementById("arr_vt").value!=\'\') 
							document.getElementById("arr_vt").value= document.getElementById("arr_vt").value +\',\'+valor_cheque;
						else
							document.getElementById("arr_vt").value= valor_cheque;
			
						var arr  = document.getElementById("arr_vt").value.split(",");
						}
					});	
           });
			function borrarFila(indice){
				
				var id_repuesto = document.getElementById("id_repuesto_ant_" + indice).value;
				
				var arr  = document.getElementById("arr_repuesto").value.split(",");
				var posBorrar=arr.indexOf(id_repuesto);
				arr.splice(posBorrar, 1);
				document.getElementById("arr_repuesto").value = arr.join(",");
				
				var arr  = document.getElementById("arr_pu").value.split(",");
				arr.splice(posBorrar, 1);
				document.getElementById("arr_pu").value = arr.join(",");
				
				var arr  = document.getElementById("arr_nom_repuesto").value.split(",");
				arr.splice(posBorrar, 1);
				document.getElementById("arr_nom_repuesto").value = arr.join(",");
				
				var arr  = document.getElementById("arr_cant").value.split(",");
				arr.splice(posBorrar, 1);
				document.getElementById("arr_cant").value = arr.join(",");
				
				var arr  = document.getElementById("arr_vt").value.split(",");
				arr.splice(posBorrar, 1);
				document.getElementById("arr_vt").value = arr.join(",");
				
				$("#presu_" + indice).remove();
				}	            
		</script>
		<script type="text/javascript" > 
            
			function verificaValor(temp){
                            if (temp==\'\'){
                                document.getElementById(\'OBLI-txtCodCobrador\').value="";
                                }
                            }
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
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

		'; ?>

	
	</HEAD>
	<body onload="xajax_CargaListado(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr>
                                    <td class="grilla-tab-fila-titulo" align='center' width="50%" ><label class="form-titulo">&nbsp;&nbsp;Ingresar Pago</label>
                                    </td>
                                    <td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                    	<input type="text" name="nro_boleta" id="nro_boleta" 
                                        	style="font-size:30px; color:#0C0; text-align:right" width="10" size="10" 
                                        	onchange="xajax_BuscaBoleta(xajax.getFormValues('Form1'));" />
                                    </td>
								</tr>
                                <tr align="left" valign="middle">
									<td style="width: 7%" align='right'>
                                    
                                    </td>
                                    <input type="hidden" name="OBLIRutAlumno" id="OBLIRutAlumno" value="<?php echo $this->_tpl_vars['rut_alumno']; ?>
"/>
	                                <input type="hidden" id="arr_repuesto" name="arr_repuesto"/>
                                    <input type="hidden" id="arr_nom_repuesto" name="arr_nom_repuesto"/>
                                    <input type="hidden" id="arr_pu" name="arr_pu"/>
                                    <input type="hidden" id="arr_cant" name="arr_cant"/>
                                    <input type="hidden" id="arr_vt" name="arr_vt"/>
                                </tr>
							</table>
							<br>
							<table class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr>
                                	<td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
                                    <td class="grilla-tab-fila-campo" align='left' colspan="3" id="apoderado">
                                        
                                    </td>
                                </tr>						
								<tr>
                                	<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
                                    <td class="grilla-tab-fila-campo" align='left' colspan="3" id="alumno">
                                    </td>
                                </tr>						
								<tr>
                                	<td class="grilla-tab-fila-titulo" align='center'>Curso</td>
                                    <td class="grilla-tab-fila-campo" align='left' colspan="3" id="curso">
                                    </td>
                                </tr>						
								<tr>
                                	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <input type="text" name="fecha_pago" id="fecha_pago" />
                                    </td>
                                	<td class="grilla-tab-fila-titulo" align='center'>Valor a Pagar </td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <input type="text" name="valor_pagar" id="valor_pagar" 
                                        	style="font-size:30px; text-align:right"
                                        	/>
                                    </td>
                                </tr>
                                <tr>
                                	<td class="grilla-tab-fila-titulo" align='center'>Forma Pago</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <select id="forma_pago" name="forma_pago">
                                        	<option value="1">Efectivo</option>
                                        	<option value="2">Cheque a Fecha</option>
                                        	<option value="3">Transferencia</option>
                                        	<option value="4">Descuento por planilla</option>
                                        	<option value="5">TransBank</option>
                                        	<option value="6">Cheque Al Dia</option>
                                        </select>
                                    </td>
                                </tr>						
                                <tr id="tr_cheque_1">
                                	<td class="grilla-tab-fila-titulo" align='center'>Nro Cheque</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <input type="text" name="nro_cheque" id="nro_cheque" value=""/>
                                    </td>
                                	<td class="grilla-tab-fila-titulo" align='center'>Banco</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <select name="banco_cheque" id="banco_cheque" >
                                        </select>
                                    </td>
                                </tr>
                                <tr id="tr_cheque_2">
                                	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <input type="text" name="fecha_cheque" id="fecha_cheque" value=""/>
                                    </td>
                                	<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
                                    <td class="grilla-tab-fila-campo" align='left'>
                                        <input type="text" name="valor_cheque" id="valor_cheque" /> 
                                        <input type="button" class="boton" value="Agregar Cheque" id="btnAgregarCheque" name="btnAgregarCheque" />
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="4">
                            			<table class="grilla-tab" cellpadding="0" cellspacing="0" style="width: 100%" id="detalle">
							        	</table>
                                    </td>
                                </tr>
                                <tr>
                                	<td  class="grilla-tab-fila-campo" align='left' colspan="4">
                            			<input type="button" class="boton" value="Registrar Pago" id="btnPagar" name="btnPagar" onclick="xajax_Pagar(xajax.getFormValues('Form1'));"/>
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