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
											&nbsp;&nbsp; Establecimiento
											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='{$TABLA}'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="{$rut_trab}"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Rut Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLINumeroRutEstablecimiento" name="OBLINumeroRutEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Nombre Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLINombreEstablecimiento" name="OBLINombreEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Direccion Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIDireccionEstablecimiento" name="OBLIDireccionEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Ciudad Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLICiudadEstablecimiento" name="OBLICiudadEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Telefono Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLITelefonoEstablecimiento" name="OBLITelefonoEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<!-- <tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Fax Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIFaxEstablecimiento" name="OBLIFaxEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr> -->
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Email Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIEMailEstablecimiento" name="OBLIEMailEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Rut Representante
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLINumeroRutRepresentante" name="OBLINumeroRutRepresentante" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Apellido Paterno Representante
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIPaternoRepresentante" name="OBLIPaternoRepresentante" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Apellido Materno Representante
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIMaternoRepresentante" name="OBLIMaternoRepresentante" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Nombres Representante
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLINombresRepresentante" name="OBLINombresRepresentante" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Periodo Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIPeriodoEstablecimiento" name="OBLIPeriodoEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Region Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIRegionEstablecimiento" name="OBLIRegionEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Provincia Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIProvinciaEstablecimiento" name="OBLIProvinciaEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Semestre Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLISemestreEstablecimiento" name="OBLISemestreEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<!-- <tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Unidad PenDrive
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIUnidadPenDrive" name="OBLIUnidadPenDrive" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr> -->
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                RBD
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIRBD" name="OBLIRBD" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Numero Decreto
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLINumeroDecreto" name="OBLINumeroDecreto" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Fecha Decreto
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text"  id="OBLIFechaDecreto" name="OBLIFechaDecreto" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
                                                        <a href="#" style="cursor: hand;"><img  id='cldLogo' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
                                                        <script type="text/javascript">
                                                                var input = "OBLIFechaDecreto";
                                                                var button = "cldLogo";
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
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Periodo Postulacion
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIPeriodoPostulacion" name="OBLIPeriodoPostulacion" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Porcentaje Sintesis
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIPorcentajeSintesis" name="OBLIPorcentajeSintesis" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Correlativo Certificado
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLICorrelativoCertificado" name="OBLICorrelativoCertificado" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Celular Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLICelularEstablecimiento" name="OBLICelularEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Resolucion Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIResolucion" name="OBLIResolucion" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                A&ntilde;o Resolucion Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLIAnioResolucion" name="OBLIAnioResolucion" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
                                        <tr align="left">
											<td class="tabla-alycar-label" style="width: 30%">
                                                Tipo Establecimiento
                                                <label class="requerido"> * </label>
                                           	</td>
											<td class="tabla-alycar-texto" style="width: 70%">
													<INPUT type="text" id="OBLITipoEstablecimiento" name="OBLITipoEstablecimiento" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
                                            </td>
                                       	</tr>
                                        <tr>
                                        	<td class="tabla-alycar-label" >Logo</td>
                                        	<td class="tabla-alycar-texto" >
                                            	<script type="text/javascript">
													var input_1 = "OBLILogo";
													{literal}
                                                        $(function() {
                                                            $('#file-name').uploadify({
                                                                'swf'      			: 'uploadify.swf',
                                                                'uploader' 			: 'uploadify.php',
																'buttonText' 		: 'Subir Logo',
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
                                                    <img src="#" id="img_OBLILogo" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLILogo"  name="OBLILogo" value=""  />
                                             </td>
                                        </tr>
                                        <tr>
                                        	<td class="tabla-alycar-label" >Imagen Firma Director</td>
                                        	<td class="tabla-alycar-texto" >
                                            	<script type="text/javascript">
													var input_2 = "OBLIFoto";
													{literal}
                                                        $(function() {
                                                            $('#file-name-2').uploadify({
                                                                'swf'      			: 'uploadify.swf',
                                                                'uploader' 			: 'uploadify.php',
																'buttonText' 		: 'Subir Foto',
																'onUploadSuccess' 	: function(file, data, response){
														            document.getElementById('img_'+input_2).src = 'uploads/'+file.name;
																	document.getElementById(input_2).value= 'uploads/'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    {/literal}
                                                    <div id="queue"></div>
                                                    <input id="file-name-2" name="file-name-2" type="file" />
                                                    <img src="#" id="img_OBLIFoto" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLIFoto"  name="OBLIFoto" value=""  />
                                             </td>
                                        </tr>
                                        <tr>
                                        	<td class="tabla-alycar-label" >Imagen Firma Sostenedor</td>
                                        	<td class="tabla-alycar-texto" >
                                            	<script type="text/javascript">
													var input_3 = "OBLIsostenedor";
													{literal}
                                                        $(function() {
                                                            $('#file-name-3').uploadify({
                                                                'swf'      			: 'uploadify.swf',
                                                                'uploader' 			: 'uploadify.php',
																'buttonText' 		: 'Subir Foto',
																'onUploadSuccess' 	: function(file, data, response){
														            document.getElementById('img_'+input_3).src = 'uploads/'+file.name;
																	document.getElementById(input_3).value= 'uploads/'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    {/literal}
                                                    <div id="queue"></div>
                                                    <input id="file-name-3" name="file-name-3" type="file" />
                                                    <img src="#" id="img_OBLIsostenedor" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLIsostenedor"  name="OBLIsostenedor" value=""  />
                                             </td>
                                        </tr>
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<a href="#" onclick="javascript: ValidaFormularioMantenedor();">
											<img src='../images/basicos/guardar.png' title='Grabar' width="32"/>
										</a>
										<a href="#" onclick="javascript: document.Form1.submit();">
											<img src='../images/basicos/agregar.png' title='Nuevo' width="32"/>
										</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
                <div id="calendar-container"></div>
	</body>
</HTML>