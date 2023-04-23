<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
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
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
			
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		{literal}
		<script type="text/javascript">
			function init() {
				
				shortcut.add("ESC", function() {
					xajax_Salir(xajax.getFormValues('Form1'));
				});
			}
			window.onload=init;
		</script>
		{/literal}
		
	</HEAD>
	<body onload="init(), xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<INPUT type="hidden" id="txtEntidad" name="txtEntidad" value='{$ENTIDAD}' maxLength="50" size="50">
									<INPUT type="hidden" id="txtObj1" name="txtObj1" value='{$OBJ1}'>
									<INPUT type="hidden" id="txtObj2" name="txtObj2" value='{$OBJ2}'>
									
									<td class="tabla-alycar-label" style="width: 30%">Texto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTexto" name="txtTexto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="50" size="50">
									</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Buscar Por:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboBuscarPor" name="cboBuscarPor" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value='01'>Descripcion</option>
											<option value='02'>Codigo</option>
										</SELECT>
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										{if ($ENTIDAD == '1')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sectores', 'sect_cod', 'sect_desc');">
										{/if}
										{if ($ENTIDAD == '2')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'clientes', 'VE_CODIGO', 'VE_VENDEDOR');">
										{/if}
										{if ($ENTIDAD == '21')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vendedores', 'VE_CODIGO', 'VE_VENDEDOR');">
										{/if}
										{if ($ENTIDAD == '3')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'clientes', 'clie_rut', 'clie_nombre');">
										{/if}
										{if ($ENTIDAD == '4')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'tallasnew', 'ta_ncorr', 'ta_descripcion');">
										{/if}
										{if ($ENTIDAD == '5')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'cobrador', 'CO_CODIGO', 'CO_NOMBRE');">
										{/if}
										{if ($ENTIDAD == '6')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'supervisor', 'sp_codigo', 'sp_nombre');">
										{/if}
										{if ($ENTIDAD == '7')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion');">
										{/if}
										{if ($ENTIDAD == '10')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'personas', 'pers_rut', 'pers_nombre');">
										{/if}
										{if ($ENTIDAD == '11')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vehiculos', 'veh_ncorr', 'veh_patente');">
										{/if}
										{if ($ENTIDAD == 'articulo')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion');">
										{/if}
										{if ($ENTIDAD == '12')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sgbodega.proveedor', 'PR_RUT', 'PR_RAZON');">
										{/if}
										<input type="button" name="btnSalir" value="Salir" class="boton" onclick="xajax_Salir(xajax.getFormValues('Form1'));">
										
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>&nbsp;
										
									</td>
								</TR>
								<tr align="left">
									<td colspan='2'>
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