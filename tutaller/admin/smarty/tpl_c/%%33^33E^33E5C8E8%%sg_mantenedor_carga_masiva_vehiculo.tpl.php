<?php /* Smarty version 2.6.18, created on 2013-02-07 17:09:09
         compiled from sg_mantenedor_carga_masiva_vehiculo.tpl */ ?>
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
		<?php echo '

        '; ?>

	</HEAD>
	<body style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server" enctype="multipart/form-data">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%">
                                    	<label class="form-titulo">&nbsp;&nbsp;Cargas Masivas Vehiculos</label>
                                        <input type="hidden" name="nombre_archivo" id="nombre_archivo"/>
                                    </td>
								</tr>
							</table>
							<br>
                            <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Archivo:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<input type="file" name="archivo" id="archivo"/>
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="submit" name="btnGrabar"  id="btnGrabar" value="Grabar" class="boton" />
									</td>
								</tr>
                            </table>
						</form>

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
										<div id='divabonos'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		<div id="calendar-container"></div>
	
	</body>
</HTML>