<?php /* Smarty version 2.6.18, created on 2013-08-13 16:46:58
         compiled from sg_nota_debito_ingreso.tpl */ ?>
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
							$("#OBLIcliente").autocomplete({
                                source : \'busquedas/busqueda_proveedor.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'rut_cliente\').value = rut;
									}
                                });
                            $("#OBLItxtMontoIngresar").iMask({
                                       type   : \'number\'
                                     , decDigits   : 0
                                     , decSymbol   : \'\'
                                     , groupSymbol : \'.\'
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
                            $("#OBLItxtMontoIngresar").blur(function(){
                                    var valor1 = $("#OBLItxtMontoIngresar").val();
                                    valor1=replaceAll(valor1, ".", "" );
                                    var iva = parseInt(valor1)*0.19;
									document.getElementById(\'iva\').value = Math.round(iva);
									var total = parseInt(valor1)*1.19;
									document.getElementById(\'total\').value = Math.round(total);
                                  });
							$("#mant").click(function(){
								xajax_LlamaMantenedorVxC(xajax.getFormValues(\'Form1\'));
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingreso de Nota de Debito</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							  <tr align="left">
							    <td class="tabla-alycar-label" style="width: 15%">Empresa:</td>
							    <td class="tabla-alycar-texto" style="width: 20%"><input name="OBLIempresa" type="text" id="OBLIempresa" value="<?php echo $this->_tpl_vars['nombre_empresa']; ?>
" size="50"/>
									<input type="hidden" id="nombre_empresa" name="nombre_empresa"  value="<?php echo $this->_tpl_vars['nombre_empresa']; ?>
"/>
									<input type="hidden" id="rut_empresa" name="rut_empresa"  value="<?php echo $this->_tpl_vars['empresa']; ?>
"/></td>
						      </tr>
							  <tr align="left">
							    <td class="tabla-alycar-label" style="width: 15%">Fecha:</td>
							    <td class="tabla-alycar-texto" style="width: 20%"><input type="text" id="OBLI-txtFecha" name="OBLI-txtFecha" onkeypress="return SoloNumeros(this, event, 0)" value="<?php echo $this->_tpl_vars['fecha']; ?>
"/></td>
						      </tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Proveedor:</td>
									<td class="tabla-alycar-texto" style="width: 20%">
									  	<input name="OBLIcliente" type="text" id="OBLIcliente" size="50" value="<?php echo $this->_tpl_vars['cliente']; ?>
" />
										<input type="hidden" id="rut_cliente" name="rut_cliente"  value="<?php echo $this->_tpl_vars['rut']; ?>
"/>
                                        <input type="button" name="mant" id="mant" onclick="" value="Mantenedor Proveedor" class="boton"/>
									</td>	 
								</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Nro Nota Debito: </td>
								  <td class="tabla-alycar-texto" style="width: 15%"><input id="OBLI_nd" name="OBLI_nd"  size="50" value="" /></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Nro Factura Asociada: </td>
								  <td class="tabla-alycar-texto" style="width: 15%"><input id="OBLIboleta" name="OBLIboleta"  size="50" value="<?php echo $this->_tpl_vars['nro_factura']; ?>
" /></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Neto:</td>
								  <td class="tabla-alycar-texto" ><input type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar"  onkeypress="return SoloNumeros(this, event, 0)"  size="50" value="<?php echo $this->_tpl_vars['neto']; ?>
"/></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Iva:</td>
								  <td class="tabla-alycar-texto" ><input type="text" id="iva" name="iva"  onkeypress="return SoloNumeros(this, event, 0)" size="50" readonly="readonly" style="text-align:right" value="<?php echo $this->_tpl_vars['iva']; ?>
"/></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Total:</td>
								  <td class="tabla-alycar-texto" ><input type="text" id="total" name="total"  onkeypress="return SoloNumeros(this, event, 0)"  size="50" readonly="readonly" style="text-align:right" value="<?php echo $this->_tpl_vars['total']; ?>
"/></td>
							  </tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Observacion:</td>
								  <td class="tabla-alycar-texto" >
                                  	<textarea id="observacion" name="observacion" cols="50" rows="5"></textarea>
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