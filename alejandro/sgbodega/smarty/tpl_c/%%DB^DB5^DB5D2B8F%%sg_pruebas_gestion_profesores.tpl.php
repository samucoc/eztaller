<?php /* Smarty version 2.6.18, created on 2016-05-06 20:59:58
         compiled from sg_pruebas_gestion_profesores.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
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
                                    document.getElementById(\'OBLIRutAlumno\').value = rut;
                                    }
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
 		</script> 
 		<style>
 				img[title]:hover:after {
  content: attr(title);
  padding: 20px 20px;
  color: #333;
  position: absolute;
  left: 0;
  top: 100%;
  z-index: 20;
  white-space: nowrap;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  -moz-box-shadow: 0px 0px 4px #222;
  -webkit-box-shadow: 0px 0px 4px #222;
  box-shadow: 0px 0px 4px #222;
  background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #eeeeee),color-stop(1, #cccccc));
  background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -ms-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -o-linear-gradient(top, #eeeeee, #cccccc);
}
 		</style>
		'; ?>

	
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
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Consulta Ingreso de Notas</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">A�o:</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<select id="anio" name="anio" onchange="xajax_CargaPeriodos(xajax.getFormValues('Form1'));">
                                    	<option value="">Elija Opcion</option>
                                        <option value="2016">2016</option>
									  </select>
                                  </td>
							  	</tr> 
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Semestre:</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<select id="semestre" name="semestre">
                                    </select>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Curso:</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<select id="curso" name="curso"  onchange="				xajax_CargaPruebas(xajax.getFormValues('Form1'));"></select>
                                  </td>
							  	</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Profesores:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<select name="profesores" id="profesores" onchange="">
                                        </select>
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<a href="#" onclick="xajax_CargaListado(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
										</a>
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