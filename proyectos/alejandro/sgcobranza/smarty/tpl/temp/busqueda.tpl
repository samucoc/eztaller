<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Busqueda </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<!-- estilos  -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Buscar Por:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="cboBuscarPor" name="cboBuscarPor" onKeyPress="return Tabula(this, event, 0)">
											<option value='01'>Nombre</option>
											<option value='02'>Id. Usuario</option>
										</SELECT>
									</td>
								</tr>
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Texto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtTexto" name="txtTexto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="50" size="50">
									</td>
								</tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										{if ($ENTIDAD == '1')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'clientes', 'clie_rut', 'clie_nombre');">
										{/if}
										{if ($ENTIDAD == '2')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vehiculos', 'vehi_patente', 'GetModeloGenerico(tmge_ncorr)');">
										{/if}
										{if ($ENTIDAD == '20')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vehiculos', 'vehi_patente', 'GetModeloGenerico(tmge_ncorr)');">
										{/if}
										{if ($ENTIDAD == '21')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'vehiculos', 'vehi_patente', 'GetModeloGenerico(tmge_ncorr)');">
										{/if}
										{if ($ENTIDAD == '3')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'contratos_conductores', 'ccon_rut', 'ccon_nombre');">
										{/if}
										{if ($ENTIDAD == '4')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'usuarios', 'usu_login', 'usu_nombre');">
										{/if}
										{if ($ENTIDAD == '5')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'sucursales', 'sucu_ncorr', 'sucu_desc');">
										{/if}
										{if ($ENTIDAD == '6')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'aseguradoras', 'aseg_ncorr', 'aseg_desc');">
										{/if}
										{if ($ENTIDAD == '7')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'seguros', 'segu_ncorr', 'segu_desc');">
										{/if}
										{if ($ENTIDAD == '8')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'seguros', 'segu_ncorr', 'segu_desc');">
										{/if}
										{if ($ENTIDAD == '9')}
											<input type="button" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Buscar(xajax.getFormValues('Form1'), 'centros_costos', 'ccos_ncorr', 'ccos_desc');">
										{/if}
										<INPUT type="hidden" id="txtEntidad" name="txtEntidad" value='{$ENTIDAD}' maxLength="50" size="50">
										<INPUT type="hidden" id="txtObj1" name="txtObj1" value='{$OBJ1}' maxLength="50" size="50">
										<INPUT type="hidden" id="txtObj2" name="txtObj2" value='{$OBJ2}' maxLength="50" size="50">
										
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										&nbsp;
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