<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		

	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ingresar Carga de Combustible a Vehiculo</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="">
                                                                            <input name="cboPersona" id="cboPersona" value="{$CARGA_NOM_PERS}"  />
                                                                            <input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador" value="{$carga_pers}"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 15%">
                                                                            <input id="cboPatente" name="cboPatente" value="{$carga_veh}" > 
                                                                        </td>	
									<td class="tabla-alycar-label" style="width: 15%">Persona Asignada</td>
									<td class="tabla-alycar-texto" >
									    <input type="text" name="pers_asig" id="pers_asig" value="" readonly/>
                                                                            <input type="button" name="btnActualizar" value="Asigancion de Vehiculo" class="boton"  onclick="xajax_LlamaMantenedorVxC(xajax.getFormValues('Form1'));" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Monto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoIngresar" name="OBLItxtMontoIngresar" value='' onKeyPress="return SoloNumeros(this, event, 0)" value="{$carga_monto}">
									</td>
									<td class="tabla-alycar-label" style="width: 15%">Cupo Disponible</td>
									<td class="tabla-alycar-texto" >
										<INPUT type="text" id="OBLItxtMontoDisponible" name="OBLItxtMontoDisponible" value='' onKeyPress="return SoloNumeros(this, event, 0)"  readonly/>
                                                                                <input type="hidden" name="oculto_OBLItxtMontoDisponible" id="oculto_OBLItxtMontoDisponible" value="" readonly/>
                                                                        </td>	
                                                                        								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Fecha:<label class="requerido"> * </label></td>
                                                                        <td class="tabla-alycar-texto" style="width: 20%">
										<INPUT type="text" id="OBLI-txtFecha" name="OBLI-txtFecha" value='{$smarty.now|date_format:"%d/%m/%Y"}' onKeyPress="return SoloNumeros(this, event, 0)" value="{$carga_fecha}" />
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Tipo de Carga:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="">
                                                                                <select id="cboCarga" name="cboCarga" onKeyPress="return SoloNumeros(this, event, 0)" ></select>
                                                                        </td>	
								</tr>
								
								
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>		
	</body>
</HTML>