<?php
/* Smarty version 3.1.33, created on 2019-10-23 19:03:00
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_alumnos_Asistencia.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5db0ce14f0c921_52834011',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba0d2d2fa5d76df23f36ab814dd8648091afa57d' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_alumnos_Asistencia.tpl',
      1 => 1571868121,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5db0ce14f0c921_52834011 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar.js"><?php echo '</script'; ?>
>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/lang/calendar-es.js"><?php echo '</script'; ?>
>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar-setup.js"><?php echo '</script'; ?>
>
                
        <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/common.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal.js"><?php echo '</script'; ?>
>
		
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"><?php echo '</script'; ?>
>
                        <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"><?php echo '</script'; ?>
>
                        
		
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
        <?php echo '<script'; ?>
 type="text/javascript">
			$(function($) { 
				$('#fecha1').mask("99-99-9999");
				$('#fecha2').mask("99-99-9999");
				}
			); 		
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript">
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
                            $('#fecha1,#fecha2').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd-mm-yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : 'busquedas/busqueda_alumno.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLIRutAlumno').value = rut;
                                    }
                                });
                             
                            });
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" > 
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
			function carga_pruebas(){
				var asignatura = document.getElementById("asignaturas").value;
				xajax_CargaPruebas(xajax.getFormValues('Form1'),asignatura);
				}
 		<?php echo '</script'; ?>
> 

		
	
	</HEAD>
	<body style="background:#ffffff;" onload="xajax_CargaListado(xajax.getFormValues('Form1'))"> 
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
									<td style="width: 93%">
                                    	<label class="form-titulo">&nbsp;&nbsp;Asistencia <label id="alumno" name="alumno"></label></label>
                                        <input type="hidden" name="rut" id="rut" value="<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
"/>
                                    </td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
											<a href="#" onclick="location.href='sg_mant_alumnos.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/ficha-alumno.png' title='Fichas Alumnos' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_notas.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/promedio.png' title='Notas' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_HojaVida.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_fin/respaldos.png' title='Hoja de vida' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Asistencia.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/fin_comp/bitacora.png' title='Asistencia' width="32"/>
											</a>
											<a href="#" onclick="location.href='sg_alumnos_Apoderado.php?rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'">
												<img src='../images/gest_esc/ficha-apoderado.png' title='Apoderados' width="32"/>
											</a>
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=BitacorasAcademicas&rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'" title="Bit&aacute;cora Acad&eacute;mica" >
												<img src='../images/fin_comp/bitacora.png' title="Bit&aacute;cora Acad&eacute;mica"  width="32" id="imagen_bitacora"  />
											</a>	
											<a href="#" id="contenedor" onclick="location.href='sg_mant_tablas.php?tbl=Entrevistas&rut=<?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
&readonly=<?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
'" title="Departamento Psicolog&iacute;a" >
												<img src='../images/basicos/ficha-psicolgo.png' title="Departamento Psicolog&iacute;a"  width="32" id="imagen_bitacora"  />
											</a>						
                                    	</td>
                                    </tr>
                                <!--
                                <tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Fecha inicio:</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<input type="text" id="fecha1" name="fecha1" onkeypress="return SoloNumeros(this, event, 0)"  />
                                  </td>
							  	</tr> 
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Fecha Fin:</td>
								  <td class="tabla-alycar-texto" style="width: 20%">
                                  	<input type="text" id="fecha2" name="fecha2" onkeypress="return SoloNumeros(this, event, 0)"  />
                                  </td>
							  	</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
																				<a href="#" onclick="xajax_CargaListado(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/buscar.png' title='Grabar' width="32"/>
										</a>
									&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
								-->
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
</HTML><?php }
}
