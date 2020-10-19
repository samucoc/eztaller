<?php /* Smarty version 2.6.18, created on 2013-12-18 16:37:35
         compiled from sg_bodega_aumentos_ajuste.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_bodega_aumentos_ajuste.tpl', 126, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Ajustes, Mermas y Castigos </title>
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
		<?php echo '
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFecha\').mask("99/99/9999");
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
						xajax_ConfirmaIngreso(xajax.getFormValues(\'Form1\'));
						$( this ).dialog( "close" );
						},
						\'Cancelar\': function() {
						  $( this ).dialog( "close" );
						}
					  }
					});
				}
			); 		
		</script>
		
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements[\'v_pivot_excel\'].value=document.getElementById(\'pivot\').innerHTML;
			document.getElementById(nombreformulario).target = \'iframe_pivot_excel\'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById(\'pivot\').innerHTML="";document.getElementById(\'pivot_filter\').innerHTML="";document.getElementById(\'div_grafico\').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		</script> 
		'; ?>

	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Ajustes, Mermas y Castigos<input type="hidden" name="ncorr" id="ncorr" value="<?php echo $this->_tpl_vars['ncorr']; ?>
"/></td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Empresa:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="OBLIcboEmpresa" name="OBLIcboEmpresa" onKeyPress="return SoloNumeros(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Fecha:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										
										<INPUT type="text" id="OBLItxtFecha" name="OBLItxtFecha" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 25%">Tipo de Movimiento:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 75%">
										<select name="estado" id="estado">
                                        	<option value="12">Ajuste Aumento</option>
                                        	<option value="13">Ajuste Merma</option>
                                        	<option value="14">Ajuste Castigo</option>
                                        </select>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Observación:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<textarea id="txtObservacion" name="txtObservacion" cols="50" rows="3" ></textarea>
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
										<INPUT type="text" id="OBLItxtCodProducto" name="OBLItxtCodProducto" value='' onKeyPress="return SoloNumeros(this, event, 5)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallas', 'ta_ncorr', 'ta_descripcion', 'OBLItxtCodProducto', 'OBLItxtDescProducto', '');document.getElementById('OBLItxtCant').focus();" maxLength="10" style="width: 15%">
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
              	Desea confirmar este movimiento?</p>
            </div>
		<?php echo '
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "OBLItxtFecha",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
		</script>
		'; ?>

	</body>
</HTML>