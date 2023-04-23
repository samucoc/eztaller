<?php /* Smarty version 2.6.18, created on 2013-10-07 16:30:32
         compiled from sg_vehiculo_asociar_pv.tpl */ ?>
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
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">
			
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>
		
		<!-- mascara para fecha jquery-1.3.2.min.js -->
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
		
		<?php echo '
		
		<script type="text/javascript">
			$(document).ready(function() { 
                            $("#cboPersona").autocomplete({
                                source : \'busquedas/busqueda_persona.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'OBLI-txtCodCobrador\').value = rut;
                                    }
                                });
                            $("#cboPersona").change(function(){
                                if (document.getElementById(\'cboPersona\').value==\'\'){
                                    document.getElementById(\'OBLI-txtCodCobrador\').value = \'\';        
                                    }
                                });
                            $("#cboPatente").autocomplete({
                                source : \'busquedas/busqueda_vehiculo.php\'
                                });
                            }); 		
		</script>
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresi�n.");
				  
				   tmp.document.open();
				   tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			function exportar_excel(id_form, id_tabla)
			{
				 // Obtiene el contenido de la tabla indicada
				 var tabla = $("#" + id_tabla).html();
				 // A�ade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el c�digo en PHP
				 $("#" + id_form).submit();
			}
 		</script> 
                    <style>
                    .floatLeft{
                        float:left;
                    }
                    
                    </style>
		'; ?>

	</HEAD>
	<body  onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<form id="Form1" name="Form1" method="post" runat="server">
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/car.png" width="48" height="48"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Asignacion de Vehiculos</label></td>
						                        <input type="hidden" name="OBLI-txtptv" id="OBLI-txtptv"></input>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Trabajador:</td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                        <input name="cboPersona" id="cboPersona" value="" />
                                        <input type="hidden" name="OBLI-txtCodCobrador" id="OBLI-txtCodCobrador"></input>
									</td>	
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 15%">Patente:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 85%">
                                   		<input id="cboPatente" name="cboPatente" />
									</td>	
								</tr>
							<tr align="left">
	                            <td colspan="2" class="tabla-alycar-fila-botones">
	                                    <input type="button" name="btnGrabar" id="btnGrabar" value="Grabar" class="boton floatLeft" onclick="javascript: ValidaFormularioMantenedor();">
					    <input type="hidden" name="pagina_volver" id="pagina_volver" value="<?php echo $this->_tpl_vars['pagina_volver']; ?>
"/>
					    <input type="hidden" name="carga_veh" id="carga_veh" value="<?php echo $this->_tpl_vars['carga_veh']; ?>
"/>
					    <input type="hidden" name="carga_nom_pers" id="carga_nom_pers" value="<?php echo $this->_tpl_vars['carga_nom_pers']; ?>
"/>
					    <input type="hidden" name="carga_pers" id="carga_pers" value="<?php echo $this->_tpl_vars['carga_pers']; ?>
"/>
					    <input type="hidden" name="carga_monto" id="carga_monto" value="<?php echo $this->_tpl_vars['carga_monto']; ?>
"/>
					    <input type="hidden" name="carga_fecha" id="carga_fecha" value="<?php echo $this->_tpl_vars['carga_fecha']; ?>
"/>
					    <input type="hidden" name="pers_asig" id="pers_asig" value="<?php echo $this->_tpl_vars['pers_asig']; ?>
"/>
					    <input type="hidden" name="monto_dispo" id="monto_dispo" value="<?php echo $this->_tpl_vars['monto_dispo']; ?>
"/>
					    <input type="hidden" name="cargado" id="cargado" value="<?php echo $this->_tpl_vars['cargado']; ?>
"/>
	                                    <input style="display: none" type="button" name="btnVolver" id="btnVolver" value="Volver" class="boton floatLeft" onclick="document.location.href='<?php echo $this->_tpl_vars['pagina_volver']; ?>
?carga_veh=<?php echo $this->_tpl_vars['carga_veh']; ?>
&carga_nom_pers=<?php echo $this->_tpl_vars['carga_nom_pers']; ?>
&carga_pers=<?php echo $this->_tpl_vars['carga_pers']; ?>
&carga_monto=<?php echo $this->_tpl_vars['carga_monto']; ?>
&carga_fecha=<?php echo $this->_tpl_vars['carga_fecha']; ?>
&pers_asig=<?php echo $this->_tpl_vars['pers_asig']; ?>
&monto_dispo=<?php echo $this->_tpl_vars['monto_dispo']; ?>
&cargado=<?php echo $this->_tpl_vars['cargado']; ?>
'">	
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
	</body>
</HTML>