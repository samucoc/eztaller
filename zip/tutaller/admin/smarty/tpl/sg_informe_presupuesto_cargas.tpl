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
		{literal}
                <script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha1').mask("99/99/9999");
				$('#OBLI-txtFecha2').mask("99/99/9999");
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
				$('#OBLI-txtFecha1,#OBLI-txtFecha2').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#usuario").autocomplete({
					source : 'busquedas/busqueda_usuario.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById('OBLI-txtCodCobrador').value = rut;
						}
					});
				$(window).load(function(){
					xajax_CargaSelect(xajax.getFormValues('Form1'),'cboEmpresa','empresas','','Todas','empe_rut', 'empe_desc', '');
					xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo_Comb','tipo_combustible','','Todos','tip_com_ncorr', 'nombre', '');
					$("#btnGrabar").hide();
					});
				$(document).on('blur', '.cambio_extras', function(){ 
					var id = $(this).attr('id');
					//"txt_extras_97_12345678
					var octanaje 	= id.substring(11,13);
					var rut = '';
					var rut			= id.substring(14,22);
					if (octanaje =='DI'){
						octanaje = 'DIESEL';
						rut 	= id.substring(18,27);
						}
					
					var valor_asignacion 	= $("#txt_asignaciones_"+octanaje+"_"+rut).val();
					var valor_extra			= $("#txt_extras_"+octanaje+"_"+rut).val();
					var presupuesto			= parseInt(valor_asignacion)+parseInt(valor_extra);
					var valor_comprado		= $("#txt_comprado_"+octanaje+"_"+rut).val();
					var diferencia			= parseInt(valor_comprado) - parseInt(presupuesto);
					document.getElementById("lbl_presupuesto_"+octanaje+"_"+rut).innerHTML =  presupuesto;
					document.getElementById("txt_presupuesto_"+octanaje+"_"+rut).value = presupuesto;
					document.getElementById("lbl_diferencia_"+octanaje+"_"+rut).innerHTML = diferencia;
					document.getElementById("txt_diferencia_"+octanaje+"_"+rut).value = diferencia;
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
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
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

		{/literal}
	
	</HEAD>
	<body style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Checklist-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Informe de Presupuesto de Cargas</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select name="cboEmpresa" id="cboEmpresa" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Combustible:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select name="cboTipo_Comb" id="cboTipo_Comb" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLI-txtFecha1" name="OBLI-txtFecha1" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										    al
                                        <INPUT type="text" id="OBLI-txtFecha2" name="OBLI-txtFecha2" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							
							</table>
						</form>
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
	</body>
</HTML>