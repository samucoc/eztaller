<?php /* Smarty version 2.6.18, created on 2016-04-05 09:59:52
         compiled from sg_informe_estado_cuenta.tpl */ ?>
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

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>		
		<?php echo '
                <script type="text/javascript">
			$(function($) { 
				$(\'#OBLI-txtFecha1\').mask("99/99/9999");
				$(\'#OBLI-txtFecha2\').mask("99/99/9999");
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
				$(\'#OBLI-txtFecha1,#OBLI-txtFecha2\').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#usuario").autocomplete({
					source : \'busquedas/busqueda_usuario.php\',
					select: function( event, ui ) {
						var rut = ui.item.id;
						document.getElementById(\'OBLI-txtCodCobrador\').value = rut;
						}
					});
				 $(window).load(function(){
					 xajax_CargaSelect(xajax.getFormValues(\'Form1\'),\'cboEmpresa\',\'empresas\',\'\',\'Todas\',\'empe_rut\', \'empe_desc\', \'\');
					 xajax_CargaSelect(xajax.getFormValues(\'Form1\'),\'cboTipo_Comb\',\'tipo_combustible\',\'\',\'Todos\',\'tip_com_ncorr\', \'nombre\', \'\');
					 xajax_CargaSelect(xajax.getFormValues(\'Form1\'),\'cboDepto\',\'departamentos\',\'\',\'Todos\',\'departamento_ncorr\', \'nombre\', \'\');
					 $("#btnGrabar").hide();
					 });
				}); 		
		</script>
		<script type="text/javascript" > 
			function verificaValor(temp){
				if (temp==\'\'){
					document.getElementById(\'OBLI-txtCodCobrador\').value="";
					}
				}
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Informe de Estado de Cuentas</label></td>
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
									<td class="tabla-alycar-label" style="width: 15%">Departamento:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <select name="cboDepto" id="cboDepto" ></select>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Periodo Asociado:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										Mes:
										<SELECT id="cboMes" name="cboMes" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='1'>Enero</option>
											<option value='2'>Febrero</option>
											<option value='3'>Marzo</option>
											<option value='4'>Abril</option>
											<option value='5'>Mayo</option>
											<option value='6'>Junio</option>
											<option value='7'>Julio</option>
											<option value='8'>Agosto</option>
											<option value='9'>Septiembre</option>
											<option value='10'>Octubre</option>
											<option value='11'>Noviembre</option>
											<option value='12'>Diciembre</option>
										</SELECT>
										&nbsp;&nbsp;
										A�o:
										<SELECT id="cboAnio" name="cboAnio" onKeyPress="return Tabula(this, event, 0)">
											<option value=''>- - Seleccione - -</option>
											<option value='2016'>2016</option>
											<option value='2017'>2017</option>
										</SELECT>
										
									</td>	
								</TR>
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