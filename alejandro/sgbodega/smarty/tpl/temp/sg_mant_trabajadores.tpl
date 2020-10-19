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
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>                       
                        <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        
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
									<td style="width: 7%" align='right'><img src="../images/Database-Add-48.png"></td>
									<td style="width: 93%">
										<label class="form-titulo">
											&nbsp;&nbsp; {$TITULO_TABLA}
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='{$TABLA}'>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								<tr align="left">
                                    <td class="tabla-alycar-label">Nombres
                                        <label>&nbsp;*</label></td>
                                    <td class="tabla-alycar-texto" >
                                        <input type="text" id="OBLInombres" name="OBLInombres" value="" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" />
                                    </td>
								</tr>
                                <tr align="left">
                                  <td class="tabla-alycar-label">Apellido Paterno
                                    <label>&nbsp;*</label></td>
                                  <td class="tabla-alycar-texto" ><input type="text" id="OBLIapellido_pat" name="OBLIapellido_pat" value="" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
                                </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Apellido Materno
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="text" id="OBLIapellido_mat" name="OBLIapellido_mat" value="" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Rut
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="text" id="OBLIrut" name="OBLIrut" value="" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Empresa
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><select id="OBLIempresa_contr" name="OBLIempresa_contr" onkeypress="return Tabula(this, event, 0)">
									        </select></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Empresas de Ventas
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><div id="DIVempresa">
									        <input type="checkbox" name="OBLIempresa[]" id="76112370" value="SOL Y VALLE" />
									        SOL Y VALLE<br />
									        <input type="checkbox" name="OBLIempresa[]" id="78748930" value="YONLEY" />
									        YONLEY<br />
									        <input type="checkbox" name="OBLIempresa[]" id="11330825" value="JESSICA YA&Ntilde;EZ ALARCON" />
									        JESSICA YA&Ntilde;EZ ALARCON<br />
									        <input type="checkbox" name="OBLIempresa[]" id="8265044" value="JOSE LUIS GARRIDO CACERES" />
									        JOSE LUIS GARRIDO CACERES<br />
									        </div></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Vendedor
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" >
                                          	<table>
                                            	<tr>
                                                	<td>Codigo vendedor</td>
                                                    <td>Empresa vendedor</td>
                                                    <td>Zona vendedor</td>
											      <td>Comision Vendedor</td>
											      <td>Agregar</td>
                                                </tr>
                                            	<tr>
                                                	<td><input type="text" id="OBLIcod_vendedor" name="OBLIcod_vendedor" value="0" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                    <td>
                                                    	<select id="OBLIempresa_vendedor" name="OBLIempresa_vendedor" onkeypress="return Tabula(this, event, 0)">
                                                            <option id="option" value="76112370">SOL Y VALLE</option>
                                                            <option id="option" value="78748930">YONLEY</option>
                                                            <option id="option" value="11330825">JESSICA YA&Ntilde;EZ ALARCON</option>
                                                            <option id="option" value="8265044">JOSE LUIS GARRIDO CACERES</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" id="OBLIzona_vendedor" name="OBLIzona_vendedor" value="0" onkeypress="return Tabula(this, event, 0)" size="10" />
                                                    </td>
											      <td><input type="text" id="OBLIcomision_vendedor" name="OBLIcomision_vendedor" value="0" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                  <td>
                                                  	<input type="button" name="agregar_vendedor" id="agregar_vendedor" value="+" onclick="xajax_AgregarVendedor(xajax.getFormValues('Form1'))"  class='boton' />
                                                  </td>
                                                </tr>
                                                <tr >
                                                	<td id="datos_vendedores" colspan="5"></td>
                                                </tr>
                                            </table>
                                          </td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Cobrador
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" >
                                          	<table>
                                            	<tr>
                                                	<td>Codigo cobrador</td>
                                                    <td>Empresa cobrador</td>
											      <td>Sector cobrador</td>
											      <td>Comision cobrador</td>
											      <td>Agregar</td>
                                                </tr>
                                            	<tr>
                                                	<td><input type="text" id="codigo_cobrador" name="codigo_cobrador" value="" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                	 <td>
                                                    	<select id="empresa_cobrador" name="empresa_cobrador" onkeypress="return Tabula(this, event, 0)">
                                                            <option id="option" value="76112370">SOL Y VALLE</option>
                                                            <option id="option" value="78748930">YONLEY</option>
                                                            <option id="option" value="11330825">JESSICA YA&Ntilde;EZ ALARCON</option>
                                                            <option id="option" value="8265044">JOSE LUIS GARRIDO CACERES</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" id="sector_cobrador" name="sector_cobrador" value="" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                    <td><input type="text" id="comision_cobrador" name="comision_cobrador" value="" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                    <td><input type="button" name="agregar_cobrador" id="agregar_cobrador" value="+" class='boton' onclick="xajax_AgregarCobrador(xajax.getFormValues('Form1'))"  /></td>
                                                </tr>
                                                <tr >
                                                	<td id="datos_cobradores" colspan="5"></td>
                                                </tr>
                                             </table>
                                          </td>
								        </tr>
									      
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Supervisor
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" >
                                          	<table>
                                            	<tr>
                                                	<td>Codigo supervisor</td>
                                                    <td>Comision supervisor</td>
											      	<td>Empresa supervisor</td>
											      	<td>Agregar</td>
                                                </tr>
                                            	<tr>
                                                	<td><input type="text" id="codigo_supervisor" name="codigo_supervisor" value="" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                	<td><input type="text" id="comision_supervisor" name="comision_supervisor" value="" onkeypress="return Tabula(this, event, 0)" size="10" /></td>
                                                    <td>
                                                    	<select id="empresa_supervisor" name="empresa_supervisor" onkeypress="return Tabula(this, event, 0)">
                                                            <option id="option" value="76112370">SOL Y VALLE</option>
                                                            <option id="option" value="78748930">YONLEY</option>
                                                            <option id="option" value="11330825">JESSICA YA&Ntilde;EZ ALARCON</option>
                                                            <option id="option" value="8265044">JOSE LUIS GARRIDO CACERES</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="button" name="agregar_supervisor" id="agregar_supervisor" value="+" class='boton' onclick="xajax_AgregarSupervisor(xajax.getFormValues('Form1'))"  /></td>
                                                </tr>
                                                <tr >
                                                	<td id="datos_supervisores" colspan="5"></td>
                                                </tr>
                                             </table>
                                          </td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Fondos por Rendir
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="checkbox" id="CHKfondos_rendir" name="CHKfondos_rendir" value="1" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Vehiculos
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="checkbox" id="CHKvehiculos" name="CHKvehiculos" value="1" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Cuentas Personales
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="checkbox" id="CHKcuentas_personales" name="CHKcuentas_personales" value="1" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Ventas
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="checkbox" id="CHKventas" name="CHKventas" value="1" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Bodega
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><input type="checkbox" id="CHKbodega" name="CHKbodega" value="1" onkeypress="return Tabula(this, event, 0)" maxlength="100" size="50" /></td>
								        </tr>
									    <tr align="left">
									      <td class="tabla-alycar-label">Cargo
									        <label>&nbsp;*</label></td>
									      <td class="tabla-alycar-texto" ><select id="OBLIcargo" name="OBLIcargo" onkeypress="return Tabula(this, event, 0)">
									        <option id="option" value="1">VENDEDOR</option>
									        <option id="option" value="2">COBRADOR</option>
									        <option id="option" value="3">SUPERVISOR</option>
									        <option id="option" value="4">ADMINISTRATIVO</option>
									        </select></td>
								        </tr>
					
						    <tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	{if ($volver=='si')&&(($TABLA == 'clientes')||($TABLA =='proveedores')||($TABLA =='prestadores'))}
                                      <input type="button" class="boton" value="Volver"name="btnVolver" onclick="document.location.href='{$pagina_volver}?nombre_empresa={$nombre_empresa}&empresa={$empresa}&fecha={$fecha}&cliente={$cliente}&rut={$rut}&nro_factura={$nro_factura}&neto={$neto}&iva={$iva}&total={$total}'"/>
                                        {/if}
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
                <div id="calendar-container"></div>
	</body>
</HTML>


