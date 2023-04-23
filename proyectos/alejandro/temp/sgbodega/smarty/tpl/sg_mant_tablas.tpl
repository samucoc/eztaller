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
								
								{section name=campos loop=$arrCampos}
									
									{if ($arrCampos[campos].titulo != '')}
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">{$arrCampos[campos].titulo}<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
												{if ($arrCampos[campos].objeto == 'SELECT')}
													<SELECT id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)"></SELECT>
												{elseif ($arrCampos[campos].objeto == 'FECHA')}
													<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                                                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
                                                                                                        <script type="text/javascript">
                                                                                                                var input = "OBLI{$arrCampos[campos].campo}";
                                                                                                                var button = "cld{$arrCampos[campos].campo}";
                                                                                                                {literal}
                                                                                                                Calendar.setup({inputField : input, ifFormat : "%d/%m/%Y",showstime: true,button : button ,step: 1});
                                                                                                        
                                                                                                                $(function($) { 
                                                                                                                        $('#'+input).mask("99/99/9999");
                                                                                                                        }
                                                                                                                ); 		
                                                                                                        </script>                                                                               
                                                                                                        {/literal}
												{elseif ($arrCampos[campos].objeto == 'PASSWORD')}
													<INPUT type="password"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												{elseif ($arrCampos[campos].objeto == 'RUT')}
													<INPUT type="text" class="rut" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                                                                {elseif ($arrCampos[campos].objeto == 'OPC')}
													<INPUT type="text" class="rut" id="{$arrCampos[campos].campo}" name="{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                                                                        
												{else}
													<INPUT type="text" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												{/if}
											</td>
										</tr>
									{/if}
								{/section}
								
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