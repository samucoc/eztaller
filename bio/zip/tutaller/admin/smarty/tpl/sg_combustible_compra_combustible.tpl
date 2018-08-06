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
				$("#OBLI-monto").iMask({
						   type   : 'number'
						 , decDigits   : 0
						 , decSymbol   : ''
						 , groupSymbol : '.'
				 });
				 $(window).load(function(){
					 xajax_CargaSelect(xajax.getFormValues('Form1'),'cboEmpresa','empresas','','','empe_rut', 'empe_desc', '');
					 xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipoCombustible','tipo_combustible','','','tip_com_ncorr', 'nombre', '');		
					 xajax_CargaSelect(xajax.getFormValues('Form1'),'cboDepartamento','departamentos','','','departamento_ncorr', 'nombre', '');
					 $("#btnGrabar").hide();
					 });
					 

			$('#btnAceptar').click(function(){
				var fecha = $("#OBLI-txtFecha1").val(); 
				var nombre_empresa = $('#cboEmpresa option:selected').text();
				var depto = $("#cboDepartamento option:selected").text();
				var tipo = $("#cboTipoCombustible option:selected").text();
				var monto = $("#OBLI-monto").val(); 

				var empresa = $('#cboEmpresa option:selected').val();
				var tipoCombustible = $("#cboTipoCombustible option:selected").val();
				var departamento = $("#cboDepartamento option:selected").val();
				
				str = '<div id="presu_'+i+'"><div class="floatLeft grilla-tab-fila-campo veinte">'+fecha+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+nombre_empresa+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+depto+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+tipo+'</div><div class="floatLeft grilla-tab-fila-campo veinte">'+monto+'</div><div class="floatLeft grilla-tab-fila-campo diez"><a href="#" onclick="borrarFila('+i+'); return false">Eliminar</a></div><br class="clearBoth"/></div>';
				//alert(str);
				$('#resultado').append(str);
				$('#resultado').show();
				i = i+1;
				str ="";
				$("#btnGrabar").show();
				
				if (document.getElementById("arr_fecha").value!='') 
					document.getElementById("arr_fecha").value = document.getElementById("arr_fecha").value +','+fecha;
				else
					document.getElementById("arr_fecha").value = fecha;
					
				if (document.getElementById("arr_empresa").value!='') 
					document.getElementById("arr_empresa").value = document.getElementById("arr_empresa").value +','+empresa;
				else
					document.getElementById("arr_empresa").value = empresa;

				if (document.getElementById("arr_depto").value!='') 
					document.getElementById("arr_depto").value = document.getElementById("arr_depto").value +','+departamento;
				else
					document.getElementById("arr_depto").value = departamento;
				
				if (document.getElementById("arr_tipo").value!='') 
					document.getElementById("arr_tipo").value = document.getElementById("arr_tipo").value +','+tipoCombustible;
				else
					document.getElementById("arr_tipo").value = tipoCombustible;
				
				if (document.getElementById("arr_monto").value!='') 
					document.getElementById("arr_monto").value= document.getElementById("arr_monto").value +','+monto;
				else
					document.getElementById("arr_monto").value= monto;
								
				});
			}); 		
		function borrarFila(indice){
			$("#presu_" + indice).remove();
			}
		</script>
		<style>
            .floatLeft {
                float:left;
                }
            .clearBoth{
                clear:both
                }
            .veinte{
                width:15%;
                }
            .diez{
                width:10%
                }
        </style>
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
									<td style="width: 7%" align='right'><img width="48" height="48" src="../images/SURTIDOR GASOIL 2.bmp"></td>

									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Compra de combustible</label>
                                    <input type="hidden" id="arr_fecha" name="arr_fecha"/>
                                    <input type="hidden" id="arr_empresa" name="arr_empresa"/>
                                    <input type="hidden" id="arr_depto" name="arr_depto"/>
                                    <input type="hidden" id="arr_tipo" name="arr_tipo"/>
                                    <input type="hidden" id="arr_monto" name="arr_monto"/>
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<INPUT type="text" id="OBLI-txtFecha1" name="OBLI-txtFecha1" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa:
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select id="cboEmpresa" name="cboEmpresa" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo Combustible:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select id="cboTipoCombustible" name="cboTipoCombustible" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Departamento:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select id="cboDepartamento" name="cboDepartamento" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
	                                    <input type="text" name="OBLI-monto" id="OBLI-monto" />
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnAceptar"  id="btnAceptar" value="Agregar" class="boton" />
										<input type="button" name="btnGrabar"  id="btnGrabar" value="Grabar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'))"/>
									</td>
								</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>					
        <div id="divlistado" align="left" style="margin-left:2px; padding: 2px;">
            <table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                <tr>
                    <td>
                        <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr align="left">
                                <td>
                                    <div id='divabonos'>
                                    	<div id="pivot" class="grilla-tab">										
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>Fecha</div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>Empresa</div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>Tipo Combustible</div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>Departamento</div>
                                            <div class="grilla-tab-fila-titulo floatLeft veinte" align='center'>Monto</div>
                                            <div class="grilla-tab-fila-titulo floatLeft diez" align='center'>Accion</div>
                                            <br class="clearBoth"/>
											<div id="resultado"></div>
                                        </div>
                                    </div>
                                </td>
                            </TR>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
	</body>
</HTML>