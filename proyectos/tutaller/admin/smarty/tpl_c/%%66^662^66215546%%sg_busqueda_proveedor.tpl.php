<?php /* Smarty version 2.6.18, created on 2015-02-04 10:53:05
         compiled from sg_busqueda_proveedor.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Busqueda </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- estilos  -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Texto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTexto" name="txtTexto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="50" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Buscar Por:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboBuscarPor" name="cboBuscarPor" onKeyPress="return Tabula(this, event, 0)">
											<option value='01'>Descripcion</option>
											<option value='02'>Codigo</option>
										</SELECT>
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.proveedor', 'pr_rut', 'pr_razon');">
										<input type="button" name="btnSalir" value="Salir" class="boton" onclick="xajax_Salir(xajax.getFormValues('Form1'));">
										
										<INPUT type="hidden" id="txtObj1" name="txtObj1" value='<?php echo $this->_tpl_vars['OBJ1']; ?>
'>
										<INPUT type="hidden" id="txtObj2" name="txtObj2" value='<?php echo $this->_tpl_vars['OBJ2']; ?>
'>
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										&nbsp;
									</td>
								</TR>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'><div>
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