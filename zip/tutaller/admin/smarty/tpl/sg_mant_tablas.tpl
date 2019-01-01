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
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
	        <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
            <!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>                       
            <LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet"></LINK>               
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
            <script src="../includes_js/jquery.uploadify.min.js" type="text/javascript"></script>
			<link rel="stylesheet" type="text/css" href="../estilos/uploadify.css">

			{literal}
			<script type="text/javascript">
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
				   	temp.document.write(c.innerHTML);
				   	temp.document.close();
					  
				   	var is_chrome = function () { return Boolean(temp.chrome); }
					if(is_chrome) {
							setTimeout(function () { // wait until all resources loaded 
								temp.print();  // change window to winPrint
					            temp.close();// change window to winPrint
					        }, 100);
						}
					else{
					   	temp.print();
					   	temp.close();
					}
			}
            </script>                        
            {/literal}
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server" enctype="multipart/form-data">
			
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
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="{$rut_trab}"/>
											<input type="hidden" id="rut_alumno_bitacora" name="rut_alumno_bitacora" value="{$rut_alumno_bitacora}"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                {if ($TABLA=='alumnos')}
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                                	<input type="button" name="ficha_alumno" id="ficha_alumno" onclick="location.href='sg_mant_tablas.php?tbl=alumnos'"  class="boton" value="Fichas Alumnos"/>
		                                	<input type="button" name="btnNotas" id="btnNotas" onclick="xajax_CargaListado_alumnos_Notas(xajax.getFormValues('Form1'))"  class="boton" value="Notas"/>
		                                	<input type="button" name="btnHojaVida" id="btnHojaVida" onclick="xajax_CargaListado_alumnos_HojaVida(xajax.getFormValues('Form1'))"  class="boton" value="Hoja de vida"/>
		                                	<input type="button" name="btnAsistencia" id="btnAsistencia" onclick="xajax_CargaListado_alumnos_Asistencia(xajax.getFormValues('Form1'))"  class="boton" value="Asistencia"/>
                                    	</td>
                                    </tr>
                                {/if}
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								{if ($TABLA == trabajadores_tienen_cargas)}
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Trabajador</td>
									<td class="tabla-alycar-texto" style="width: 70%">{$rut}<input type="hidden" id="OBLIrut_papa" name="OBLIrut_papa" value="{$rut_trab}"/></td>
								</tr>
                                {/if}
								{section name=campos loop=$arrCampos}
									{if ($arrCampos[campos].titulo != '')}
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">{$arrCampos[campos].titulo}<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
                                            	{if ($arrCampos[campos].objeto == 'SELECT')}
                                                    <SELECT id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}','{$TABLA}');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}')" > 
                                                    </SELECT>
												{elseif ($arrCampos[campos].objeto == 'FECHA')}
													{if ($arrCampos[campos].campo=='FechaBoleta')&&($TABLA=='Movimientos')}
														<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}','{$TABLA}');">
	                                                        <a href="#" style="cursor: hand;">
	                                                        	<img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario">
	                                                        </a>
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI{$arrCampos[campos].campo}";
	                                                                var button = "cld{$arrCampos[campos].campo}";
	                                                                {literal}
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $('#'+input).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        {/literal}
	                                                    

													{else}
													<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
                                                        <a href="#" style="cursor: hand;"><img  id='cld{$arrCampos[campos].campo}' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
                                                        <script type="text/javascript">
                                                                var input = "OBLI{$arrCampos[campos].campo}";
                                                                var button = "cld{$arrCampos[campos].campo}";
                                                                {literal}
                                                                Calendar.setup({inputField : input, 
																				ifFormat : "%d/%m/%Y",
																				showstime: true,
																				button : button ,
																				step: 1});
                                                                $(function($) { 
                                                                        $('#'+input).mask("99/99/9999");
                                                                        }
                                                                ); 		
                                                        </script>                                                                               
                                                        {/literal}
                                                    {/if}
												{elseif ($arrCampos[campos].objeto == 'PASSWORD')}
													<INPUT type="password"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												{elseif ($arrCampos[campos].objeto == 'NUMERO')}
													{if ($arrCampos[campos].campo=='NumeroBoleta')&&($TABLA=='Movimientos')}
														<INPUT type="text" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50"
														onblur="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI{$arrCampos[campos].campo}','{$TABLA}');">
													{else}
                                                		<INPUT type="text"  id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
                                                	{/if}

												{elseif ($arrCampos[campos].objeto == 'RUT')}
													<INPUT type="text" class="rut" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' />
                                                {elseif ($arrCampos[campos].objeto == 'OPC')}
													<INPUT type="text" class="rut" id="{$arrCampos[campos].campo}" name="{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                {elseif ($arrCampos[campos].objeto == 'CHECK')}
													<INPUT type="checkbox" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="1"/>
                                                {elseif ($arrCampos[campos].objeto == 'FOTO')}
													<script type="text/javascript">
													var input_1 = "OBLI{$arrCampos[campos].campo}";
													{literal}
                                                        $(function() {
                                                            $('#file-name').uploadify({
                                                                'swf'      			: 'uploadify.swf',
                                                                'uploader' 			: 'uploadify.php',
																'buttonText' 		: 'Subir Foto',
																'onUploadSuccess' 	: function(file, data, response){
														            document.getElementById('img_'+input_1).src = 'uploads/'+file.name;
																	document.getElementById(input_1).value= 'uploads/'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    {/literal}
                                                    <div id="queue"></div>
                                                    <input id="file-name" name="file-name" type="file" />
                                                    <img src="#" id="img_OBLI{$arrCampos[campos].campo}" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}"  name="OBLI{$arrCampos[campos].campo}" value=""  />
		                                        {elseif ($arrCampos[campos].objeto == 'BUSCA')}
		                                        	{if $arrCampos[campos].campo == 'PaternoApoderado'}
														<input type="text" id="BSCPaternoApoderado" name="BSCPaternoApoderado" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLIPaternoApoderado" name="OBLIPaternoApoderado"/>
	                                                    <script type="text/javascript">
														var tabla = '{$TABLA}';
	                                                    {literal}
															$(document).ready(function() {
																$("#BSCPaternoApoderado").autocomplete({
																	source : 'busquedas/busqueda_OBLIPaternoApoderado.php',
																	select: function( event, ui ) {
																		//llenar Apoderado
																		var ncorr = ui.item.id;
																		var rut = ui.item.rut;
																		var apellidoPaterno 			  = ui.item.apellidoPaterno;
																		var MaternoApoderado              = ui.item.MaternoApoderado;
																		var NombresApoderado              = ui.item.NombresApoderado;
																		var DireccionParticularApoderado  = ui.item.DireccionParticularApoderado;
																		var CiudadParticularApoderado     = ui.item.CiudadParticularApoderado;
																		var TelefonoParticularApoderado   = ui.item.TelefonoParticularApoderado;
																		var TelefonoMovilApoderado        = ui.item.TelefonoMovilApoderado;
																		var CodigoParentesco              = ui.item.CodigoParentesco;
																		var CodigoEscolaridad             = ui.item.CodigoEscolaridad;
																		var CodigoOcupacion               = ui.item.CodigoOcupacion;
																		var TipoApoderado                 = ui.item.TipoApoderado;
																		var EMailApoderado                = ui.item.EMailApoderado;
																		var TipoPagare                    = ui.item.TipoPagare;
																		var NumeroRutAval                 = ui.item.NumeroRutAval;
																		var PaternoAval                   = ui.item.PaternoAval;
																		var MaternoAval                   = ui.item.MaternoAval;
																		var NombresAval                   = ui.item.NombresAval;
																		var DireccionAval                 = ui.item.DireccionAval;
																		var CiudadAval                    = ui.item.CiudadAval;

																		document.getElementById('txtNcorr').value = ncorr;
																		document.getElementById('OBLINumeroRutApoderado').value = rut;
																		document.getElementById('OBLIPaternoApoderado').value = apellidoPaterno;
																		document.getElementById('BSCPaternoApoderado').value = apellidoPaterno;
																		document.getElementById('OBLIMaternoApoderado').value = MaternoApoderado;
																		document.getElementById('BSCNombresApoderado').value = NombresApoderado;
																		document.getElementById('OBLINombresApoderado').value = NombresApoderado;
																		document.getElementById('OBLIDireccionParticularApoderado').value = DireccionParticularApoderado;
																		document.getElementById('OBLITelefonoParticularApoderado').value = TelefonoParticularApoderado;
																		document.getElementById('OBLITelefonoMovilApoderado').value = TelefonoMovilApoderado;
																		document.getElementById('OBLIEMailApoderado').value = EMailApoderado;
																		document.getElementById('OBLINumeroRutAval').value = NumeroRutAval;
																		document.getElementById('OBLIPaternoAval').value = PaternoAval;
																		document.getElementById('OBLIMaternoAval').value = MaternoAval;
																		document.getElementById('OBLINombresAval').value = NombresAval;
																		document.getElementById('OBLIDireccionAval').value = DireccionAval;
																		}
																	});
																});
	                                                    </script>
														{/literal}
		                                        	{elseif $arrCampos[campos].campo == 'NombresApoderado'}
														<input type="text" id="BSCNombresApoderado" name="BSCNombresApoderado" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLINombresApoderado" name="OBLINombresApoderado"/>
	                                                    <script type="text/javascript">
														var tabla = '{$TABLA}';
	                                                    {literal}
															$(document).ready(function() {
																$("#BSCNombresApoderado").autocomplete({
																	source : 'busquedas/busqueda_OBLINombresApoderado.php',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		document.getElementById('OBLINombresApoderado').value = rut;
																		xajax_CargaListado(xajax.getFormValues('Form1'),'OBLINombresApoderado',tabla);
																		}
																	});
																});
	                                                    </script>
														{/literal}
		                                        	{else}
														{if ($arrCampos[campos].campo=='NumeroRutApoderado') && ($TABLA=='Bitacoras')}
															<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" />
	                                                    	<input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
														{else}
														<input type="text" id="BSC{$arrCampos[campos].campo}" name="BSC{$arrCampos[campos].campo}" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}"/>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI{$arrCampos[campos].campo}';
														var combo = 'BSC{$arrCampos[campos].campo}';
														var tabla = '{$TABLA}';
	                                                    {literal}
															$(document).ready(function() {
																$("#"+combo).autocomplete({
																	source : 'busquedas/busqueda_'+obli+'.php',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		document.getElementById(obli).value = rut;
																		xajax_CargaListado(xajax.getFormValues('Form1'),obli,tabla);
																		}
																	});
																});
	                                                    </script>
														{/literal}
														{/if}
													{/if}
                                                {else}
                                                	<INPUT type="text" id="OBLI{$arrCampos[campos].campo}" name="OBLI{$arrCampos[campos].campo}" value='' onKeyPress="return Tabula(this, e	vent, 0)" maxLength="100" size="50">
												{/if}	
											</td>
										</tr>
									{/if}
									{if ($arrCampos[campos].campo == 'CodigoTipoBeca')&&($TABLA=='Becas')}
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Beca Incorporacion</td>
										<td class="tabla-alycar-texto" style="width: 70%" id="beca_incorporacion"></td>
									</tr>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Beca Colegiatura</td>
										<td class="tabla-alycar-texto" style="width: 70%" id="beca_colegiatura"></td>
									</tr>
									{/if}
								{/section}
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	{if ($volver=='si')&&(($TABLA == 'clientes')||($TABLA =='proveedores')||($TABLA =='prestadores'))}
                                        <input type="button" class="boton" value="Volver"name="btnVolver" onclick="document.location.href='{$pagina_volver}?nombre_empresa={$nombre_empresa}&empresa={$empresa}&fecha={$fecha}&cliente={$cliente}&rut={$rut}&nro_factura={$nro_factura}&neto={$neto}&iva={$iva}&total={$total}'"/>
                                        {/if}
										<a href="#" onclick="javascript: ValidaFormularioMantenedor();">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										<a href="#" onclick="javascript: document.Form1.submit();">
											<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
										</a>
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										{if $TABLA!='Apoderados'}
										<div id='divresultado'></div>
										{/if}
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