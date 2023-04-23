<?php
/* Smarty version 3.1.33, created on 2020-05-05 21:53:07
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_importar_matriculas_nro_lista_alumnos.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5eb21883c49072_77182933',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '35a369ad64694328c08189baa8a1c86366c6d4bd' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_importar_matriculas_nro_lista_alumnos.tpl',
      1 => 1579573424,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5eb21883c49072_77182933 (Smarty_Internal_Template $_smarty_tpl) {
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
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/common.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal.js"><?php echo '</script'; ?>
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
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/shortshut.js"><?php echo '</script'; ?>
>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"><?php echo '</script'; ?>
>
                        <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"><?php echo '</script'; ?>
>
                        <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery-imask.js"><?php echo '</script'; ?>
>
		
		<?php echo '<script'; ?>
 type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFecha').mask("99/99/9999");
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
				$('#OBLI-txtFecha').datepicker({
					  showOn: "button",
					  buttonImage: "../images/calendario.png",
					  buttonImageOnly: true,
					  dateFormat : "dd/mm/yy"
					}); 
				$("#OBLItxtMontoIngresar").iMask({
						   type   : 'number'
						 , decDigits   : 0
						 , decSymbol   : ''
						 , groupSymbol : '.'
				});
			});
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresi�n.");
				  
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
				 // A�ade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el c�digo en PHP
				 $("#" + id_form).submit();
			}
 		<?php echo '</script'; ?>
> 

		
	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server" enctype="multipart/form-data">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Search files-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Importar Matriculas y Nro. Lista</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha Matricula</td>
									<td class="tabla-alycar-texto" >
										<input type="text" name="OBLI-txtFecha" id="OBLI-txtFecha" />
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Archivo</td>
									<td class="tabla-alycar-texto" >
										<input type="file" name="archivo" id="archivo" accept=".xlsx" />
										<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />	
										|| Archivo a importar debe tener las siguientes columnas : Rut | CodigoCurso | Nro Matricula | Nro Lista
									</td>
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="submit" name="btnBuscar"  id="btnBuscar" value="Grabar" class="boton" >
									</td>
								</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>		
		
	</body>
</HTML><?php }
}
