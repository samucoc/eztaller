<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
        <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        
		{literal}
        <SCRIPT language="javascript">
			function checkAll(theForm, cName, status) {
				for (i=0,n=theForm.elements.length;i<n;i++)
				  if (theForm.elements[i].className.indexOf(cName) !=-1) {
					theForm.elements[i].checked = status;
				  }
				}
			var patron = new Array(2,2,4)
			var patron2 = new Array(1,3,3,3,3)
			function mascara(d,sep,pat,nums){
				if(d.valant != d.value){
					val = d.value
					largo = val.length
					val = val.split(sep)
					val2 = ''
					for(r=0;r<val.length;r++){
						val2 += val[r]	
					}
					if(nums){
						for(z=0;z<val2.length;z++){
							if(isNaN(val2.charAt(z))){
								letra = new RegExp(val2.charAt(z),"g")
								val2 = val2.replace(letra,"")
							}
						}
					}
					val = ''
					val3 = new Array()
					for(s=0; s<pat.length; s++){
						val3[s] = val2.substring(0,pat[s])
						val2 = val2.substr(pat[s])
					}
					for(q=0;q<val3.length; q++){
						if(q ==0){
							val = val3[q]
						}
						else{
							if(val3[q] != ""){
								val += sep + val3[q]
								}
						}
					}
					d.value = val
					d.valant = val
					}
				}			
		</SCRIPT>
        <script type="text/javascript">
			$(function($) { 
				$('#mes_inicio_colegiatura').mask("99/99/9999");
				$('#mes_inicio_incorporacion').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			$(document).ready(function() { 
                            $.datepicker.regional['es'] = {
                                  closeText: 'Cerrar',
                                  prevText: '<Ant',
                                  nextText: 'Sig>',
                                  currentText: 'Hoy',
                                  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                                  dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado'],
                                  dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S�b'],
                                  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S�'],
                                  weekHeader: 'Sm',
                                  dateFormat: 'dd/mm/yy',
                                  firstDay: 1,
                                  isRTL: false,
                                  showMonthAfterYear: false,
                                  yearSuffix: ''};
                            $.datepicker.setDefaults($.datepicker.regional['es']);                            
                            $('#mes_inicio_colegiatura,#mes_inicio_incorporacion').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
							$("#beca_incorporacion").change(function(){
								carga_valor_incorporacion();
								});
							function carga_valor_incorporacion(){
								var valor = $("#valor_incorporacion").val();
								var beca = $("#beca_incorporacion").val();
								document.getElementById("a_cancelar_incorporacion").value = valor - beca;
								var a_cancelar = valor - beca;
								var factor = $("#tipo_pago_incorporacion option:selected").val();
								document.getElementById("valor_cuota_incorporacion").value = Math.round(a_cancelar/factor);
								}
							$("#tipo_pago_incorporacion").change(function(){
								var factor = $("#tipo_pago_incorporacion option:selected").val();
								var a_cancelar = $("#a_cancelar_incorporacion").val();
								document.getElementById("valor_cuota_incorporacion").value = Math.round(a_cancelar/factor);
								});
							$("#beca_colegiatura").change(function(){
								carga_valor_colegiatura();
								});
							function carga_valor_colegiatura(){
								var valor = $("#valor_colegiatura").val();
								var beca = $("#beca_colegiatura").val();
								document.getElementById("a_cancelar_colegiatura").value = valor - beca;
								var a_cancelar = valor - beca;
								var factor = $("#tipo_pago_colegiatura option:selected").val();
								document.getElementById("valor_cuota_colegiatura").value = Math.round(a_cancelar/factor);
								}
							$("#tipo_pago_colegiatura").change(function(){
								var factor = $("#tipo_pago_colegiatura option:selected").val();
								var a_cancelar = $("#a_cancelar_colegiatura").val();
								document.getElementById("valor_cuota_colegiatura").value = Math.round(a_cancelar/factor);
								});
							});
		</script>
		<script type="text/javascript" > 
                        function verificaValor(temp){
                            if (temp==''){
                                document.getElementById('OBLI-txtCodCobrador').value="";
                                }
                            }
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
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
				 // A�ade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el c�digo en PHP
				 $("#" + id_form).submit();
			}
 		</script> 

		{/literal}
	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
	<!--<body style="background:#ffffff;"> -->
		<form id="Form1" name="Form1" method="post" runat="server">
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">Matricula - <div id="nombre_alumno" name="nombre_alumno"></div></label> 
                                    <input type="hidden" name="rut_alumno" id="rut_alumno" value="{$rut_alumno}"/>
                                    
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" colspan="6">Colegiatura Inicial</td>
								</tr>
                                <tr align="left">
								  <td class="tabla-alycar-label">Valor</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="valor_incorporacion" type="text" id="valor_incorporacion" readonly="readonly" />
                                  </td>
								  <td class="tabla-alycar-label">Beca</td>
								  <td class="tabla-alycar-texto">
                                  	<input type="text" id="beca_incorporacion" name="beca_incorporacion" />
                                  </td>
								  <td class="tabla-alycar-label">A Cancelar</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="a_cancelar_incorporacion" type="text" id="a_cancelar_incorporacion" readonly="readonly"/>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label">Tipo de Pago</td>
								  <td class="tabla-alycar-texto">
                                  	<select name="tipo_pago_incorporacion" id="tipo_pago_incorporacion" disabled>
                                    	<option value="1">Una Cuota</option>
                                    	<option value="2">Dos Cuotas</option>
                                    	<option value="3">Tres Cuotas</option>
                                    	<option value="4">Cuatro Cuotas</option>
                                    	<option value="5">Cinco Cuotas</option>
                                    	<option value="6">Seis Cuotas</option>
                                    	<option value="7">Siete Cuotas</option>
                                    	<option value="8">Ocho Cuotas</option>
                                    	<option value="9">Nueve Cuotas</option>
                                    	<option value="10">Diez Cuotas</option>
                                    	<option value="11">Once Cuotas</option>
                                    	<option value="12">Doce Cuotas</option>
                                    
                                    </select>
                                  </td>
								  <td class="tabla-alycar-label">Mes inicio</td>
								  <td class="tabla-alycar-texto">
                                  	<input type="text" id="mes_inicio_incorporacion" name="mes_inicio_incorporacion"  />
                                  </td>
								  <td class="tabla-alycar-label">Valor Cuota</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="valor_cuota_incorporacion" type="text" id="valor_cuota_incorporacion"  readonly="readonly"/>
                                  </td>
							  	</tr>
								<tr align="left">
									<td class="tabla-alycar-label" colspan="6">Colegiatura</td>
								</tr>
                                <tr align="left">
								  <td class="tabla-alycar-label">Valor</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="valor_colegiatura" type="text" id="valor_colegiatura" value="{$colegiatura}" readonly="readonly"/>
                                  </td>
								  <td class="tabla-alycar-label">Beca</td>
								  <td class="tabla-alycar-texto">
                                  	<input type="text" id="beca_colegiatura" name="beca_colegiatura" />
                                  </td>
								  <td class="tabla-alycar-label">A Cancelar</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="a_cancelar_colegiatura" type="text" id="a_cancelar_colegiatura" value="{$colegiatura}" readonly="readonly"/>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label">Tipo de Pago</td>
								  <td class="tabla-alycar-texto">
                                  	<select name="tipo_pago_colegiatura" id="tipo_pago_colegiatura">
                                    	<option value="1">Contado</option>
                                    	<option value="2">Dos Cuotas</option>
                                    	<option value="3">Tres Cuotas</option>
                                    	<option value="4">Cuatro Cuotas</option>
                                    	<option value="5">Cinco Cuotas</option>
                                    	<option value="6">Seis Cuotas</option>
                                    	<option value="7">Siete Cuotas</option>
                                    	<option value="8">Ocho Cuotas</option>
                                    	<option value="9">Nueve Cuotas</option>
                                    	<option value="10" selected="selected">Diez Cuotas</option>
                                    	<option value="11">Once Cuotas</option>
                                    	<option value="12">Doce Cuotas</option>
                                    
                                    </select>
                                  </td>
								  <td class="tabla-alycar-label">Mes inicio</td>
								  <td class="tabla-alycar-texto">
                                  	<input type="text" id="mes_inicio_colegiatura" name="mes_inicio_colegiatura" value=""/>
                                  </td>
								  <td class="tabla-alycar-label">Valor Cuota</td>
								  <td class="tabla-alycar-texto">
                                  	<input name="valor_cuota_colegiatura" type="text" id="valor_cuota_colegiatura" value="{$valor_cuota_colegiatura}" readonly="readonly"/>
                                  </td>
							  	</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Generar Cartola" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
									&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
										<div id='divabonos'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>