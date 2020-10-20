<?php /* Smarty version 2.6.18, created on 2018-11-21 15:18:34
         compiled from sg_becas_reporte_alumnos_becados.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Informe de Precargas </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
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
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
			<script type="text/javascript" src="../includes_js/tablejs.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
					
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
		<?php echo '
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
					val2 = \'\'
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
					val = \'\'
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
				$(\'#txtFecha1\').mask("99/99/9999");
				$(\'#txtFecha2\').mask("99/99/9999");
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
                            $(\'#txtFecha1,#txtFecha2\').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : \'busquedas/busqueda_alumno.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'rut\').value = rut;
                                    }
                                });
                             $("#btnExport").on(\'click\', function (e) {
								    window.open(\'data:application/vnd.ms-excel,\' + $(\'#tabla\').html());
								    e.preventDefault();
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
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
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
			function carga_pruebas(){
				var asignatura = document.getElementById("asignaturas").value;
				xajax_CargaPruebas(xajax.getFormValues(\'Form1\'),asignatura);
				}
 		</script> 

		'; ?>

	</HEAD>
	<body  onload="xajax_CargaPagina(xajax.getFormValues('Form1'));"  style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">Informe de Becados</label></td>
								</tr>
							</table>
							<br>
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" >Periodo:</td>
									<td class="tabla-alycar-texto" >
										<select name="anio" id="anio" >											
         								</select>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" >Condicion:</td>
									<td class="tabla-alycar-texto" >
										<select name="todos" id="todos">
											<option value="TODOS">TODOS</option>
											<option value="BECADOS">BECADOS</option>
											<option value="NO-BECADOS">NO BECADOS</option>
         								</select>
									</td>
								</TR>
								<tr align="left">
									<td colspan="1" class="tabla-alycar-fila-botones">
										<a href="#" onclick="xajax_Buscar(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
										</a>
									</td>							
                                </tr>
								<tr align="left">
									<td colspan='2'>
										<div id='divabonos'></div>
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