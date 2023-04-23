<?php
/* Smarty version 3.1.33, created on 2020-10-19 00:52:05
  from 'C:\xampp\htdocs\eztaller\alejandro\sgbodega\smarty\tpl\sg_orden_trabajo_ingreso.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f8d0d65791e75_20016980',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '248b9dacda018b12a939bec0487bec07615b85c3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\eztaller\\alejandro\\sgbodega\\smarty\\tpl\\sg_orden_trabajo_ingreso.tpl',
      1 => 1603079520,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8d0d65791e75_20016980 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\htdocs\\eztaller\\alejandro\\sgbodega\\includes\\php\\cls_smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title> Orden de Trabajo </title>
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
				$('#OBLItxtFechaInicio, #OBLItxtFechaFin ').mask("99/99/9999");
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
						xajax_ConfirmaIngreso(xajax.getFormValues('Form1'));
						$( this ).dialog( "close" );
						},
						'Cancelar': function() {
						  $( this ).dialog( "close" );
						}
					  }
					});
				}
			); 		
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
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements['v_pivot_excel'].value=document.getElementById('pivot').innerHTML;
			document.getElementById(nombreformulario).target = 'iframe_pivot_excel'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById('pivot').innerHTML="";document.getElementById('pivot_filter').innerHTML="";document.getElementById('div_grafico').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		<?php echo '</script'; ?>
> 
		
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Orden de Trabajo
									<input type="hidden" name="ncorr" id="ncorr" value="<?php echo $_smarty_tpl->tpl_vars['ncorr']->value;?>
"/>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha Inicio:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										
										<INPUT type="text" id="OBLItxtFechaInicio" name="OBLItxtFechaInicio" value='<?php echo smarty_modifier_date_format(time(),"%d/%m/%Y");?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha Termino:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										
										<INPUT type="text" id="OBLItxtFechaFin" name="OBLItxtFechaFin" value='<?php echo smarty_modifier_date_format(time(),"%d/%m/%Y");?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 25%">Cliente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 75%">
										<INPUT type="text" id="OBLI-txtCodCobrador" name="OBLI-txtCodCobrador" value='' onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_BuscaCliente(xajax.getFormValues('Form1'),'OBLI-txtCodCobrador', 'OBLI-txtDescCobrador');" maxLength="10" size="10">
										<INPUT type="text" id="OBLI-txtDescCobrador" name="OBLI-txtDescCobrador" value='' maxLength="100" size="50" readonly>
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=2&obj1=OBLI-txtCodCobrador&obj2=OBLI-txtDescCobrador', 'Busca Cliente', 550, 350, null);"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<textarea id="txtObservacion" name="txtObservacion" cols="50" rows="3"></textarea>
									</td> 
								</TR>
								
								<div align="left" style="display: none;">
									<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
									<!--<input type='button' value='Excel' onclick="enviaPivotExcel('form1');" />!-->
									<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
								</div>
							</table>
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Listado de Productos</td>
								</tr>
							</table>	
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <td class="grilla-tab-fila-campo" style="width: 45%" align='center'>Producto                                        <a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=4&obj1=OBLItxtCodProducto&obj2=OBLItxtDescProducto', 'Busca Artículo', 550, 350, null);"></a>
									</td>
									<td class="grilla-tab-fila-campo" style="width: 7%" align='center'>Cant.</td>
									<td class="grilla-tab-fila-campo" align='center'></td>
								</tr>								
								
								<tr>
									<td class="grilla-tab-fila-campo" style="width: 38%" align='left'>
										<INPUT type="text" id="OBLItxtCodProducto" name="OBLItxtCodProducto" value='' onKeyPress="return SoloNumeros(this, event, 5)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'tallasnew', 'ta_ncorr', 'ta_descripcion', 'OBLItxtCodProducto', 'OBLItxtDescProducto', '');document.getElementById('OBLItxtCant').focus();" maxLength="10" style="width: 15%">
										<INPUT type="text" id="OBLItxtDescProducto" name="OBLItxtDescProducto" value='' maxLength="100" style="width: 75%" readonly>
									
									</td>
									<td class="grilla-tab-fila-campo" style="width: 7%" align='center'>
										<INPUT type="text" style="width: 99%" id="OBLItxtCant" name="OBLItxtCant" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))" value='' maxLength="10">
									</td>
									<td class="grilla-tab-fila-campo" align='left'>
										<input type="button" name="btnAgregar" value="Agregar" class="boton" onclick="javascript: ValidaFormularioMantenedor();"> 
									</td>
								</tr>								
								
							</table>
							<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr align="left">
									<td colspan='2'>
										<div id='divresultadoarticulos'></div>
									</td>
								</TR>
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" id="btnGrabar" value="Grabar" class="boton" /> 
										<input type="button" id="btnNuevo" name="btnNuevo" value="Nuevo" class="boton" onclick="xajax_Nueva(xajax.getFormValues('Form1'));">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
		</form>
		<div id="calendar-container"></div>
			<div id="dialog-confirm" title="Ventana de Confirmacion">
              <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
              	Desea confirmar esta order de trabajo?</p>
            </div>
		
		<!-- calendario 3-->
		<?php echo '<script'; ?>
 type="text/javascript">
			Calendar.setup({inputField : "OBLItxtFechaInicio",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
			Calendar.setup({inputField : "OBLItxtFechaFin",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
		<?php echo '</script'; ?>
>
		
	</body>
</HTML>
<?php }
}
