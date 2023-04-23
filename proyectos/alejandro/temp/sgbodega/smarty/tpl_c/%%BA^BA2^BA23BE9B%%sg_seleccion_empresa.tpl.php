<?php /* Smarty version 2.6.18, created on 2013-08-21 14:39:53
         compiled from sg_seleccion_empresa.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title>Sistema Bodega</title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet" />
		
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="center" style="margin:2px; padding: 2px;">
			
				<table align="center" cellpadding="2" cellspacing="2" class="curvar" style="WIDTH: 35%; margin-top:15%; border: 5pt solid #B9B9B9; background:#ffffff">
					<tr align="center" valign="middle">
						<td width="100%" align="center" valign="middle">		
							
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%; float: left;">
								
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">
									<img src="../images/house_go.png">&nbsp;&nbsp;
									Seleccione Bodega
									</td> 
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Usuario:</td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<?php echo $this->_tpl_vars['NOMBREUSUARIO']; ?>

									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 40%">Bodega:</td>
									<td class="tabla-alycar-texto" style="width: 60%">
										<SELECT id="OBLIcboBodega" name="OBLIcboBodega"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td colspan='2' class="tabla-alycar-fila-botones">
										<input type="button" name="btnIngresar" value="Ingresar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
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