<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	{$xajax_js}
	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body onload="xajax_CargaInicial(xajax.getFormValues('Form1'));"style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">

		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
		
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left">
								<td class="tabla-alycar-fila-informa-requerida-contrato-cabecera">
									<div style="cursor: pointer" onclick="xajax_Link(xajax.getFormValues('Form1'));">{$TITULO_MENU}</div>
								</td>
							</tr>
						</table>
						<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
							{section name=registros loop=$arrRegistros}
								<tr align="left">		
									<td class="tabla-alycar-label" style="width: 30%"><a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistros[registros].link}');">{$arrRegistros[registros].descripcion}</a></td>
								</tr>
							{/section}
						</table>
					</td>
				</tr>
			</table>
			
		</div>
	</form>
		

</body>
</html>
