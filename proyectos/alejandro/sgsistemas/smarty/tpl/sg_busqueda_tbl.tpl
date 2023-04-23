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
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<INPUT type="hidden" id="txtTbl" name="txtTbl" value='{$TBL}'>
								<INPUT type="hidden" id="txttgas_ncorr" name="txttgas_ncorr" value='{$TGAS_NCORR}'>
								
								<tr align="left">
									<td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="txtObj1" name="txtObj1" value='' style="width: 90%" onKeyup="xajax_Busca(xajax.getFormValues('Form1'),'1');" onKeyPress="return Tabula(this, event, 0)" maxLength="10">
									</td>	
									<td class="tabla-alycar-texto" style="width: 80%">
										<INPUT type="text" id="txtObj2" name="txtObj2" value='' style="width: 90%" onKeyup="xajax_Busca(xajax.getFormValues('Form1'),'2');" onKeyPress="return Tabula(this, event, 0)" maxLength="100">
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