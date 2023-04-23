<?php /* Smarty version 2.6.18, created on 2016-09-29 12:36:07
         compiled from sg_mant_tablas.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
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

			<?php echo '
			<script type="text/javascript">
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
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
            '; ?>

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
											&nbsp;&nbsp; <?php echo $this->_tpl_vars['TITULO_TABLA']; ?>

											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $this->_tpl_vars['TABLA']; ?>
'>
                                            <input type="hidden" id="rut_papa" name="rut_papa" value="<?php echo $this->_tpl_vars['rut_trab']; ?>
"/>
											<input type="hidden" id="rut_alumno_bitacora" name="rut_alumno_bitacora" value="<?php echo $this->_tpl_vars['rut_alumno_bitacora']; ?>
"/>
											<input type="hidden" id="arr_select" name="arr_select"/>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                                <?php if (( $this->_tpl_vars['TABLA'] == 'alumnos' )): ?>
                                	<tr align="left">
                                    	<td class="tabla-alycar-texto" colspan="2">
		                                	<input type="button" name="ficha_alumno" id="ficha_alumno" onclick="location.href='sg_mant_tablas.php?tbl=alumnos'"  class="boton" value="Fichas Alumnos"/>
		                                	<input type="button" name="btnNotas" id="btnNotas" onclick="xajax_CargaListado_alumnos_Notas(xajax.getFormValues('Form1'))"  class="boton" value="Notas"/>
		                                	<input type="button" name="btnHojaVida" id="btnHojaVida" onclick="xajax_CargaListado_alumnos_HojaVida(xajax.getFormValues('Form1'))"  class="boton" value="Hoja de vida"/>
		                                	<input type="button" name="btnAsistencia" id="btnAsistencia" onclick="xajax_CargaListado_alumnos_Asistencia(xajax.getFormValues('Form1'))"  class="boton" value="Asistencia"/>
                                    	</td>
                                    </tr>
                                <?php endif; ?>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								<?php if (( $this->_tpl_vars['TABLA'] == trabajadores_tienen_cargas )): ?>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Rut Trabajador</td>
									<td class="tabla-alycar-texto" style="width: 70%"><?php echo $this->_tpl_vars['rut']; ?>
<input type="hidden" id="OBLIrut_papa" name="OBLIrut_papa" value="<?php echo $this->_tpl_vars['rut_trab']; ?>
"/></td>
								</tr>
                                <?php endif; ?>
								<?php unset($this->_sections['campos']);
$this->_sections['campos']['name'] = 'campos';
$this->_sections['campos']['loop'] = is_array($_loop=$this->_tpl_vars['arrCampos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['campos']['show'] = true;
$this->_sections['campos']['max'] = $this->_sections['campos']['loop'];
$this->_sections['campos']['step'] = 1;
$this->_sections['campos']['start'] = $this->_sections['campos']['step'] > 0 ? 0 : $this->_sections['campos']['loop']-1;
if ($this->_sections['campos']['show']) {
    $this->_sections['campos']['total'] = $this->_sections['campos']['loop'];
    if ($this->_sections['campos']['total'] == 0)
        $this->_sections['campos']['show'] = false;
} else
    $this->_sections['campos']['total'] = 0;
if ($this->_sections['campos']['show']):

            for ($this->_sections['campos']['index'] = $this->_sections['campos']['start'], $this->_sections['campos']['iteration'] = 1;
                 $this->_sections['campos']['iteration'] <= $this->_sections['campos']['total'];
                 $this->_sections['campos']['index'] += $this->_sections['campos']['step'], $this->_sections['campos']['iteration']++):
$this->_sections['campos']['rownum'] = $this->_sections['campos']['iteration'];
$this->_sections['campos']['index_prev'] = $this->_sections['campos']['index'] - $this->_sections['campos']['step'];
$this->_sections['campos']['index_next'] = $this->_sections['campos']['index'] + $this->_sections['campos']['step'];
$this->_sections['campos']['first']      = ($this->_sections['campos']['iteration'] == 1);
$this->_sections['campos']['last']       = ($this->_sections['campos']['iteration'] == $this->_sections['campos']['total']);
?>
									<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo'] != '' )): ?>
										<tr align="left">
											<td class="tabla-alycar-label" style="width: 30%"><?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo']; ?>
<label class="requerido"> * </label></td>
											<td class="tabla-alycar-texto" style="width: 70%">
                                            	<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'SELECT' )): ?>
                                                    <SELECT id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" onchange=" xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
','<?php echo $this->_tpl_vars['TABLA']; ?>
');xajax_CargaSelect_1(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
')" > 
                                                    </SELECT>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'FECHA' )): ?>
													<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'FechaBoleta' ) && ( $this->_tpl_vars['TABLA'] == 'Movimientos' )): ?>
														<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" onchange="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
','<?php echo $this->_tpl_vars['TABLA']; ?>
');">
	                                                        <a href="#" style="cursor: hand;">
	                                                        	<img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario">
	                                                        </a>
	                                                        <script type="text/javascript">
	                                                                var input = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                var button = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
	                                                                <?php echo '
	                                                                Calendar.setup({inputField : input, 
																					ifFormat : "%d/%m/%Y",
																					showstime: true,
																					button : button ,
																					step: 1});
	                                                                $(function($) { 
	                                                                        $(\'#\'+input).mask("99/99/9999");
	                                                                        }
	                                                                ); 		
	                                                        </script>                                                                               
	                                                        '; ?>

	                                                    

													<?php else: ?>
													<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" class="OBLI-fecha" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly">
                                                        <a href="#" style="cursor: hand;"><img  id='cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
                                                        <script type="text/javascript">
                                                                var input = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
                                                                var button = "cld<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
                                                                <?php echo '
                                                                Calendar.setup({inputField : input, 
																				ifFormat : "%d/%m/%Y",
																				showstime: true,
																				button : button ,
																				step: 1});
                                                                $(function($) { 
                                                                        $(\'#\'+input).mask("99/99/9999");
                                                                        }
                                                                ); 		
                                                        </script>                                                                               
                                                        '; ?>

                                                    <?php endif; ?>
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'PASSWORD' )): ?>
													<INPUT type="password"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'NUMERO' )): ?>
													<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroBoleta' ) && ( $this->_tpl_vars['TABLA'] == 'Movimientos' )): ?>
														<INPUT type="text" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50"
														onblur="xajax_CargaListado(xajax.getFormValues('Form1'),'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
','<?php echo $this->_tpl_vars['TABLA']; ?>
');">
													<?php else: ?>
                                                		<INPUT type="text"  id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="100" size="50">
                                                	<?php endif; ?>

												<?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'RUT' )): ?>
													<INPUT type="text" class="rut" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' />
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'OPC' )): ?>
													<INPUT type="text" class="rut" id="<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" />
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'CHECK' )): ?>
													<INPUT type="checkbox" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" value="1"/>
                                                <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'FOTO' )): ?>
													<script type="text/javascript">
													var input_1 = "OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
";
													<?php echo '
                                                        $(function() {
                                                            $(\'#file-name\').uploadify({
                                                                \'swf\'      			: \'uploadify.swf\',
                                                                \'uploader\' 			: \'uploadify.php\',
																\'buttonText\' 		: \'Subir Foto\',
																\'onUploadSuccess\' 	: function(file, data, response){
														            document.getElementById(\'img_\'+input_1).src = \'uploads/\'+file.name;
																	document.getElementById(input_1).value= \'uploads/\'+file.name;
        														}
                                                            });
                                                        });
                                                    </script> 
                                                    '; ?>

                                                    <div id="queue"></div>
                                                    <input id="file-name" name="file-name" type="file" />
                                                    <img src="#" id="img_OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" title="" width="200" height="200" />
                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"  name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value=""  />
		                                        <?php elseif (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'BUSCA' )): ?>
		                                        	<?php if ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'PaternoApoderado'): ?>
														<input type="text" id="BSCPaternoApoderado" name="BSCPaternoApoderado" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLIPaternoApoderado" name="OBLIPaternoApoderado"/>
	                                                    <script type="text/javascript">
														var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
	                                                    <?php echo '
															$(document).ready(function() {
																$("#BSCPaternoApoderado").autocomplete({
																	source : \'busquedas/busqueda_OBLIPaternoApoderado.php\',
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

																		document.getElementById(\'txtNcorr\').value = ncorr;
																		document.getElementById(\'OBLINumeroRutApoderado\').value = rut;
																		document.getElementById(\'OBLIPaternoApoderado\').value = apellidoPaterno;
																		document.getElementById(\'BSCPaternoApoderado\').value = apellidoPaterno;
																		document.getElementById(\'OBLIMaternoApoderado\').value = MaternoApoderado;
																		document.getElementById(\'BSCNombresApoderado\').value = NombresApoderado;
																		document.getElementById(\'OBLINombresApoderado\').value = NombresApoderado;
																		document.getElementById(\'OBLIDireccionParticularApoderado\').value = DireccionParticularApoderado;
																		document.getElementById(\'OBLITelefonoParticularApoderado\').value = TelefonoParticularApoderado;
																		document.getElementById(\'OBLITelefonoMovilApoderado\').value = TelefonoMovilApoderado;
																		document.getElementById(\'OBLIEMailApoderado\').value = EMailApoderado;
																		document.getElementById(\'OBLINumeroRutAval\').value = NumeroRutAval;
																		document.getElementById(\'OBLIPaternoAval\').value = PaternoAval;
																		document.getElementById(\'OBLIMaternoAval\').value = MaternoAval;
																		document.getElementById(\'OBLINombresAval\').value = NombresAval;
																		document.getElementById(\'OBLIDireccionAval\').value = DireccionAval;
																		}
																	});
																});
	                                                    </script>
														'; ?>

		                                        	<?php elseif ($this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NombresApoderado'): ?>
														<input type="text" id="BSCNombresApoderado" name="BSCNombresApoderado" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLINombresApoderado" name="OBLINombresApoderado"/>
	                                                    <script type="text/javascript">
														var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
	                                                    <?php echo '
															$(document).ready(function() {
																$("#BSCNombresApoderado").autocomplete({
																	source : \'busquedas/busqueda_OBLINombresApoderado.php\',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		document.getElementById(\'OBLINombresApoderado\').value = rut;
																		xajax_CargaListado(xajax.getFormValues(\'Form1\'),\'OBLINombresApoderado\',tabla);
																		}
																	});
																});
	                                                    </script>
														'; ?>

		                                        	<?php else: ?>
														<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'NumeroRutApoderado' ) && ( $this->_tpl_vars['TABLA'] == 'Bitacoras' )): ?>
															<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50" readonly="readonly" />
	                                                    	<input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
														<?php else: ?>
														<input type="text" id="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50"/>
	                                                    <input type="hidden" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
"/>
	                                                    <script type="text/javascript">
														var	obli = 'OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var combo = 'BSC<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
';
														var tabla = '<?php echo $this->_tpl_vars['TABLA']; ?>
';
	                                                    <?php echo '
															$(document).ready(function() {
																$("#"+combo).autocomplete({
																	source : \'busquedas/busqueda_\'+obli+\'.php\',
																	select: function( event, ui ) {
																		var rut = ui.item.id;
																		document.getElementById(obli).value = rut;
																		xajax_CargaListado(xajax.getFormValues(\'Form1\'),obli,tabla);
																		}
																	});
																});
	                                                    </script>
														'; ?>

														<?php endif; ?>
													<?php endif; ?>
                                                <?php else: ?>
                                                	<INPUT type="text" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, e	vent, 0)" maxLength="100" size="50">
												<?php endif; ?>	
											</td>
										</tr>
									<?php endif; ?>
									<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo'] == 'CodigoTipoBeca' ) && ( $this->_tpl_vars['TABLA'] == 'Becas' )): ?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Beca Incorporacion</td>
										<td class="tabla-alycar-texto" style="width: 70%" id="beca_incorporacion"></td>
									</tr>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Beca Colegiatura</td>
										<td class="tabla-alycar-texto" style="width: 70%" id="beca_colegiatura"></td>
									</tr>
									<?php endif; ?>
								<?php endfor; endif; ?>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
                                    	<?php if (( $this->_tpl_vars['volver'] == 'si' ) && ( ( $this->_tpl_vars['TABLA'] == 'clientes' ) || ( $this->_tpl_vars['TABLA'] == 'proveedores' ) || ( $this->_tpl_vars['TABLA'] == 'prestadores' ) )): ?>
                                        <input type="button" class="boton" value="Volver"name="btnVolver" onclick="document.location.href='<?php echo $this->_tpl_vars['pagina_volver']; ?>
?nombre_empresa=<?php echo $this->_tpl_vars['nombre_empresa']; ?>
&empresa=<?php echo $this->_tpl_vars['empresa']; ?>
&fecha=<?php echo $this->_tpl_vars['fecha']; ?>
&cliente=<?php echo $this->_tpl_vars['cliente']; ?>
&rut=<?php echo $this->_tpl_vars['rut']; ?>
&nro_factura=<?php echo $this->_tpl_vars['nro_factura']; ?>
&neto=<?php echo $this->_tpl_vars['neto']; ?>
&iva=<?php echo $this->_tpl_vars['iva']; ?>
&total=<?php echo $this->_tpl_vars['total']; ?>
'"/>
                                        <?php endif; ?>
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
										<?php if ($this->_tpl_vars['TABLA'] != 'Apoderados'): ?>
										<div id='divresultado'></div>
										<?php endif; ?>
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