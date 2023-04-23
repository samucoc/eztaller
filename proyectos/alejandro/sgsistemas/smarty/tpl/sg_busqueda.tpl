<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
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
			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/mail_find-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp; Búsqueda de {$TITULO}</label></td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15">Buscar Por:</td>
									<td class="tabla-alycar-texto" style="width: 25%">
										<INPUT type="hidden" id="txtTbl" name="txtTbl" value='{$TBL}'>
										<SELECT id="OBLIcboBuscarPor" name="OBLIcboBuscarPor" style="width: 100%" onKeyPress="return Tabula(this, event, 0)">
											<option value='01'>Nombre</option>
											<option value='02'>Rut</option>

										</SELECT>
									</td>	
									<td class="tabla-alycar-label" style="width: 10%">Texto:</td>
									<td class="tabla-alycar-texto" style="width: 50%">
										<INPUT type="text" id="txtTexto" name="txtTexto" value='' style="width: 70%" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
										
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();"> 
									</td>	
									
								</TR>
								<tr align="left">
									<td colspan='10'>
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