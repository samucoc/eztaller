<?php /* Smarty version 2.6.18, created on 2013-10-08 14:57:48
         compiled from sg_busqueda.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Busqueda </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		<?php echo '
		<script type="text/javascript">
			function init() {
				
				shortcut.add("ESC", function() {
					xajax_Salir(xajax.getFormValues(\'Form1\'));
				});
			}
			window.onload=init;
		</script>
		'; ?>

		
	</HEAD>
	<body onload="init(), xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<INPUT type="hidden" id="txtEntidad" name="txtEntidad" value='<?php echo $this->_tpl_vars['ENTIDAD']; ?>
' maxLength="50" size="50">
									<INPUT type="hidden" id="txtObj1" name="txtObj1" value='<?php echo $this->_tpl_vars['OBJ1']; ?>
'>
									<INPUT type="hidden" id="txtObj2" name="txtObj2" value='<?php echo $this->_tpl_vars['OBJ2']; ?>
'>
									<INPUT type="hidden" id="txtempresa" name="txtempresa" value='<?php echo $this->_tpl_vars['empresa']; ?>
'>
									
									<td class="tabla-alycar-label" style="width: 30%">Texto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTexto" name="txtTexto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="50" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Buscar Por:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboBuscarPor" name="cboBuscarPor" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value='01'>Nombre</option>
											<option value='02'>Rut</option>
										</SELECT>
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '1' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sectores', 'sect_cod', 'sect_desc');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '2' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.vendedores', 'VE_CODIGO', 'VE_VENDEDOR');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '21' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vendedores', 'VE_CODIGO', 'VE_VENDEDOR');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '3' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'clientes', 'clie_rut', 'clie_nombre');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '4' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '5' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'cobrador', 'CO_CODIGO', 'CO_NOMBRE');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '6' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'supervisor', 'sp_codigo', 'sp_nombre');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '7' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '10' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'personas', 'pers_rut', 'pers_nombre');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '11' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vehiculos', 'veh_ncorr', 'veh_patente');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '12' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'trabajadores', 'rut', '');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == '13' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'trabajadores', 'rut', '');">
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['ENTIDAD'] == 'articulo' )): ?>
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion');">
										<?php endif; ?>
										<input type="button" name="btnSalir" value="Salir" class="boton" onclick="xajax_Salir(xajax.getFormValues('Form1'));">
										
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>&nbsp;
										
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