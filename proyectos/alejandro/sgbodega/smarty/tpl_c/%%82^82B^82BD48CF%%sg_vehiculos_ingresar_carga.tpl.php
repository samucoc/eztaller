<?php /* Smarty version 2.6.18, created on 2013-02-01 14:32:56
         compiled from sg_vehiculos_ingresar_carga.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_vehiculos_ingresar_carga.tpl', 200, false),)), $this); ?>
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
                                  dateFormat : "dd/mm/yy",
                                  minDate: -2, 
                                  maxDate: +2
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingresar Carga de Combustible a Vehiculo</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="">
                                                                            <input name="cboPersona" id="cboPersona" value="<?php echo $this->_tpl_vars['CARGA_NOM_PERS']; ?>
"  />
                                                                            <input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador" value="<?php echo $this->_tpl_vars['carga_pers']; ?>
"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 15%">
                                                                            <input id="cboPatente" name="cboPatente" value="<?php echo $this->_tpl_vars['carga_veh']; ?>
" > 
                                                                        </td>	
									<td class="tabla-alycar-label" style="width: 15%">Persona Asignada</td>
									<td class="tabla-alycar-texto" >
									    <input type="text" name="pers_asig" id="pers_asig" value="" readonly/>
                                                                            <input type="button" name="btnActualizar" value="Asigancion de Vehiculo" class="boton"  onclick="xajax_LlamaMantenedorVxC(xajax.getFormValues('Form1'));" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar" value='' onKeyPress="return SoloNumeros(this, event, 0)" value="<?php echo $this->_tpl_vars['carga_monto']; ?>
">
									</td>
									<td class="tabla-alycar-label" style="width: 15%">Cupo Disponible</td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoDisponible" name="OBLItxtMontoDisponible" value='' onKeyPress="return SoloNumeros(this, event, 0)"  readonly/>
                                                                                <input type="hidden" name="oculto_OBLItxtMontoDisponible" id="oculto_OBLItxtMontoDisponible" value="" readonly/>
                                                                        </td>	
                                                                        								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:<label class="requerido"> * </label></td>
                                                                        <td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="OBLI-txtFecha" name="OBLI-txtFecha" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' onKeyPress="return SoloNumeros(this, event, 0)" value="<?php echo $this->_tpl_vars['carga_fecha']; ?>
" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Carga:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                                                                <select id="cboCarga" name="cboCarga" onKeyPress="return SoloNumeros(this, event, 0)" ></select>
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