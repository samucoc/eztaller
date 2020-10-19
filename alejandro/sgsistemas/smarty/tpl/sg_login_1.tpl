<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
	
		{literal}
		
			<script type="text/javascript">
				function cambiar (id, img) {

					document.images[id].src = img;

				}
				function reloj () {

					xajax_CargaPagina(xajax.getFormValues('Form1'));

				}
			</script>
		
		{/literal}
	
	</HEAD>
	<body style="background:#ffffff;">
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table align='center' class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 96%; float: left; border: 3pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td align='center'>
							
							<table align='center' border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%; float: left;">
								<tr> 
									<td colspan="4" class="tabla-alycar-fila-informa-requerida-contrato">
									Sistema Integrado de Gesti&oacute;n Escolar (SIGE)
									</td> 
								</tr>
								<tr>
									<td onmouseover="this.style.background='#447CAD';this.style.color='#FFFFFF'; cambiar('sist2', '../images/fin_comp/pago-voluntario.png');xajax_Acceso(xajax.getFormValues('Form1'), 'Gesti&oacute;n Finaciamiento Compartido');" onmouseout="this.style.background='#F2F2F2'; this.style.color='#1B4978'; cambiar('sist2', '../images/fin_comp/pago-voluntario.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="width: 25%" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '2');">
										<br>
										<img onMouseOver="cambiar('sist2', '../images/fin_comp/pago-voluntario.png');" onMouseOut="cambiar('sist2', '../images/fin_comp/pago-voluntario.png');" src="../images/fin_comp/pago-voluntario.png" name="sist2" >
										<br><br>
										Gesti&oacute;n Financiamiento Compartido
										<br><br>
									</td>
									<td onmouseover="this.style.background='#447CAD'; this.style.color='#FFFFFF';cambiar('sist1', '../images/gest_esc/ficha-alumno.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Gesti&oacute;n Acad&eacute;mica');" onmouseout="this.style.background='#F2F2F2'; this.style.color='#1B4978';  cambiar('sist1', '../images/gest_esc/ficha-alumno.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="width: 25%" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '1');">
										<br>
										<img border='0' onMouseOver="cambiar('sist1', '../images/gest_esc/ficha-alumno.png');" onMouseOut="cambiar('sist1', '../images/gest_esc/ficha-alumno.png');" src="../images/gest_esc/ficha-alumno.png" name="sist1">
										<br><br>
										Gesti&oacute;n Acad&eacute;mica
										<br><br>
									</td>
								</tr>
								<tr> 
									<td colspan="4" class="tabla-alycar-fila-informa-requerida-contrato">
									<div id='divacceso'>Seleccione un Acceso</div>
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