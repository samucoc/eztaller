<?php /* Smarty version 2.6.18, created on 2016-03-17 17:47:21
         compiled from sg_vehiculos_ingresar_carga.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_vehiculos_ingresar_carga.tpl', 321, false),)), $this); ?>
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
				$(\'#OBLI-txtFecha\').mask("99/99/9999");
				}
			); 		
		</script>		
		<script type="text/javascript">
			$(document).ready(function() {
				var ahora = new Date() ;
				if ($("#carga_veh").val()!=\'\'){
					var patente = $("#carga_veh").val();
					$.ajax({
						url:\'busquedas/busqueda_rut_x_patente.php?patente=\'+patente,
						success: function(data){
							document.getElementById(\'pers_asig\').innerHTML = data;
							document.getElementById(\'pa_oculto\').value = data;
							}
						});
					document.getElementById(\'OBLI-txtCodCobrador\').value = $("#carga_pers").val();
					$.ajax({
						url:\'busquedas/buscar_cupo_persona.php?rut=\'+$("#carga_pers").val(),
						success: function(data){
							document.getElementById(\'cupo_asignado\').innerHTML = data;
							}
						});
					$.ajax({
						url:\'busquedas/busqueda_cupo_x_rut.php?patente=\'+$("#carga_pers").val(),
						success: function(data){
							document.getElementById(\'cupo_asignado\').innerHTML = data;
							document.getElementById(\'oculto_OBLItxtMontoDisponible\').value = data;
							/*
							var valor1 = $("#OBLItxtMontoIngresar").val();
							valor1=replaceAll(valor1, ".", "" );
							var valor2 = $("#oculto_OBLItxtMontoDisponible").val();
					
							var valor_entregar  =0;
							valor_entregar = valor2-valor1;
							document.getElementById("monto-cargado").innerHTML = valor_entregar;
							document.getElementById("cargado_oculto").value = valor_entregar;
							*/
							xajax_RestarConsumo(xajax.getFormValues(\'Form1\'),data,$("#OBLItxtMontoIngresar").val())	;
							}
						});
					}
				$("#cboBoleta").change(function(){
					var tipo  = $("#cboBoleta option:selected").val();
					if (tipo==1){
						$(\'.boleta_div\').css("display","table-cell");
						}
					else{
						$(\'.boleta_div\').css("display","none");
						}
					});
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
				$(\'#OBLI-txtFecha\').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy",
					  minDate: -ahora.getDate()+1
					}); 
				$("#cboPersona").autocomplete({
					source : \'busquedas/busqueda_persona.php\',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById(\'OBLI-txtCodCobrador\').value = rut;
						$.ajax({
							url:\'busquedas/busqueda_cupo_x_rut.php?patente=\'+rut,
							success: function(data){
								document.getElementById(\'OBLItxtMontoDisponible\').innerHTML = data;
								document.getElementById(\'oculto_OBLItxtMontoDisponible\').value = data;
								}
							});
						$.ajax({
							url:\'busquedas/busqueda_patente_x_rut.php?rut=\'+rut,
							success: function(data){
								document.getElementById(\'cboPatente\').value = data;
								$.ajax({
									url:\'busquedas/busqueda_rut_x_patente.php?patente=\'+data,
									success: function(data){
										document.getElementById(\'pers_asig\').innerHTML = data;
										document.getElementById(\'pa_oculto\').value = data;
										}
									});
						$.ajax({
							url:\'busquedas/buscar_cupo_persona.php?rut=\'+rut,
							success: function(data){
								document.getElementById(\'cupo_asignado\').innerHTML = data;
								var valor1 = $("#oculto_OBLItxtMontoDisponible").val();
								valor1=replaceAll(valor1, ".", "" );
								var valor2 = data;

								var sel = $("#cboCarga option:selected").val();
								var valor_entregar  =0;
								if ((sel==1)||(sel==4)){
									valor_entregar = valor2-valor1;
									}
								else{
									valor_entregar = valor2;
									}
								document.getElementById("monto-cargado").innerHTML = valor_entregar;
								document.getElementById("cargado_oculto").value = valor_entregar;			
								}
							});
						$.ajax({
							url:\'busquedas/busqueda_empresa_x_patente.php?patente=\'+data,	
							success: function(data){
								var arr = data.split(\'_\');
								document.getElementById(\'empresa_patente\').innerHTML = arr[0];
								document.getElementById(\'comb_veh\').innerHTML = arr[1];
									}
								});
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
								document.getElementById(\'pers_asig\').innerHTML = data;
								document.getElementById(\'pa_oculto\').value = data;
								}
							});
						}
					});
				$("#OBLItxtMontoIngresar").iMask({
						   type   : \'number\'
						 , decDigits   : 0
						 , decSymbol   : \'\'
						 , groupSymbol : \'.\'
				 });
				$("#OBLItxtMontoIngresar").blur(function(){
						
						var valor1 = $("#OBLItxtMontoIngresar").val();
						valor1=replaceAll(valor1, ".", "" );
						var valor2 = document.getElementById("cupo_asignado").innerHTML;
						
						var sel = $("#cboCarga option:selected").val();
						var valor_entregar  =0;

						if ((sel==1)||(sel==4)){
							valor_entregar = (parseInt(valor2)-parseInt(valor1));
							}
						else{
							valor_entregar = valor2;
							}
						
						document.getElementById("monto-cargado").innerHTML = valor1;
						document.getElementById("cargado_oculto").value = valor1;

						document.getElementById(\'OBLItxtMontoDisponible\').innerHTML = valor_entregar;
						document.getElementById(\'oculto_OBLItxtMontoDisponible\').value = valor_entregar;
					  });
				$("#cboCarga").change(function(){
						var valor1 = $("#OBLItxtMontoIngresar").val();
						valor1=replaceAll(valor1, ".", "" );
						var valor2 = document.getElementById("cupo_asignado").innerHTML;
						
						var sel = $("#cboCarga option:selected").val();
						var valor_entregar  =0;

						if ((sel==1)||(sel==4)){
							valor_entregar = (parseInt(valor2)-parseInt(valor1));
							}
						else{
							valor_entregar = valor2;
							}
						
						document.getElementById("monto-cargado").innerHTML = valor1;
						document.getElementById("cargado_oculto").value = valor1;

						document.getElementById(\'OBLItxtMontoDisponible\').innerHTML = valor_entregar;
						document.getElementById(\'oculto_OBLItxtMontoDisponible\').value = valor_entregar;
					  
					});
				}); 
				function replaceAll( text, busca, reemplaza ){
						while (text.toString().indexOf(busca) != -1)
							text = text.toString().replace(busca,reemplaza);
						return text;
					  } 
				function verificaValor(temp){
                            if (temp==\'\'){
                                document.getElementById(\'OBLI-txtCodCobrador\').value="";
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingresar Carga y Devoluciones de Combustible a Vehiculo</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Carga:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                        <select id="cboCarga" name="cboCarga" onKeyPress="return SoloNumeros(this, event, 0)" ></select>
                                     </td>	
                                     </tr>
				     <tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Boleta:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                        <select id="cboBoleta" name="cboBoleta" onKeyPress="return SoloNumeros(this, event, 0)" >
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
										<INPUT type="text" id="OBLI-txtFecha" name="OBLI-txtFecha"  onKeyPress="return SoloNumeros(this, event, 0)" value="<?php if (( $this->_tpl_vars['carga_fecha'] == '' )): ?>
																																							<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
 
																																							<?php else: ?> 
																																							<?php echo $this->_tpl_vars['carga_fecha']; ?>

																																							<?php endif; ?>" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="">
                                    	<input name="cboPersona" id="cboPersona" value="<?php echo $this->_tpl_vars['CARGA_NOM_PERS']; ?>
" onblur="verificaValor(this.value)"/>
                                        <input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador" value="<?php echo $this->_tpl_vars['carga_pers']; ?>
"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 15%">
                                    	<input id="cboPatente" name="cboPatente" value="<?php echo $this->_tpl_vars['carga_veh']; ?>
"  /> 
                                    </td>	
									<td class="tabla-alycar-label" style="width: 15%">Trabajador Asignada</td>
									<td class="tabla-alycar-texto" style="width: 15%">
									    <div name="pers_asig" id="pers_asig" style="float: Left;"><?php echo $this->_tpl_vars['pers_asig']; ?>
</div>
									    <input type="hidden" name="pa_oculto" id="pa_oculto" value="<?php echo $this->_tpl_vars['pers_asig']; ?>
"/>
                                        <input type="button" name="btnActualizar" value="+" class="boton"  style="float: right;margin-left:20px" onclick="xajax_LlamaMantenedorVxC(xajax.getFormValues('Form1'));" />
                                        <br style="clear:both"/>
									</td>	
								</tr>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Monto:<label class="requerido"> * </label></td>
					<td class="tabla-alycar-texto" >
						<INPUT type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar"  onKeyPress="return SoloNumeros(this, event, 0)" value="<?php echo $this->_tpl_vars['carga_monto']; ?>
" />
					</td>
					<td class="tabla-alycar-label" style="width: 15%">Cupo Asignado</td>
					<td class="tabla-alycar-texto" >
						<div id="cupo_asignado" style="float: Left;"></div>
                                		<input type="button" name="btnActualizar_1" value="+" class="boton"  style="float: right; margin-left:20px" onclick="xajax_LlamaMantenedorAxC(xajax.getFormValues('Form1'));" />
                                    </td>	
                                </tr>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Rut - Empresa<label class="requerido"> * </label></td>
					<td class="tabla-alycar-texto" >
						<div id="empresa_patente"></div>
					</td>
					<td class="tabla-alycar-label" style="width: 15%">Cupo Cargado</td>
					<td class="tabla-alycar-texto" >
						<div id="monto-cargado" style="float: Left;"><?php echo $this->_tpl_vars['monto_dispo']; ?>
</div>
						<input type="hidden" id="cargado_oculto" name="cargado_oculto"value="<?php echo $this->_tpl_vars['monto_dispo']; ?>
" readonly/>					</td>
                                </tr>
				<tr align="left">
					<td class="tabla-alycar-label" style="width: 15%">Combustible Vehiculo</td>
					<td class="tabla-alycar-texto" >
						<div id="comb_veh"></div>
		                        </td>	
					<td class="tabla-alycar-label" style="width: 15%">Cupo Disponible</td>
					<td class="tabla-alycar-texto" >
						<div id="OBLItxtMontoDisponible"><?php echo $this->_tpl_vars['cargado']; ?>
</div>
						<input type="hidden" name="oculto_OBLItxtMontoDisponible" id="oculto_OBLItxtMontoDisponible" />
                    </td>	
                </tr>
								<tr>
                                	<td class="tabla-alycar-label" style="width: 15%">Observacion :</td>
									<td colspan="3" class="tabla-alycar-texto" style="">
                                       <textarea name="carga_observacion" cols="50" rows="5" id="carga_observacion"></textarea>
                                  </td>	
                                </tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
    <input type="hidden" name="carga_veh" id="carga_veh" value="<?php echo $this->_tpl_vars['carga_veh']; ?>
"/>
    <input type="hidden" name="carga_nom_pers" id="carga_nom_pers" value="<?php echo $this->_tpl_vars['carga_nom_pers']; ?>
r"/>
    <input type="hidden" name="carga_pers" id="carga_pers" value="<?php echo $this->_tpl_vars['carga_pers']; ?>
"/>
    <input type="hidden" name="carga_monto" id="carga_monto" value="<?php echo $this->_tpl_vars['carga_monto']; ?>
"/>
    <input type="hidden" name="carga_fecha" id="carga_fecha" value="<?php echo $this->_tpl_vars['carga_fecha']; ?>
"/>
    <input type="hidden" name="pers_asig" id="pers_asig" value="<?php echo $this->_tpl_vars['pers_asig']; ?>
"/>
    <input type="hidden" name="monto_dispo" id="monto_dispo" value="<?php echo $this->_tpl_vars['monto_dispo']; ?>
"/>
    <input type="hidden" name="cargado" id="cargado" value="<?php echo $this->_tpl_vars['cargado']; ?>
"/>
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