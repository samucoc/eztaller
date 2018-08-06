<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	{$xajax_js}
	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td>
					<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
						<tr align="left">
							{section name=registros loop=$arrRegistros}
								<td class="tabla-alycar-fila-informa-requerida-contrato-cabecera" onmouseover="this.className='tabla-alycar-fila-informa-requerida-contrato-cabecera-fuera';" onmouseout="this.className='tabla-alycar-fila-informa-requerida-contrato-cabecera';" onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistros[registros].id}','{$arrRegistros[registros].descripcion}');">
									<div style="cursor: pointer" onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistros[registros].id}','{$arrRegistros[registros].descripcion}');">{$arrRegistros[registros].descripcion}</div>
								</td>
							{/section}
							<td class="tabla-alycar-texto-menu" align='center' style="width: 25%">
								<img  src="../images/user.png" border=0>&nbsp;&nbsp;{$NOMBREUSUARIO}
							</td>
						</tr>
					</table>
				<td>
			</tr>
		</table>
	</form>
</body>
</html>
