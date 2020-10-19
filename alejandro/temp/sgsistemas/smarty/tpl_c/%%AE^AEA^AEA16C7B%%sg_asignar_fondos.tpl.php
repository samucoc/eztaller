<?php /* Smarty version 2.6.18, created on 2011-01-24 01:37:47
         compiled from sg_asignar_fondos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_asignar_fondos.tpl', 58, false),)), $this); ?>
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
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
			
		<?php echo '
		
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFecha\').mask("99/99/9999");
				}
			); 		
		</script>

		'; ?>

	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Money_Safe1_48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Asignar Fondos</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Fecha Asignación:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="OBLItxtFecha" name="OBLItxtFecha" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size='9'>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Empresa:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<SELECT id="OBLIcboEmpresa" name="OBLIcboEmpresa" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Sector:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="OBLItxtCodSector" name="OBLItxtCodSector" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sgyonley.sectores', 'sect_cod', 'sect_desc', 'OBLItxtCodSector', 'OBLItxtDescSector', '1');" value='' maxLength="10" size="9">
										<INPUT type="text" id="OBLItxtDescSector" name="OBLItxtDescSector" readonly value='' maxLength="100" size="40">
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Trabajador:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="OBLItxtCodTrabajador" name="OBLItxtCodTrabajador" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'trabajadores', 'trab_ncorr', 'trab_nombres', 'OBLItxtCodTrabajador', 'OBLItxtDescTrabajador', '1');" value='' maxLength="10" size="9">
										<INPUT type="text" id="OBLItxtDescTrabajador" name="OBLItxtDescTrabajador" readonly value='' maxLength="100" size="40">
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Monto Asignado:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="OBLItxtMonto" name="OBLItxtMonto" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="15" size="9">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Banco:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<SELECT id="OBLIcboBanco" name="OBLIcboBanco" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Nº Cheque:</td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="txtNumCheque" name="txtNumCheque" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="9">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Nº Comp. Depósito:</td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<INPUT type="text" id="txtNumDeposito" name="txtNumDeposito" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="20" size="9">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label-peq" style="width: 20%">Observaciones:</td>
									<td class="tabla-alycar-texto-peq" style="width: 80%">
										<textarea id="txtObservacion" name="txtObservacion" cols="40" rows="3" ></textarea>
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.location.href='sg_mant_trabajadores.php';" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>