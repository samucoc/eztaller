<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
               <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
            <link rel="stylesheet" type="text/css" href="../includes_js/uploadify/uploadify.css"/>
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/uploadify/jquery.uploadify.js"></script>
		{literal}
			<script type="text/javascript">
				$(document).ready(function() { 
					$("#OBLIempresa").autocomplete({
					source : 'busquedas/busqueda_empresa.php',
					select: function( event, ui ) {
						var rut = ui.item.id;
						var valor = ui.item.value;
						document.getElementById('nombre_empresa').value = valor;
						document.getElementById('empresa').value = rut;
						}
					});	
				});
			</script>
        {/literal}
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server" enctype="multipart/form-data">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%">
                                    	<label class="form-titulo">&nbsp;&nbsp;Cargas Masivas Boletas</label>
                                        <input type="hidden" name="nombre_archivo" id="nombre_archivo"/>
                                    </td>
								</tr>
							</table>
							<br>
                            <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Archivo:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="OBLIempresa" type="text" id="OBLIempresa" value="{$nombre_empresa}" size="50"/>
                                        <input type="hidden" id="nombre_empresa" name="nombre_empresa"  value="{$nombre_empresa}"/>
                                        <input type="hidden" id="empresa" name="empresa"  value="{$empresa}"/>
									</td>	
								</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">Mes Contable:</td>
								  <td class="tabla-alycar-texto" style="width: 80%"> Mes:
								    <select id="cboMes" name="cboMes" onkeypress="return Tabula(this, event, 0)">
								      <option value='1'>Enero</option>
								      <option value='2'>Febrero</option>
								      <option value='3'>Marzo</option>
								      <option value='4'>Abril</option>
								      <option value='5'>Mayo</option>
								      <option value='6'>Junio</option>
								      <option value='7'>Julio</option>
								      <option value='8'>Agosto</option>
								      <option value='9'>Septiembre</option>
								      <option value='10'>Octubre</option>
								      <option value='11'>Noviembre</option>
								      <option value='12'>Diciembre</option>
							        </select>
								    &nbsp;&nbsp;
								    A&ntilde;o:
								    <select id="cboAnio" name="cboAnio" onkeypress="return Tabula(this, event, 0)">
								      <option value='2011'>2011</option>
								      <option value='2012'>2012</option>
								      <option value='2013'>2013</option>
								      <option value='2014'>2014</option>
								      <option value='2015'>2015</option>
								      <option value='2016'>2016</option>
							        </select></td>
							  </tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Archivo Formato:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<a href="formato_cmb.xlsx" target="_blank"> Archivo Formato</a>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Archivo:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
										<input type="file" name="archivo" id="archivo"/>
									</td>	
								</tr>
								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<input type="submit" name="btnGrabar"  id="btnGrabar" value="Grabar" class="boton" />
									</td>
								</tr>
                            </table>
						</form>

					</td>
				</tr>
			</table>
		</div>					
		        <div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divabonos'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		<div id="calendar-container"></div>
	
	</body>
</HTML>