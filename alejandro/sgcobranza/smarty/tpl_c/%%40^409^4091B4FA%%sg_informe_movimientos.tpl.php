<?php /* Smarty version 2.6.18, created on 2011-01-23 03:21:27
         compiled from sg_informe_movimientos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informe_movimientos.tpl', 93, false),)), $this); ?>
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
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
			
		<?php echo '
		
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFecha1\').mask("99/99/9999");
				$(\'#OBLItxtFecha2\').mask("99/99/9999");
				
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
		</script> 

		'; ?>

	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Gnome-Edit-Find-Replace-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Informe de Movimientos Por Trabajador</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Empresa:<label class="requerido"> * </label></td>
									<td colspan='3' class="tabla-alycar-texto" style="width: 28%">
										<INPUT type="hidden" id="txtRutEmpresa" name="txtRutEmpresa">
										<SELECT id="OBLIcboEmpresa" name="OBLIcboEmpresa" style="width: 32%" onchange="xajax_MuestraUltCierre(xajax.getFormValues('Form1'));" onKeyPress="return Tabula(this, event, 0)">
										</SELECT>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Rango:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 28%">
										<INPUT type="text" id="OBLItxtFecha1" name="OBLItxtFecha1" value='' maxLength="10" size='9' readonly>
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="OBLItxtFecha2" name="OBLItxtFecha2" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 42%">
										<INPUT type="text" id="OBLItxtCodTrabajador" name="OBLItxtCodTrabajador" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'trabajadores', 'trab_ncorr', 'trab_nombres', 'OBLItxtCodTrabajador', 'OBLItxtDescTrabajador', '1');" value='' maxLength="10" size="2">
										<INPUT type="text" id="OBLItxtDescTrabajador" name="OBLItxtDescTrabajador" readonly value='' maxLength="100" size="28">
										&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
									</td>	
								</tr>
							
							</table>
							<div id='divdetalle' style="display: block;">
								<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr align="left">
										<td colspan='2'>
											<div id='divresultado'><div>
										</td>
									</TR>
								</table>
							
							</div>	
							
							<!--
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_fondos_asignados.php';"> 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							</table>
							-->
							
						
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>