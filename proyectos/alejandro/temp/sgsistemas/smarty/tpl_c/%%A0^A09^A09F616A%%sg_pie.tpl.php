<?php /* Smarty version 2.6.18, created on 2011-02-21 13:34:08
         compiled from sg_pie.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
	
		<?php echo '
		
			<script type="text/javascript">
				function cambiar (id, img) {

					document.images[id].src = img;

				}
				function reloj () {

					xajax_CargaPagina(xajax.getFormValues(\'Form1\'));

				}
			</script>
		
		'; ?>

	
	</HEAD>
	<!--<body onload="setInterval('reloj()',1000);" style="background:#ffffff;">-->
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;">
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table align='center' border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%; float: left;">
					<tr> 
						<td colspan="3" class="tabla-alycar-fila-informa-requerida-contrato">
						<div id='divfecha'></div>
						</td> 
					</tr>
				
				</table>
							
			</div>
		</form>
	</body>
</HTML>