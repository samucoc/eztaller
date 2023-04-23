<?php /* Smarty version 2.6.18, created on 2014-02-17 11:47:35
         compiled from sg_consulta_stock_vendedor.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Consulta Stock Vendedor </title>
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
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		<?php echo '
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
			
			
			<div id="divcontenedor" align="left" style="display: block; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Consulta Stock Vendedor</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Empresa:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="OBLI-cboEmpresa" name="OBLI-cboEmpresa" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_BuscaUltGuia(xajax.getFormValues('Form1'));"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Vendedor:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="OBLI-txtCodCobrador" name="OBLI-txtCodCobrador" value='' onKeyPress="return SoloNumeros(this, event, 3)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'vendedores', 'VE_CODIGO', 'VE_VENDEDOR', 'OBLI-txtCodCobrador', 'OBLI-txtDescCobrador', '');" maxLength="10" size="10">
										<INPUT type="text" id="OBLI-txtDescCobrador" name="OBLI-txtDescCobrador" value='' maxLength="100" size="50" readonly>
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=2&obj1=OBLI-txtCodCobrador&obj2=OBLI-txtDescCobrador', 'Busca Vendedor', 550, 350, null);"></a>
									
										<!--
										<INPUT type="hidden" id="txtUltGuia" name="txtUltGuia" value=''>
										<INPUT type="hidden" id="txtFechaDesde" name="txtFechaDesde" value=''>
										-->
										
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Ultima Guía Inicial:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="txtUltGuia" name="txtUltGuia" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
									
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Periodo:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										
										<!--
										<INPUT type="text" id="OBLI-txtFechaDesde" name="OBLI-txtFechaDesde" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
										!-->
										
										<INPUT type="text" id="txtFechaDesde" name="txtFechaDesde" value='' onKeyPress="return SoloNumeros(this, event, 0)" readonly maxLength="10" size="10">
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="OBLI-txtFechaHasta" name="OBLI-txtFechaHasta" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
										
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Producto:</td>
								
									<td class="tabla-alycar-texto" style="width: 80%" align='left'>
										<INPUT type="text" id="txtCodProducto" name="txtCodProducto" value='' onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion', 'txtCodProducto', 'txtDescProducto', '');" maxLength="10" size="10">
										<INPUT type="text" id="txtDescProducto" name="txtDescProducto" value='' maxLength="100" size="50" readonly>
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=4&obj1=txtCodProducto&obj2=txtDescProducto', 'Busca Artículo', 550, 350, null);"></a>
									
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Filtro:</td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="cboFiltro" name="cboFiltro" onKeyPress="return Tabula(this, event, 0)">
											<option value='1'>Todos</option>
											<option value='2'>Solo Productos con Stock</option>
										</SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>
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
										<div id='divnoencontrados'><div>
									</td>
								</TR>
								<tr align="left">
									<td>
										<div id='divabonos'><div>
									</td>
								</TR>
								<tr align="left">
									<td>
										<div id='divrevision' style="display: none;"><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
			
			<div align="left" style="display: none;">
				<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
				<!--<input type='button' value='Excel' onclick="enviaPivotExcel('form1');" />!-->
				<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
			</div>
		</form>
		<div id="calendar-container"></div>
	
		<?php echo '
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "OBLI-txtFechaHasta",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
		</script>
		'; ?>

	</body>
</HTML>