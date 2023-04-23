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

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>		
            <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>
		{literal}
        <script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha1,#fecha_cant_rec').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			var i =0;
			var str ="";
			$(window).load(function(){
				xajax_CargaPagina(xajax.getFormValues('Form1')); 
				xajax_CargaSelects(xajax.getFormValues('Form1'));
				});
			$(document).ready(function() { 
				$.datepicker.regional['es'] = {
					  closeText: 'Cerrar',
					  prevText: 'Ant',
					  nextText: 'Sig',
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
				$('#OBLI-txtFecha1,#fecha_cant_rec').datepicker({
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
				$("#es_bodega").on('change',function(){
					var valor = $("#es_bodega").val();
					if (valor=='0'){
						document.getElementById('oculto').style.display = 'table-row';
						}
					else{
						document.getElementById('oculto').style.display = 'none';
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
	
					str = '<tr id="presu_'+i+'" align="left"><td class="tabla-alycar-texto" width="40%"><input type="hidden" name="id_repuesto_ant" id="id_repuesto_ant_'+i+'" value="'+id_repuesto+'"/>'+OBLItxtCodProducto+' '+OBLItxtDescProducto+'</td><td class="tabla-alycar-texto" width="15%">'+OBLItxtCant+'</td><td class=" tabla-alycar-texto" width="15%"></td><td class=" tabla-alycar-texto" width="15%">'+OBLItxtNeto+'</td><td class="tabla-alycar-texto" width="15%"><input type="hidden" name="vt_ant" id="vt_ant_'+i+'" value="'+OBLItxtTotal+'"/>'+OBLItxtTotal+'</td><td class="tabla-alycar-texto" width="15%"><a href="#" onclick="borrarFila('+i+'); return false">Eliminar</a></td></tr>';
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
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr>
                                <td colspan="4">
                                <table class="tabla-alycar">
                                    <tr>
                                        <td class="tabla-alycar-label" colspan="5" align="left">
                                            Ingreso Cantidades Recibidas
                                            <input type="hidden" name="nro_oc" id="nro_oc" value="{$nro_oc}"/>
                                        </td>                              
	                                </tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                            Fecha
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
                                            <input type="text" id="fecha_cant_rec" name="fecha_cant_rec" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" value="{$fecha}" />
                                        </td>                              
									</tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                            Factura
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
                                            <input type="text" id="factura" name="factura" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" value="{$factura}" />
                                        </td>                              
									</tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                            Guia Despacho
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
                                            <input type="text" id="guia_despacho" name="guia_despacho" value="" onkeypress="return SoloNumeros(this, event, 0)" maxlength="10" size="10" value="{$guia_despacho}" />
                                        </td>                              
									</tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                            Vendedor o Bodega??
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
                                            <select name="es_bodega" id="es_bodega">
                                                <option value="0">Vendedor</option>
                                                <option value="1">Bodega</option>
                                            </select>
	                                </td>                              
									</tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                        	Observacion
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
                                        	<textarea name="observacion" id="observacion"></textarea>    
	                                	</td>                              
									</tr>
                                    <tr id="oculto">
                                        <td class="tabla-alycar-label" align="left" style='width:12%'>
                                            Vendedor
                                        </td>      
                                        <td class="tabla-alycar-texto" align="left">
											<INPUT type="text" id="OBLItxtCodVendedor" name="OBLItxtCodVendedor" tabindex="4" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sgyonley.vendedores', 'VE_CODIGO', 'VE_VENDEDOR', 'OBLItxtCodVendedor', 'OBLItxtDescVendedor', '');" maxLength="10" size="10" value="{$cod_vendedor}" />
											<INPUT type="text" id="OBLItxtDescVendedor" name="OBLItxtDescVendedor" maxLength="100" size="50" readonly value="{$nombre_vendedor}"/>
											<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=2&obj1=OBLItxtCodVendedor&obj2=OBLItxtDescVendedor', 'Busca Vendedor', 550, 350, null);"></a>
    	                                </td>                              
									</tr>
                                    <tr>
                                        <td class="tabla-alycar-label" align="left" style='width:40%'>
                                            Producto
                                        </td>   
                                        <td class="tabla-alycar-texto" align="left">
                                            <INPUT type="text" id="txtCodProducto" name="txtCodProducto" value='' onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallas', 'ta_ncorr', 'ta_descripcion', 'txtCodProducto', 'txtDescProducto', '{$nro_oc}');" maxLength="10" style="width: 15%;" />
                                            <INPUT type="text" id="txtDescProducto" name="txtDescProducto" value='' maxLength="100" style="width: 75%;" />
                                        	<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=4&obj1=txtCodProducto&obj2=txtDescProducto', 'Busca Articulo', 550, 350, null);"></a>
                                        </td>                             
 									</tr>                         
                                    <tr>
                                        <td class="tabla-alycar-label" align="left">
                                            Cant. Recepcionada
                                        </td>  
                                        <td class="tabla-alycar-texto" align="left">
                                            <input type="text" name="cant_rec" id="cant_rec" onkeypress="return SoloNumeros(this, event, 0)" />
 	                                    </td>                              
    								</tr>                        
                                    <tr>    
                                        <td class="tabla-alycar-label" align="left">
                                            Precio Unitario Bruto
                                        </td>                                                            
                                        <td class="tabla-alycar-texto" align="left">
                                            <input type="text" name="precio" id="precio" onkeypress="return SoloNumeros(this, event, 0)" />
                                        </td>                                                            

                                    </tr>
                                    <tr>
                                        <td class="tabla-alycar-texto" align="left" colspan="4">
                                        	<input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Agregar" onclick="xajax_AgregarCantRec(xajax.getFormValues('Form1'))"/>
                                        </td>                                                            
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="4" >
                                	<table id="detalle_producto" align="left" class="tabla-alycar"  border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                    </table>	
                                </td>
                            </tr>
                            <tr>
	                            <td class="tabla-alycar-texto" align="left" colspan="4">
                                	<input type="hidden" name="movim_ncorr" id="movim_ncorr"/>
                                    <input type="button" class="boton" name="btnAgregar" id="btnAgregar" value="Confirmar Guia" onclick="xajax_Grabar(xajax.getFormValues('Form1'))"/>
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
