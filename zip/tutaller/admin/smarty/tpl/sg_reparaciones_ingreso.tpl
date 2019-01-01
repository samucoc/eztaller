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
            <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>
		{literal}
        <script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha1,#OBLI-txtFecha2').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			var i =0;
			var str ="";
			$(document).ready(function() { 
				$("#cboPago").change(function(){
					var tipo  = $("#cboPago option:selected").val();
					if (tipo==2){
						$('.boleta_div').css("display","table-cell");
						}
					else{
						$('.boleta_div').css("display","none");
						}
					});
				$.datepicker.regional['es'] = {
					  closeText: 'Cerrar',
					  prevText: 'Ant',
					  nextText: 'Sig',
					  currentText: 'Hoy',
					  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
					  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
					  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
					  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
					  weekHeader: 'Sm',
					  dateFormat: 'dd/mm/yy',
					  firstDay: 1,
					  isRTL: false,
					  showMonthAfterYear: false,
					  yearSuffix: ''};
			   $.datepicker.setDefaults($.datepicker.regional['es']);                            
				$('#OBLI-txtFecha1, #OBLI-txtFecha2').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#OBLI-monto").iMask({
						   type   : 'number'
						 , decDigits   : 0
						 , decSymbol   : ''
						 , groupSymbol : '.'
				 });
				 $("#cboPersona").autocomplete({
					source : 'busquedas/busqueda_persona.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('OBLI-txtCodCobrador').value = rut;
						}
					});
				 $("#cboMecanico").autocomplete({
					source : 'busquedas/busqueda_mecanico.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('rut_mecanico').value = rut;
						}
					});
				 $("#repuesto").autocomplete({
					source : 'busquedas/busqueda_repuesto.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('id_repuesto').value = rut;
						}
					});
				$("#cboPatente").autocomplete({
					source : 'busquedas/busqueda_vehiculo.php',
					select: function( event, ui ) {
						var patente = ui.item.value;
						$.ajax({
							url:'busquedas/busqueda_rut_x_patente.php?patente='+patente,
							success: function(data){
								document.getElementById('pers_asig').value = data;
								document.getElementById('cboPersona').value = data;
								}
							});
						$.ajax({
							url:'busquedas/busqueda_rut_x_patente_1.php?patente='+patente,
							success: function(data){
								document.getElementById('OBLI-txtCodCobrador').value = data;
								}
							});
						}
					});
				$("#pu").iMask({
						   type   : 'number'
						 , decDigits   : 0
						 , decSymbol   : ''
						 , groupSymbol : '.'
				 });
				$("#cant, #pu").blur(function(){
						var valor1 = $("#pu").val();
						valor1=replaceAll(valor1, ".", "" );
						var valor2 = $("#cant").val();
						var valor_entregar = valor2*valor1;
						document.getElementById("vt").value = valor_entregar;
					  });
				 $(window).load(function(){
					 $("#btnGrabar").hide();
					 });
					 
				function replaceAll( text, busca, reemplaza ){
						while (text.toString().indexOf(busca) != -1)
							text = text.toString().replace(busca,reemplaza);
						return text;
					  }   
			$("#repuesto").click(function(){
				document.getElementById("repuesto").value = "";
				});
			$('#agregar-fila').click(function(){
				var id_repuesto = $("#repuesto").val(); 
				var repuesto = $("#repuesto").val(); 
				var pu = $('#pu').val();
				var cant = $("#cant").val(); 
				var vt = $("#vt").val(); 

				str = '<div id="presu_'+i+'"><div class="floatLeft grilla-tab-fila-campo veinte"><input type="hidden" name="id_repuesto_ant" id="id_repuesto_ant_'+i+'" value="'+id_repuesto+'"/>'+repuesto+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+pu+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+cant+'</div><div class="floatLeft grilla-tab-fila-campo veinte"><input type="hidden" name="vt_ant" id="vt_ant_'+i+'" value="'+vt+'"/>'+vt+'</div><div class="floatLeft grilla-tab-fila-campo diez"><a href="#" onclick="borrarFila('+i+'); return false">Eliminar</a></div><br class="clearBoth"/></div>';
				//alert(str);
				$('#resultado').append(str);
				$('#resultado').show();
				i = i+1;
				str ="";
				$("#btnGrabar").show();
				
				if (document.getElementById("arr_repuesto").value!='') 
					document.getElementById("arr_repuesto").value = document.getElementById("arr_repuesto").value +','+id_repuesto;
				else
					document.getElementById("arr_repuesto").value = id_repuesto;
					
				if (document.getElementById("arr_pu").value!='') 
					document.getElementById("arr_pu").value = document.getElementById("arr_pu").value +','+pu;
				else
					document.getElementById("arr_pu").value = pu;

				if (document.getElementById("arr_cant").value!='') 
					document.getElementById("arr_cant").value = document.getElementById("arr_cant").value +','+cant;
				else
					document.getElementById("arr_cant").value = cant;
				
				if (document.getElementById("arr_vt").value!='') 
					document.getElementById("arr_vt").value= document.getElementById("arr_vt").value +','+vt;
				else
					document.getElementById("arr_vt").value= vt;
				
				var st = document.getElementById("st").value;
				st = parseInt(st) + parseInt(vt);
				document.getElementById("st").value = st;
				});
			}); 		
		function borrarFila(indice){
			
			var vt_ant = $("#vt_ant_" + indice).attr('value');
			var suma = document.getElementById("st").value;
			suma = parseInt(suma)-parseInt(vt_ant);
			document.getElementById("st").value = parseInt(suma);
			
			var id_repuesto = document.getElementById("id_repuesto_ant_" + indice).value;
			
			var arr  = document.getElementById("arr_repuesto").value.split(",");
			var posBorrar=arr.indexOf(id_repuesto);
			arr.splice(posBorrar, 1);
			document.getElementById("arr_repuesto").value = arr.join(",");
			
			var arr  = document.getElementById("arr_pu").value.split(",");
			arr.splice(posBorrar, 1);
			document.getElementById("arr_pu").value = arr.join(",");
			
			var arr  = document.getElementById("arr_cant").value.split(",");
			arr.splice(posBorrar, 1);
			document.getElementById("arr_cant").value = arr.join(",");
			
			var arr  = document.getElementById("arr_vt").value.split(",");
			arr.splice(posBorrar, 1);
			document.getElementById("arr_vt").value = arr.join(",");
			
			$("#presu_" + indice).remove();
			}
		</script>
		<style>
            .floatRight {
                float:right;
                }
            .floatLeft {
                float:left;
                }
            .clearBoth{
                clear:both
                }
            .veinte{
                width:20%;
                }
            .diez{
                width:10%;
                }
        </style>
    	{/literal}
	</HEAD>
	<body style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<form id="Form1" name="Form1" method="post" runat="server">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/02/PNG/onebit_21.png" width="48" height="48"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingreso de reparaciones</label>
                                    <input type="hidden" id="arr_repuesto" name="arr_repuesto"/>
                                    <input type="hidden" id="arr_pu" name="arr_pu"/>
                                    <input type="hidden" id="arr_cant" name="arr_cant"/>
                                    <input type="hidden" id="arr_vt" name="arr_vt"/>
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left">
							  <td class="tabla-alycar-texto" ><table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
							      <td class="tabla-alycar-texto" style=""><input name="cboPersona" id="cboPersona" value="{$CARGA_NOM_PERS}"  />
							        <input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador" value="{$carga_pers}" /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Patente:
							        <label class="requerido"> * </label></td>
							      <td class="tabla-alycar-texto" style="width: 15%"><input id="cboPatente" name="cboPatente" value="{$carga_veh}" /></td>
							      <td class="tabla-alycar-label" style="width: 15%">Persona Asignada</td>
							      <td class="tabla-alycar-texto" ><input type="text" name="pers_asig" id="pers_asig" value="" readonly/>
							        <input type="button" name="btnActualizar" value="Asigancion de Vehiculo" class="boton"  onclick="xajax_LlamaMantenedorVxC(xajax.getFormValues('Form1'));" /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Mecanico:</td>
							      <td class="tabla-alycar-texto" style=""><input name="cboMecanico" id="cboMecanico" value=""  />
							        <input type="hidden" name="rut_mecanico" id="rut_mecanico" value="" /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Fecha de la Reparacion:</td>
							      <td class="tabla-alycar-texto" ><input type="text" id="OBLI-txtFecha2" name="OBLI-txtFecha2" value='{$smarty.now|date_format:"%d/%m/%Y"}' onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Nro Documento:</td>
							      <td class="tabla-alycar-texto" ><input type="text" id="OBLIdocumento" name="OBLIdocumento" value='' onkeypress="return SoloNumeros(this, event, 0)"  /></td>
						        </tr>
							    <tr align="left">
							      <td class="tabla-alycar-label" style="width: 15%">Forma de Pago:
							        <label class="requerido"> * </label></td>
							      <td class="tabla-alycar-texto" style=""><select id="cboPago" name="cboPago" onkeypress="return SoloNumeros(this, event, 0)" >
							        <option value="1">Efectivo</option>
							        <option value="2">Cheque</option>
							        <option value="3">Transferencia</option>
							        <option value="4">Tarjeta Credito</option>
							        </select></td>
							      <td class="boleta_div tabla-alycar-label" style="display:none; width: 15%"> Numero Cheque:
							        <label class="requerido"> * </label></td>
							      <td class="boleta_div tabla-alycar-texto" style="display:none;"><input type="text" id="OBLInro_boleta" name="OBLInro_boleta" onkeypress="return SoloNumeros(this, event, 0)" /></td>
						        </tr>
							    <tr align="left">
							      <td colspan="2" class="tabla-alycar-fila-botones"><input type="button" name="btnGrabar"  id="btnGrabar" value="Grabar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'))"/></td>
						        </tr>
						      </table></td>
							  </tr>
					</table></td>
				</tr>
			</table>
		</div>					
        <div id="divlistado" align="left" style="margin-left:2px; padding: 2px;">
            <table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                <tr>
                    <td>
                        <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr align="left">
                                <td>
                                    <div id='divabonos'>
                                    	<div id="pivot" class="grilla-tab">										
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                           	   	Repuesto
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                            	Precio Unitario
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                            	Cantidad
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                            	Valor Total
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft diez" align='center'>
												Accion
                                            </div>
                                            <br class="clearBoth"/>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                                	<input name="repuesto" id="repuesto" value="Sin Repuesto"/>
                                                	<input type="hidden" name="id_repuesto" id="id_repuesto" value=""/>
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                                	<input name="pu" id="pu" value="0"/>
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                                	<input name="cant" id="cant" value="0" style="text-align:right"/>
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>
                                                	<input name="vt" id="vt" value="0" style="text-align:right"/>
                                            </div>
                                            <div class="grilla-tab-fila-titulo floatLeft diez" align='center'>
                                            	<a href="#" id="agregar-fila" class="agregar-fila" >
                                                	<img src="../images/plus.png" width="26" height="26" />
                                                </a>
                                            </div>
                                            <br class="clearBoth"/>
											<div id="resultado">
                                            </div>
                                            <div id="observaciones">
                                                 <div class="floatRight grilla-tab-fila-titulo" style="padding:20px; width:96%; text-align:right">
                                                     Suma Total :
                                                     <input id="st" name="st" value="0"/>
                                                 </div>
                                                <br class="clearBoth"/>
                                            	<div class="grilla-tab-fila-titulo" style="padding:10px">
                                                	Observaciones
	                                                <br class="clearBoth"/>
	                                                <textarea name="observa" id="observa"  rows="5" cols="100"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </TR>
                        </table>
                    </td>
                </tr>
            </table>
            </form>
        </div>
	</body>
</HTML>