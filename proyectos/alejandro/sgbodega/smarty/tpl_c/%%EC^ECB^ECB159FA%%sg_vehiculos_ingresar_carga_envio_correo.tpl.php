<?php /* Smarty version 2.6.18, created on 2013-02-01 08:31:20
         compiled from sg_vehiculos_ingresar_carga_envio_correo.tpl */ ?>
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
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery-imask.js"></script>
		<?php echo '
		<script type="text/javascript">
			$(function($) { 
				$(\'#OBLI-txtFecha\').mask("99/99/9999");
				}
			); 		
		</script>		
		<script type="text/javascript">
			$(document).ready(function() { 
                            $("#trabajador").autocomplete({
                                source : \'busquedas/busqueda_persona.php\'
                                });
                            }); 
		</script>
		'; ?>

		
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Autoriza:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
                                                                            <select id="autoriza" name="autoriza"></select>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Trabajador:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
                                        <input type="hidden" name="carga_pers" id="carga_pers" value="<?php echo $this->_tpl_vars['carga_pers']; ?>
"/>
                                        <input name="trabajador" id="trabajador" value="<?php echo $this->_tpl_vars['nombre']; ?>
"/>
                                    </td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Monto a Solicitar:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="monto" name="monto" value='<?php echo $this->_tpl_vars['carga_monto']; ?>
' onKeyPress="return Tabula(this, event, 0)" />
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Texto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
                                                                            <input type="hidden" name="id_carga" id="id_carga" value="<?php echo $this->_tpl_vars['id']; ?>
"/> 
                                                                            <textarea name="detalle" id="detalle" cols="45" rows="10"></textarea>
									</td>
								</tr>
                                                                <tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Enviar Correo" class="boton" onclick="javascript: ValidaFormularioMantenedor();" />
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