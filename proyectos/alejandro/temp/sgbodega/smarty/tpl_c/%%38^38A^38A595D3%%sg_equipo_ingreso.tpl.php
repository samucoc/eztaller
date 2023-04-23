<?php /* Smarty version 2.6.18, created on 2013-08-22 16:23:20
         compiled from sg_equipo_ingreso.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_equipo_ingreso.tpl', 114, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
               <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
            <link rel="stylesheet" type="text/css" href="../includes_js/uploadify/uploadify.css"/>
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/uploadify/jquery.uploadify.js"></script>

            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>



		<?php echo '
		    <script type="text/javascript">
			$(function($) { 
				$(\'#OBLItxtFechaRevision\').mask("99/99/9999");
				}
			); 		
			</script>
			
			
			<script type="text/javascript">
				$(document).ready(function() { 
					$("#OBLIempresa").autocomplete({
					source : \'busquedas/busqueda_empresa.php\',
					select: function( event, ui ) {
						var rut = ui.item.id;
						var valor = ui.item.value;
						document.getElementById(\'nombre_empresa\').value = valor;
						document.getElementById(\'empresa\').value = rut;
						}
					});	
				});
			</script>
        '; ?>

	</HEAD>
	<body style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server" >
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%">
                                    	<label class="form-titulo">&nbsp;&nbsp;Ingreso Equipo Servicio Tecnico</label>
                                    </td>
								</tr>
							</table>
							<br>
                            <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Folio:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<input type="text" name="folio" id="folio"/>
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" onclick="xajax_BuscarFolio(xajax.getFormValues('Form1'))"name="btnGrabar"  id="btnGrabar" value="Buscar" class="boton" />
									</td>
								</tr>
                            </table>
						
					</td>
				</tr>
			</table>
		</div>					
		        <div id="divlistado" align="left" style="display:none;margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divproductos'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
            <div id="divcontenedor_detalle" align="left" style="display:none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Datos del Servicio T&eacute;cnico
										<INPUT type="hidden" id="txtSaldoVenta" name="txtSaldoVenta" value=''>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Fecha Ingreso Bodega:
									  <label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										
										<INPUT type="text" id="OBLItxtFechaRevision" name="OBLItxtFechaRevision" value='<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
									</td>
								</tr>
                                <tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Producto:
									  <label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<INPUT type="text" id="OBLItxtproducto" name="OBLItxtproducto" size="85"/>
										<INPUT type="hidden" id="OBLIcodproducto" name="OBLIcodproducto" size="85"/>
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Cantidad:
									  <label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 60%">
										
										<INPUT type="text" id="OBLItxtcantidad" name="OBLItxtcantidad" onKeyPress="return SoloNumeros(this, event, 0)" />
										
									</td>
								</tr>
							</table>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
									<input type="button" id="btnGrabar" name="btnGrabar" value="Grabar Servicio T&eacute;cnico" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
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