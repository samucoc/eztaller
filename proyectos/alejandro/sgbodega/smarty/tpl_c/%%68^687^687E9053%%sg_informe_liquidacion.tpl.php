<?php /* Smarty version 2.6.18, created on 2013-11-21 10:54:52
         compiled from sg_informe_liquidacion.tpl */ ?>
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
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
		
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
			<script type="text/javascript" src="http://www.bci.cl/common/include/valores.js"></script>
		<?php echo '
		
		<script type="text/javascript">
			//función que obtiene el valor deseado
			//formatear_numero es una función definida en el archivo del bci
			function valor(indice) {
				return formatear_numero(arrValores[indice].valor2);
				}
			$(document).ready(function() { 
				$("#cboPersona").autocomplete({
					source : \'busquedas/busqueda_persona.php\',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById(\'txtCodCobrador\').value = rut;
						}
					});
				$("#viaticos").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							return ;   
							}        
						var input = $("<input type=\'text\' size=\'10\' />")
									.val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
								.focus()
								.blur( function( e ){	
									var temp = $(this).val();
									$(this).parent(\'td\').text(  format(temp) );	
									document.getElementById("div_viaticos").value = temp;
									calcular_totales($("#div_sueldo_base").val());
									});    
					});
				$("#asig_caja").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							return ;   
							}        
						var input = $("<input type=\'text\' size=\'10\' />")
									.val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
								.focus()
								.blur( function( e ){	
									var temp = $(this).val();
									$(this).parent(\'td\').text(  format(temp) );	
									document.getElementById("div_asig_caja").value = temp;
									calcular_totales($("#div_sueldo_base").val());
									});    
					});
				$("#retenciones").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							return ;   
							}        
						var input = $("<input type=\'text\' size=\'10\' />")
									.val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
								.focus()
								.blur( function( e ){	
									var temp = $(this).val();
									$(this).parent(\'td\').text(  format(temp) );	
									document.getElementById("div_retenciones").value = temp;
									calcular_totales($("#div_sueldo_base").val());
									});    
					});
				$("#perd_caja").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							return ;   
							}        
						var input = $("<input type=\'text\' size=\'10\' />")
									.val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
								.focus()
								.blur( function( e ){	
									var temp = $(this).val();
									$(this).parent(\'td\').text(  format(temp) );	
									document.getElementById("div_perd_caja").value = temp;
									calcular_totales($("#div_sueldo_base").val());
									});    
					});
				$("#comisiones").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							return ;   
							}        
						var input = $("<input type=\'text\' size=\'10\' />")
									.val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
								.focus()
								.blur( function( e ){	
									var temp = $(this).val();
									$(this).parent(\'td\').text(  format(temp) );	
									document.getElementById("div_comisiones").value = temp;
									calcular_totales($("#div_sueldo_base").val());
									});    
					});
				$("#sueldo_base").click( function( e ){
						if ( $(this).find(\'input\').length ) {
							 return ;   
						}        
						var input = $("<input type=\'text\' size=\'10\' />")
										  .val( $(this).text() );
						$(this).empty().append( input );
						$(this).find(\'input\')
							.focus()
							.blur( function( e ){
								var temp = $(this).val();
								calcular_totales(temp);
								$(this).parent(\'td\').text(  format(temp) );
								});    
						});

			function calcular_totales(temp){
				
								temp = temp.replace(/\\,/g, \'\');
								var dias_trabajados = document.getElementById("dias_trabajados").innerHTML;
								var cant_he = 0;
								var horas_extras = (((((parseFloat(temp) * 7) / dias_trabajados) /45) * 1.5 ) * cant_he );
								document.getElementById("horas_extras").innerHTML =  format(Math.round(horas_extras));
								document.getElementById("cant_he").innerHTML =  format(Math.round(cant_he));
								
								var cant_hd = 0;
								var horas_descuento = (((((parseFloat(temp) * 7) / dias_trabajados) /45) ) * cant_hd );
								document.getElementById("horas_descuentos").innerHTML =  format(Math.round(horas_descuento));
								document.getElementById("cant_hd").innerHTML =  format(Math.round(cant_hd));
								
								var gratificacion = parseFloat(temp) * (1/4);
								var porc_imm = (4.75*210000)/12;
								var temp_gra = 0;
								if (gratificacion <= (porc_imm)){
									temp_gra = Math.round(gratificacion);
									}
								else{
									temp_gra = Math.round(porc_imm);
									}
								document.getElementById("gratificacion").innerHTML =  format(temp_gra);
									
								var dias_licencia = 0;
								var monto_dias_licencia = 	parseFloat(temp) / dias_trabajados * dias_licencia;
								var temp_mld =  Math.round(monto_dias_licencia*(-1));
								document.getElementById("dias_licencia").innerHTML =  format(temp_mld);
										
								var cant_cargas = document.getElementById(\'div_total_cargas\').value;
								var temp_cc = 0;
								if (parseFloat(temp)<=220354){
									temp_cc = 8626 * cant_cargas;
									}
								if ((parseFloat(temp)>220354)&&(parseFloat(temp)<=321851)){
									temp_cc = 5294 * cant_cargas;
									}
								if ((parseFloat(temp)>321851)&&(parseFloat(temp)<=501978)){
									temp_cc = 1673 * cant_cargas;
									}
								if (parseFloat(temp)>501978){
									temp_cc =  0 * cant_cargas;
									}
								document.getElementById(\'carg_fam\').innerHTML =  format(temp_cc); 
								var total_hab_impo = 0 ;
								var div_comisiones = document.getElementById(\'div_comisiones\').value;
								if (div_comisiones!=\'\'){
									total_hab_impo = parseFloat(temp) + parseFloat(horas_extras) + parseFloat(temp_gra) + parseFloat(temp_mld) + parseFloat(temp_cc) + parseFloat(div_comisiones); 
									}
								else{
									total_hab_impo = parseFloat(temp) + parseFloat(horas_extras) + parseFloat(temp_gra) + parseFloat(temp_mld) + parseFloat(temp_cc); 
									}

								document.getElementById(\'total_hab_impo\').innerHTML =  format(Math.round(total_hab_impo));
								
								var div_viaticos = document.getElementById(\'div_viaticos\').value;
								div_viaticos = div_viaticos == \'\' ? 0 : document.getElementById(\'div_viaticos\').value;
								var div_asig_caja = document.getElementById(\'div_asig_caja\').value;
								div_asig_caja = div_asig_caja == \'\' ? 0 : document.getElementById(\'div_asig_caja\').value;
								
								var total_hab_no_impo = parseFloat(div_asig_caja) + parseFloat(Math.round(temp_cc)) + parseFloat(div_viaticos);
								document.getElementById(\'total_hab_no_impo\').innerHTML =  format(total_hab_no_impo);
								
								total_hab_impo = total_hab_impo == \'\' ? 0 : total_hab_impo;
								total_hab_no_impo = total_hab_no_impo == \'\' ? 0 : total_hab_no_impo;
																
								var total_hab =  Math.round(total_hab_impo) + total_hab_no_impo;
								document.getElementById(\'total_hab\').innerHTML =  format(total_hab);
								
								var porc_afp = $("#hidden_afp").val();
								var afp = parseFloat(porc_afp)/100;
								var nro_afp = total_hab_impo * afp;
								document.getElementById("porc_afp").innerHTML = porc_afp;
								document.getElementById("afp").innerHTML =  format(Math.round(nro_afp));
								var porc_fonasa = $("#hidden_fonasa").val();
								var fonasa = parseFloat(porc_fonasa)/100;
								var nro_fonasa = total_hab_impo * fonasa;
								document.getElementById("porc_fonasa").innerHTML = porc_fonasa;
								document.getElementById("fonasa").innerHTML =  format(Math.round(nro_fonasa));
								var porc_sc = $("#hidden_sc").val();
								var sc = parseFloat(porc_sc)/100;
								var nro_sc = total_hab_impo * sc;
								document.getElementById("seg_cesantia").innerHTML =  format(Math.round(nro_sc));
								var impuesto_unico = parseFloat(temp) - parseFloat(Math.round(nro_afp)) - parseFloat(Math.round(nro_fonasa)) - parseFloat(Math.round(nro_sc));
								var valor_utm = valor(5);
								arr_valor = valor_utm.split(\',\');
								valor_utm = arr_valor[0];
								arr_valor = valor_utm.split(\'.\');
								valor_utm = arr_valor.join(\'\');
								var monto_iu = 0;
								if (impuesto_unico <=  parseFloat(valor_utm)*13.5){
									monto_iu = 0;
									}
								if((impuesto_unico > (parseFloat(valor_utm*13.5)))&&(impuesto_unico <= (parseFloat(valor_utm*30)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.04) - 21994.74);
									}
								if((impuesto_unico > (parseFloat(valor_utm*30)))&&(impuesto_unico <= (parseFloat(valor_utm*50)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.08) - 70871.94);
									}
								if((impuesto_unico > (parseFloat(valor_utm*50)))&&(impuesto_unico <= (parseFloat(valor_utm*70)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.135) - 182882.19);
									}
								if((impuesto_unico > (parseFloat(valor_utm*70)))&&(impuesto_unico <= (parseFloat(valor_utm*90)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.23) - 453743.34);
									}
								if((impuesto_unico > (parseFloat(valor_utm*90)))&&(impuesto_unico <= (parseFloat(valor_utm*120)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.304) - 725011.80);
									}
								if((impuesto_unico > (parseFloat(valor_utm*120)))&&(impuesto_unico <= (parseFloat(valor_utm*150)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.355) - 974285.52);
									}
								if((impuesto_unico > (parseFloat(valor_utm*150)))){
									monto_iu = Math.round((parseFloat(impuesto_unico)  * 0.40) - 1249219.77);
									}
								document.getElementById("impuesto_unico").innerHTML =  format(monto_iu);
								
								var tot_desc_leg = parseFloat(Math.round(nro_afp)) + parseFloat(Math.round(nro_fonasa)) + parseFloat(Math.round(nro_sc)) + parseFloat(Math.round(monto_iu));
								document.getElementById(\'tot_desc_leg\').innerHTML =  format(Math.round(tot_desc_leg));
								
								var anticipos =  parseFloat(Math.round(document.getElementById(\'anticipos\').innerHTML));
								var seguros =  parseFloat(Math.round(document.getElementById(\'seguros\').innerHTML));
								var vales =  parseFloat(Math.round(document.getElementById(\'vales\').innerHTML));
								var vent_pers =  parseFloat(Math.round(document.getElementById(\'vent_pers\').innerHTML));
								var perd_caja =  parseFloat(Math.round(document.getElementById(\'div_perd_caja\').value));
								var retenciones =  parseFloat(Math.round(document.getElementById(\'div_retenciones\').value));
								var otros =  parseFloat(Math.round(document.getElementById(\'otros\').innerHTML));
								
								var total_otros_desc = anticipos+seguros+vales+vent_pers+perd_caja+retenciones+otros;
								document.getElementById(\'total_otros_desc\').innerHTML =  format(total_otros_desc);
								
								var total_desc = parseFloat(Math.round(total_otros_desc)) +  parseFloat(Math.round(tot_desc_leg));
								document.getElementById(\'total_desc\').innerHTML =  format(total_desc);
								var total_pagar = total_hab-total_desc;
								document.getElementById(\'total_pagar\').innerHTML = format(total_pagar);
								
								total_pagar = NumeroALetras(total_pagar);
								document.getElementById(\'total_pagar_letras\').innerHTML = total_pagar;
								
								document.getElementById("div_sueldo_base").value = format(temp);
						}
			function format(input){
				var parseado2 = input.toString().split(\'\').reverse().join(\'\').replace(/\\d{3}(?=\\d)/g, function(miles){ return miles +\',\';})
				return parseado2.toString().split(\'\').reverse().join(\'\');
				}
			function Unidades(num){
				
				  switch(num)
				  {
					case 1: return "UN";
					case 2: return "DOS";
					case 3: return "TRES";
					case 4: return "CUATRO";
					case 5: return "CINCO";
					case 6: return "SEIS";
					case 7: return "SIETE";
					case 8: return "OCHO";
					case 9: return "NUEVE";
				  }
				
				  return "";
				}
				
				function Decenas(num){
				
				  decena = Math.floor(num/10);
				  unidad = num - (decena * 10);
				
				  switch(decena)
				  {
					case 1:   
					  switch(unidad)
					  {
						case 0: return "DIEZ";
						case 1: return "ONCE";
						case 2: return "DOCE";
						case 3: return "TRECE";
						case 4: return "CATORCE";
						case 5: return "QUINCE";
						default: return "DIECI" + Unidades(unidad);
					  }
					case 2:
					  switch(unidad)
					  {
						case 0: return "VEINTE";
						default: return "VEINTI" + Unidades(unidad);
					  }
					case 3: return DecenasY("TREINTA", unidad);
					case 4: return DecenasY("CUARENTA", unidad);
					case 5: return DecenasY("CINCUENTA", unidad);
					case 6: return DecenasY("SESENTA", unidad);
					case 7: return DecenasY("SETENTA", unidad);
					case 8: return DecenasY("OCHENTA", unidad);
					case 9: return DecenasY("NOVENTA", unidad);
					case 0: return Unidades(unidad);
				  }
				}//Unidades()
				
				function DecenasY(strSin, numUnidades){
				  if (numUnidades > 0)
					return strSin + " Y " + Unidades(numUnidades)
				
				  return strSin;
				}//DecenasY()
				
				function Centenas(num){
				
				  centenas = Math.floor(num / 100);
				  decenas = num - (centenas * 100);
				
				  switch(centenas)
				  {
					case 1:
					  if (decenas > 0)
						return "CIENTO " + Decenas(decenas);
					  return "CIEN";
					case 2: return "DOSCIENTOS " + Decenas(decenas);
					case 3: return "TRESCIENTOS " + Decenas(decenas);
					case 4: return "CUATROCIENTOS " + Decenas(decenas);
					case 5: return "QUINIENTOS " + Decenas(decenas);
					case 6: return "SEISCIENTOS " + Decenas(decenas);
					case 7: return "SETECIENTOS " + Decenas(decenas);
					case 8: return "OCHOCIENTOS " + Decenas(decenas);
					case 9: return "NOVECIENTOS " + Decenas(decenas);
				  }
				
				  return Decenas(decenas);
				}//Centenas()
				
				function Seccion(num, divisor, strSingular, strPlural){
				  cientos = Math.floor(num / divisor)
				  resto = num - (cientos * divisor)
				
				  letras = "";
				
				  if (cientos > 0)
					if (cientos > 1)
					  letras = Centenas(cientos) + " " + strPlural;
					else
					  letras = strSingular;
				
				  if (resto > 0)
					letras += "";
				
				  return letras;
				}//Seccion()
				
				function Miles(num){
				  divisor = 1000;
				  cientos = Math.floor(num / divisor)
				  resto = num - (cientos * divisor)
				
				  strMiles = Seccion(num, divisor, "UN MIL", "MIL");
				  strCentenas = Centenas(resto);
				
				  if(strMiles == "")
					return strCentenas;
				
				  return strMiles + " " + strCentenas;
				
				  //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
				}//Miles()
				
				function Millones(num){
				  divisor = 1000000;
				  cientos = Math.floor(num / divisor)
				  resto = num - (cientos * divisor)
				
				  strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
				  strMiles = Miles(resto);
				
				  if(strMillones == "")
					return strMiles;
				
				  return strMillones + " " + strMiles;
				
				  //return Seccion(num, divisor, "UN MILLON", "MILLONES") + " " + Miles(resto);
				}//Millones()
				
				function NumeroALetras(num){
				  var data = {
					numero: num,
					enteros: Math.floor(num),
					centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
					letrasCentavos: "",
					letrasMonedaPlural: "PESOS",
					letrasMonedaSingular: "PESO"
				  };
				
				  if (data.centavos > 0)
					data.letrasCentavos = "CON " + data.centavos + "/100";
				
				  if(data.enteros == 0)
					return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
				  if (data.enteros == 1)
					return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
				  else
					return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
				}//NumeroALetras()
			
				}); 
			
		</script>
		<script type="text/javascript" > 
			function verificaValor(temp){
                            if (temp==\'\'){
                                document.getElementById(\'txtCodCobrador\').value="";
                                }
                            }
			function ImprimeDiv(id)
			{
					document.getElementById(\'btnImprimir\').style.display = \'none\';
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
				   document.getElementById(\'btnImprimir\').style.display = \'block\';
					
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
<body>
<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
<table cellpadding="2" cellspacing="2" class="curvar" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
  <tr>
    <td ><form id="Form1" name="Form1" method="post" runat="server">
		<br>
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
            <tr align="left" valign="middle">
                <td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
                <td style="width: 93%"><label class="form-titulo">&nbsp&nbsp;Liquidacion Trabajador</label></td>
            </tr>
        </table>
        <br>
      <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
       <tr align="left">
            <td class="tabla-alycar-label" style="width: 15%">Trabajador<label class="requerido"> * </label></td>
            <td class="tabla-alycar-texto" style="width: 85%">
                <input name="cboPersona" id="cboPersona" value="" onchange="verificaValor(this.value)" size="50"/>
                <input type="hidden" name="txtCodCobrador" id="txtCodCobrador"></input>
            </td>	
        </tr>
        <tr align="left">
          <td colspan="2" class="tabla-alycar-fila-botones"><input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();" />
            </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</div>
		<div id="divlistado" align="left" style="margin-left:2px; padding: 2px;">
        		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                   <tr>
						<td>
                        <table cellpadding="0" cellspacing="0" class="tabla-alycar" style="width: 100%; font-size:9px !important;">
                        	<tr align="left">
                            	<td colspan="4" class="tabla-alycar-label-peq" align="center" style="font-size:18px !important; padding:10px">LIQUIDACION DE REMUNERACIONES</td>
                                <input type="hidden" id="div_sueldo_base" name="div_sueldo_base"/>
                                <input type="hidden" id="div_comisiones" name="div_comisiones"/>
                                <input type="hidden" id="div_perd_caja" name="div_perd_caja" />
                                <input type="hidden" id="div_retenciones" name="div_retenciones" />
                               	<input type="hidden" id="div_asig_caja" name="div_asig_caja" />
                               	<input type="hidden" id="div_total_cargas" name="div_total_cargas" />
                          	    <input type="hidden" id="div_viaticos" name="div_viaticos" />
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" width="25%">Empresa</td>
                            	<td class="tabla-alycar-texto-peq" width="25%"><div name="empresa" id="empresa"/></td>
                            	<td class="tabla-alycar-label-peq" width="25%">Rut Empresa</td>
                            	<td class="tabla-alycar-texto-peq" width="25%"><div name="rutEmpresa" id="rutEmpresa"/></td>
                            </tr>  
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Mes</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="mes" id="mes"/></td>
                            	<td class="tabla-alycar-label-peq" >Fecha Emisi&oacute;n</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="fecha_emision" id="fecha_emision"/></td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-label-peq" ></td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Trabajador</td>
                            	<td class="tabla-alycar-texto-peq" colspan="3"><div name="trabajador" id="trabajador"/></td>
                            </tr>  
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Rut</td>
                            	<td class="tabla-alycar-texto-peq" colspan="3"><div name="rut_trab" id="rut_trab"/></td>
                            </tr>  
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Fecha Contrato</td>
                            	<td class="tabla-alycar-texto-peq" colspan="3"><div name="fecha_contr" id="fecha_contr"/></td>
                            </tr>  
                        	<tr align="left">
                            	<td colspan="4" class="tabla-alycar-label-peq" ></td>
                          	</tr>
                            <tr>
                            	<td class="tabla-alycar-label-peq" >Cotizaci&oacute;n Pactada</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="cot_pact" id="cot_pact"/></td>
                            	<td class="tabla-alycar-label-peq" >Valor UF</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="valor_uf" id="valor_uf"/></td>
                            </tr>  
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Dias Trabajados</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="dias_trabajados" id="dias_trabajados"/></td>
                            	<td class="tabla-alycar-label-peq" >Tope Imponible</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="tope_imponible" id="tope_imponible"/></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" colspan="2"  ></td>
                            	<td class="tabla-alycar-label-peq" >Tope Salud</td>
                            	<td class="tabla-alycar-texto-peq" ><div name="tope_salud" id="tope_salud"/></td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" colspan="2" >Haberes</td>
                            	<td class="tabla-alycar-label-peq" colspan="2" >Descuentos</td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" colspan="2" >Imponibles</td>
                            	<td class="tabla-alycar-label-peq" colspan="2" >Descuentos Legales</td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Sueldo Base</td>
                            	<td class="tabla-alycar-texto-peq" id="sueldo_base"></td>
                            	<td class="tabla-alycar-label-peq" >Impuesto Unico</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="impuesto_unico"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" style="padding:0px !important" colspan="2">
                                	<table class="tabla-alycar" >
                                    	<tr>
                                    	<td class="tabla-alycar-label-peq" style="padding:0px !important" >Horas Extras</td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important" ><div id="cant_he"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important" ><div id="horas_extras"></div></td>
                                        </tr>
                                    </table>
                                </td>
                            	<td class="tabla-alycar-label-peq"  style="padding:0px !important" colspan="2">
                                	<table class="tabla-alycar" >
                                    	<tr>
                                    	<td class="tabla-alycar-label-peq" style="padding:0px !important"  width="25%">AFP</td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%"><div id="nombre_afp"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%"><div id="porc_afp"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%">
                                        	<div id="afp"></div>                                    
                                            <input type="hidden" name="hidden_afp" id="hidden_afp"/>
										</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" style="padding:0px !important" colspan="2">
                            		<table class="tabla-alycar" >
                                    	<tr>
                                    	<td class="tabla-alycar-label-peq" style="padding:0px !important" >Horas Descuento</td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important" ><div id="cant_hd"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"><div id="horas_descuentos"></div></td>
                                        </tr>
                                    </table>
                                </td>
	                           	<td class="tabla-alycar-label-peq"  style="padding:0px !important" colspan="2">
                                	<table class="tabla-alycar" >
                                    	<tr>
                                    	<td class="tabla-alycar-label-peq" style="padding:0px !important"  width="25%">Fonasa / Isapre</td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%"><div id="nombre_fonasa"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%"><div id="porc_fonasa"></div></td>
                                    	<td class="tabla-alycar-texto-peq" style="padding:0px !important"  width="25%">
		                                	<div id="fonasa"></div>
        		                         	<input type="hidden" name="hidden_fonasa" id="hidden_fonasa"/>
                		                </td>
										</tr>
									</tr>
                                 </table>
                                 </td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >Gratificaci&oacute;n</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="gratificacion"></div></td>
                            	<td class="tabla-alycar-label-peq" >Seguro de Cesant&iacute;a</td>
                            	<td class="tabla-alycar-texto-peq" >
                                	<div id="seg_cesantia"></div>
                                 	<input type="hidden" name="hidden_sc" id="hidden_sc"/>
                                </td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >Comisiones</td>
                            	<td class="tabla-alycar-texto-peq" id="comisiones">0</td>
                            	<td colspan="2" class="tabla-alycar-texto-peq" >&nbsp;</td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >D&iacute;as Licencia</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="dias_licencia"></div></td>
                            	<td colspan="2" class="tabla-alycar-texto-peq" >&nbsp;</td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Total Haberes Imponibles</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_hab_impo"></div></td>
                            	<td class="tabla-alycar-label-peq" >Total Descuentos Legales</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="tot_desc_leg"></div></td>
                            </tr>  
                        	<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" colspan="2" >No Imponibles</td>
                            	<td class="tabla-alycar-label-peq" colspan="2" >Otros Descuentos</td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Asignaci&oacute;n Caja</td>
                            	<td class="tabla-alycar-texto-peq" id="asig_caja" >0</td>
                            	<td class="tabla-alycar-label-peq" >Anticipos</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="anticipos"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >Cargas Familiares</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="carg_fam"></div></td>
                            	<td class="tabla-alycar-label-peq" >Seguros</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="seguros"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >Vi&aacute;ticos</td>
                            	<td class="tabla-alycar-texto-peq" id="viaticos">0</td>
                            	<td class="tabla-alycar-label-peq" >Vales</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="vales"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" colspan="2" ></td>
                            	<td class="tabla-alycar-label-peq" >Ventas Personales</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="vent_pers"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" colspan="2" ></td>
                            	<td class="tabla-alycar-label-peq" >P&eacute;rdida Caja</td>
                            	<td class="tabla-alycar-texto-peq" id="perd_caja">0</td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" colspan="2" ></td>
                            	<td class="tabla-alycar-label-peq" >Retenciones</td>
                            	<td class="tabla-alycar-texto-peq" id="retenciones">0</td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" ></td>
                            	<td class="tabla-alycar-texto-peq" ></td>
                            	<td class="tabla-alycar-label-peq" >Otros</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="otros"></div></td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Total Haberes No Imponibles</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_hab_no_impo"></div></td>
                            	<td class="tabla-alycar-label-peq" >Total Otros Descuentos</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_otros_desc"></div></td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" >&nbsp;</td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-label-peq" >Total Haberes</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_hab"></div></td>
                            	<td class="tabla-alycar-label-peq" >Total Descuentos</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_desc"></div></td>
                            </tr>  
                       		<tr align="left">
                            	<td colspan="4" class="tabla-alycar-texto-peq" ></td>
                          	</tr>
                        	<tr>
                            	<td class="tabla-alycar-texto-peq" ></td>
                            	<td class="tabla-alycar-texto-peq" ></td>
                            	<td class="tabla-alycar-label-peq" >Total a Pagar</td>
                            	<td class="tabla-alycar-texto-peq" ><div id="total_pagar"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" >Son</td>
                            	<td class="tabla-alycar-texto-peq" colspan="3"><div id="total_pagar_letras"></div></td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-texto-peq" colspan="4">
                                	Certifico que he recibido de <span id="nombre_empresa"></span>, a mi entera satisfacci&oacute;n,
                                    el Saldo indicado en la presente liquidaci&oacute;n y no tengo cargo ni cobro posteriores que hacer.
                                </td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" colspan="3"></td>
                            	<td class="tabla-alycar-texto-peq" align="center" style="padding-top:20px;">_____________________________</td>
                            </tr>  
                       		<tr>
                            	<td class="tabla-alycar-label-peq" colspan="3"></td>
                            	<td class="tabla-alycar-texto-peq" align="center">Recibi Conforme</td>
                            </tr>  
                       		
                        </table>
                        </td>
                        </tr>
                        
                        <tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divlistado');">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>

                        </table>
</div>

</body>
</html>