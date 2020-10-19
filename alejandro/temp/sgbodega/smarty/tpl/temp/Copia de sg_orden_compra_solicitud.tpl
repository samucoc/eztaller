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
				$('#OBLI-txtFecha1').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			var i =0;
			var str ="";
			$(window).load(function(){
				xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItipo_compra','tipos_compras','','- - Seleccione - -','tipos_compras_ncorr', 'nombre', '');
				xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcentro_costo','centro_costos','','- - Seleccione - -','cc_ncorr', 'nombre', '');
				xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIproyecto','proyectos','','- - Seleccione - -','proy_ncorr', 'nombre', '');
				xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIArea','areas','','- - Seleccione - -','area_ncorr', 'nombre', '');
				xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIforma_pago','forma_pago','','- - Seleccione - -','fp_ncorr', 'nombre', '');
				$("#detalle-producto, #detalle-producto").hide();
				});
			$(document).ready(function() { 
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
				$('#OBLI-txtFecha1').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#sin_productos").click(function(){
						$("#detalle-producto, #detalle-producto").hide();						   
					});
				$("#con_productos").click(function(){
						$("#detalle-producto, #detalle-producto").show();						   
					});
				$("#OBLIproveedores").autocomplete({
					source : 'busquedas/busqueda_proveedores.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						var rut_p = ui.item.rut;
						var direccion = ui.item.direccion;
						var fono1 = ui.item.fono1;
						var email = ui.item.email;
						var atencion = ui.item.atencion;
						document.getElementById('txt_prov').value = rut;
						document.getElementById('rut_proveedor').innerHTML = rut_p;
						document.getElementById('direccion_proveedor').innerHTML = direccion;
						document.getElementById('telefono_prov').innerHTML = fono1;
						document.getElementById('email_prov').innerHTML = email;
						document.getElementById('nc_prov').innerHTML = atencion;
						}
					});
				$("#OBLIempresa").autocomplete({
					source : 'busquedas/busqueda_empresa.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('txt_empe').value = rut;
						}
					});
				$("#monto_total").on('blur',function(){
					var total = $(this).val();
					var neto = parseInt(total)*0.81;
					var iva = parseInt(total)*0.19;
					document.getElementById('neto').value = Math.round(neto);
					document.getElementById('iva').value = Math.round(iva);
					});
				$("#OBLIlugar_entrega").on('change',function(){
					var valor = $("#OBLIlugar_entrega").val();
					if (valor=='2'){
						document.getElementById('direccion_entrega').value = $('#direccion_proveedor').html();
						}
					});
				$('#btnAgregar').click(function(){
					var OBLItxtCodProducto = $("#txtCodProducto").val(); 
					var OBLItxtDescProducto = $("#txtDescProducto").val(); 
					var OBLItxtCant = $('#txtCant').val();
					var OBLItxtNeto = $("#txtNeto").val(); 
					var OBLItxtTotal = $("#txtTotal").val(); 
					var id_repuesto = "";
					
					if (OBLItxtCodProducto!=''){
						id_repuesto = OBLItxtCodProducto;
						}
					else{
						id_repuesto = OBLItxtDescProducto;	
						}
	
					str = '<tr id="presu_'+i+'" align="left"><td class="tabla-alycar-texto" width="40%"><input type="hidden" name="id_repuesto_ant" id="id_repuesto_ant_'+i+'" value="'+id_repuesto+'"/>'+OBLItxtCodProducto+' '+OBLItxtDescProducto+'</td><td class="tabla-alycar-texto" width="15%">'+OBLItxtCant+'</td><td class=" tabla-alycar-texto" width="15%">'+OBLItxtNeto+'</td><td class="tabla-alycar-texto" width="15%"><input type="hidden" name="vt_ant" id="vt_ant_'+i+'" value="'+OBLItxtTotal+'"/>'+OBLItxtTotal+'</td><td class="tabla-alycar-texto" width="15%"><a href="#" onclick="borrarFila('+i+'); return false">Eliminar</a></td></tr>';
					//alert(str);
					$('#detalle').append(str);
					$('#detalle').show();
					i = i+1;
					str ="";
					//$("#btnGrabar").show();
					if (document.getElementById("arr_repuesto").value!='') {
						if (OBLItxtCodProducto!=''){
							document.getElementById("arr_repuesto").value = document.getElementById("arr_repuesto").value +','+OBLItxtCodProducto;
							}
						else{
							document.getElementById("arr_repuesto").value = document.getElementById("arr_repuesto").value +','+OBLItxtDescProducto;	
							}
						}
					else
						{
						if (OBLItxtCodProducto!=''){
							document.getElementById("arr_repuesto").value = OBLItxtCodProducto;
							}
						else{
							document.getElementById("arr_repuesto").value = OBLItxtDescProducto;	
							}
						}
					
					if (document.getElementById("arr_nom_repuesto").value!='') 
						document.getElementById("arr_nom_repuesto").value = document.getElementById("arr_nom_repuesto").value +','+OBLItxtDescProducto;
					else
						document.getElementById("arr_nom_repuesto").value = OBLItxtDescProducto;
						
					if (document.getElementById("arr_cant").value!='') 
						document.getElementById("arr_cant").value = document.getElementById("arr_cant").value +','+OBLItxtCant;
					else
						document.getElementById("arr_cant").value = OBLItxtCant;
					
					if (document.getElementById("arr_pu").value!='') 
						document.getElementById("arr_pu").value = document.getElementById("arr_pu").value +','+OBLItxtNeto;
					else
						document.getElementById("arr_pu").value = OBLItxtNeto;
	
					if (document.getElementById("arr_vt").value!='') 
						document.getElementById("arr_vt").value= document.getElementById("arr_vt").value +','+OBLItxtTotal;
					else
						document.getElementById("arr_vt").value= OBLItxtTotal;
		
					var suma = document.getElementById("monto_total").value;
					if (suma ==''){
						suma = 0;
						}
					suma = parseInt(suma)+parseInt(OBLItxtTotal);
					document.getElementById("monto_total").value = parseInt(suma);
					document.getElementById("neto").value = Math.round(parseInt(suma)*0.81);
					document.getElementById("iva").value = Math.round(parseInt(suma)*0.19);					
					
					document.getElementById("txtCodProducto").value = ""; 
					document.getElementById("txtDescProducto").value = ""; 
					document.getElementById("txtCant").value= ""; 
					document.getElementById("txtNeto").value = ""; 
					document.getElementById("txtTotal").value = ""; 
					
					});	
				$("#txtCant, #txtNeto").blur(function(){
						var valor1 = $("#txtNeto").val();
						valor1=replaceAll(valor1, ".", "" );
						var valor2 = $("#txtCant").val();
						var valor_entregar = valor2*valor1;
						document.getElementById("txtTotal").value = valor_entregar;
					  });
				$( "#btnGrabar" ).click(function() {
					  $( "#dialog-confirm" ).dialog( "open" );
					});
				$( "#dialog-confirm" ).dialog({
					  autoOpen: false,
	  				  resizable: false,
					  height:200,
					  width:320,
					  modal: true,
					  buttons: {
						"Aceptar": function() {
						ValidaFormularioMantenedor();
						$( this ).dialog( "close" );
						},
						'Cancelar': function() {
						  $( this ).dialog( "close" );
						}
					  }
					});
				
			}); 
			function replaceAll( text, busca, reemplaza ){
					while (text.toString().indexOf(busca) != -1)
						text = text.toString().replace(busca,reemplaza);
					return text;
				  } 
			function borrarFila(indice){
				var vt_ant = $("#vt_ant_" + indice).attr('value');
				var suma = document.getElementById("monto_total").value;
				suma = parseInt(suma)-parseInt(vt_ant);
				document.getElementById("monto_total").value = parseInt(suma);
				document.getElementById("neto").value = Math.round(parseInt(suma)*0.81);
				document.getElementById("iva").value = Math.round(parseInt(suma)*0.19);		
				
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
		<div id="divcontenedor" >
			<form id="Form1" name="Form1" method="post" runat="server">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/02/PNG/onebit_21.png" width="48" height="48"></td>
									<td style="width: 93%"><label class="form-titulo">
											&nbsp;&nbsp; Ingreso Orden de Compra </label>
                                    <input type="hidden" id="arr_repuesto" name="arr_repuesto"/>
                                    <input type="hidden" id="arr_nom_repuesto" name="arr_nom_repuesto"/>
                                    <input type="hidden" id="arr_pu" name="arr_pu"/>
                                    <input type="hidden" id="arr_cant" name="arr_cant"/>
                                    <input type="hidden" id="arr_vt" name="arr_vt"/>
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							  <tr align="left">
							    <td class="tabla-alycar-label" style="width: 10%">Fecha:</td>
							    <td class="tabla-alycar-texto" ><input type="text" id="OBLI-txtFecha1" name="OBLI-txtFecha1" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" /></td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Empresa</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<input type="text" name="OBLIempresa" id="OBLIempresa"/>
                                    <input type="hidden" name="txt_empe" id="txt_empe" />
                                </td>
						      </tr>
                              <tr>
                              	<td class="tabla-alycar-label" colspan="4" align="left">
    							Proveedor                            
	                            </td>
                              </tr>
                              
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<input name="OBLIproveedores" id="OBLIproveedores" size="30"  />
							      	<input type="hidden" name="txt_prov" id="txt_prov" />
                                    <input type="button" name="mant_prov" id="mant_prov" onclick="xajax_LlamaMantenedorVxC(xajax.getFormValues('Form1'));" value="Ingresar Nuevo" class="boton"/>
                                </td>
							    <td class="tabla-alycar-label" style="width: 10%">&nbsp;</td>
							    <td class="tabla-alycar-texto" style="width: 20%">&nbsp;</td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Rut Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<div id="rut_proveedor"></div>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Direccion Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<div id="direccion_proveedor"></div>
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Telefono Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<div id="telefono_prov"></div>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Email Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<div id="email_prov"></div>
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Nombre contacto Proveedor:</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<div id="nc_prov"></div>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%"></td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                </td>
						      </tr>
                              <tr>
                              	<td class="tabla-alycar-label" colspan="4" align="left">
                                	Detalle
                                </td>
                              </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Tipo de Compra</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                    <select name="OBLItipo_compra" id="OBLItipo_compra"></select>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Centro Costo</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<select name="OBLIcentro_costo" id="OBLIcentro_costo"></select>
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Proyecto</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<select name="OBLIproyecto" id="OBLIproyecto"></select>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Area</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<select name="OBLIArea" id="OBLIArea">
                                    </select>
                                </td>
						      </tr>
	                          <tr>
	                           	<td class="tabla-alycar-label" colspan="4" align="left">
									Productos
                                </td>                              
                              </tr>
                              <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Detalle Productos</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%" colspan="3">
									Sin Productos<input type="radio" name="productos" id="sin_productos" />
                                	Con Productos<input type="radio" name="productos" id="con_productos" />
                                </td>
						      </tr>
	                          <tr>
                              	<td colspan="4">
                                	<table align="left" class="tabla-alycar" style="width: 100%" id="detalle-producto">                                        <tr align="left">
                                            <td class="tabla-alycar-label" align='center' style="width: 40%">Producto</td>
                                            <td class="tabla-alycar-label" align='center'>Cant.</td>
                                            <td class="tabla-alycar-label" align='center'>Neto</td>
                                            <td class="tabla-alycar-label" align='center'>Total</td>
                                            <td class="tabla-alycar-label" align='center'></td>
                                        </tr>								
                                        <tr align="left">
                                            <td class="tabla-alycar-label" align='left'>
                                                <INPUT type="text" id="txtCodProducto" name="txtCodProducto" value='' onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallas', 'ta_ncorr', 'ta_descripcion', 'txtCodProducto', 'txtDescProducto', '');" maxLength="10" style="width: 15%;" />
                                                <INPUT type="text" id="txtDescProducto" name="txtDescProducto" value='' maxLength="100" style="width: 75%;" />
                                            
                                            </td>
                                            <td class="tabla-alycar-label" align='center'>
                                                <INPUT type="text" id="txtCant" name="txtCant" onKeyPress="return SoloNumeros(this, event, 0)"  value='' maxLength="10" style="width: 75%;" />
                                            </td>
                                            <td class="tabla-alycar-label" align='center'>
                                                <INPUT type="text"  id="txtNeto" name="txtNeto" onKeyPress="return SoloNumeros(this, event, 0)" value=''  maxLength="10" style="width: 75%; " />
                                            </td>
                                            <td class="tabla-alycar-label" align='center'>
                                                <INPUT type="text"  id="txtTotal" name="txtTotal" onKeyPress="return SoloNumeros(this, event, 0)" value='' readonly maxLength="10" style="width: 75%; " />
                                            </td>
                                            <td class="tabla-alycar-label" align='center'>
                                                <input type="button" name="btnAgregar" id="btnAgregar" value="Agregar" class="boton" > 
                                            </td>
                                        </tr>
                                        </table>
                                        <table align="left" class="tabla-alycar" id="detalle" border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                        </table>
                                </td>
                              
                              </tr>
                              <tr>
                              	<td class="tabla-alycar-label" colspan="4" align="left">
                                	Condiciones de Pago
                                </td>
                              </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Monto Total</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<input type="text" name="monto_total" id="monto_total" onKeyPress="return SoloNumeros(this, event, 0)"/>
                                </td>
							    <td colspan="2">
                                <table>
                                <tr>
                                    <td width="20%" class="tabla-alycar-label" style="width: 10%">Neto</td>
                                    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                        <input type="text" name="neto" id="neto" readonly="readonly"/>
                                    </td>
                                    <td width="20%" class="tabla-alycar-label" style="width: 10%">Iva</td>
                                    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                        <input type="text" name="iva" id="iva" readonly="readonly"/>
                                    </td>
                                </tr>
                                </table>
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Forma Pago</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<select name="OBLIforma_pago" id="OBLIforma_pago"></select>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Nro de doc/cuotas</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
                                	<input type="text" name="OBLInro_cuotas" id="OBLInro_cuotas" onKeyPress="return SoloNumeros(this, event, 0)"/>
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Documento</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<select id="OBLIdocumento" name="OBLIdocumento">
                                    	<option value="1">Boleta</option>
                                    	<option value="2">Factura</option>
                                    </select>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%"></td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%"></td>
						      </tr>                              <tr>
                              	<td class="tabla-alycar-label" colspan="4" align="left">
                                	Condiciones de Entrega
                                </td>
                              </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Lugar de Entrega</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<select name="OBLIlugar_entrega" id="OBLIlugar_entrega">
                                    	<option value="1">En Bodega</option>
                                    	<option value="2">Direccion de Proveedor</option>
                                    	<option value="3">Otro</option>
                                    </select>
                                </td>
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Direccion</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<input type="text" name="direccion_entrega" id="direccion_entrega" />
                                </td>
						      </tr>
							  <tr align="left">
							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Plazo en dias</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%">
									<input type="text" name="OBLIplazo_dias" id="OBLIplazo_dias" onKeyPress="return SoloNumeros(this, event, 0)"/> dias
                                </td>
						      </tr>
                              <tr>
   							    <td width="20%" class="tabla-alycar-label" style="width: 10%">Observacion</td>
							    <td width="30%" class="tabla-alycar-texto" style="width: 20%" colspan="3" align="left">
									<textarea  name="observacion" id="observacion" cols="100" rows="3"></textarea>
                                </td>

                              </tr>
 							</table>
                                <table align="left" class="tabla-alycar"  border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                    <tr align="left">
                                        <td colspan="5" class="tabla-alycar-fila-botones">
                                            <input type="button" name="btnGrabar" id="btnGrabar" value="Grabar" class="boton" />
                                            <input type="button" name="btnNuevo" id="btnNuevo" value="Nuevo" class="boton" 
                                            onclick = "xajax_Nuevo(xajax.getFormValues('Form1'));"/>
    
                                        </td>
                                    </tr>
							
							</table>
						
					</td>
				</tr>
			</table>
			<div id="dialog-confirm" title="Ventana de Confirmacion">
              <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
              	Desea confirmar esta orden de compra?</p>
            </div>
            </form>
		</div>					
	</body>
</HTML>