<?php
/* Smarty version 3.1.33, created on 2020-02-04 08:36:07
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_generacion_inscripcion_alumno.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e3957272d7f68_95859396',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7c238ec25620f227f10d5d9fb44fbb87e5210ba' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_generacion_inscripcion_alumno.tpl',
      1 => 1580816163,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e3957272d7f68_95859396 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>
		
		<!-- aqui se puede agregar el cod. para la norma de las p�ginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librer�a principal del calendario -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar.js"><?php echo '</script'; ?>
>
		<!-- librer�a para cargar el lenguaje deseado --> 
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/lang/calendar-es.js"><?php echo '</script'; ?>
>
		<!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
		<?php echo '<script'; ?>
 type="text/javascript" src="calendario/calendar-setup.js"><?php echo '</script'; ?>
>
                
        <!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/common.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="submodal/subModal.js"><?php echo '</script'; ?>
>
		
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"><?php echo '</script'; ?>
>
                        <?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"><?php echo '</script'; ?>
>
                        
		
        <SCRIPT language="javascript">
			function checkAll(theForm, cName, status) {
				for (i=0,n=theForm.elements.length;i<n;i++)
				  if (theForm.elements[i].className.indexOf(cName) !=-1) {
					theForm.elements[i].checked = status;
				  }
				}
			var patron = new Array(2,2,4)
			var patron2 = new Array(1,3,3,3,3)
			function mascara(d,sep,pat,nums){
				if(d.valant != d.value){
					val = d.value
					largo = val.length
					val = val.split(sep)
					val2 = ''
					for(r=0;r<val.length;r++){
						val2 += val[r]	
					}
					if(nums){
						for(z=0;z<val2.length;z++){
							if(isNaN(val2.charAt(z))){
								letra = new RegExp(val2.charAt(z),"g")
								val2 = val2.replace(letra,"")
							}
						}
					}
					val = ''
					val3 = new Array()
					for(s=0; s<pat.length; s++){
						val3[s] = val2.substring(0,pat[s])
						val2 = val2.substr(pat[s])
					}
					for(q=0;q<val3.length; q++){
						if(q ==0){
							val = val3[q]
						}
						else{
							if(val3[q] != ""){
								val += sep + val3[q]
								}
						}
					}
					d.value = val
					d.valant = val
					}
				}			
		</SCRIPT>
        <?php echo '<script'; ?>
 type="text/javascript">
			$(function($) { 
				$('#fech_nac').mask("99/99/9999");
				$('#fecha_nac_apoderado').mask("99/99/9999");
				$('#fech_nac_mama').mask("99/99/9999");
				$('#fech_nac_papa').mask("99/99/9999");
				}
			); 		
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript">
			$(document).ready(function() { 
                            $.datepicker.regional['es'] = {
                                  closeText: 'Cerrar',
                                  prevText: '<Ant',
                                  nextText: 'Sig>',
                                  currentText: 'Hoy',
                                  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                                  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                  dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
                                  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
                                  weekHeader: 'Sm',
                                  dateFormat: 'dd/mm/yy',
                                  firstDay: 1,
                                  isRTL: false,
                                  showMonthAfterYear: false,
                                  yearSuffix: ''};
                           $.datepicker.setDefaults($.datepicker.regional['es']);                            
                            $('#fech_nac, #fecha_nac_apoderado, #fech_nac_mama, #fech_nac_papa').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : 'busquedas/busqueda_alumno.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('OBLIRutAlumno').value = rut;
                                    }
                                });
                             
                            });
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" > 
                        function verificaValor(temp){
                            if (temp==''){
                                document.getElementById('OBLI-txtCodCobrador').value="";
                                }
                            }
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
 		<?php echo '</script'; ?>
> 

		
	
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
	<!--<body style="background:#ffffff;"> -->
		<form id="Form1" name="Form1" method="post" runat="server">
		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
							<br>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
									<td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Generacion inscripcion alumno</label></td>
								</tr>
							</table>
							<br>
							<table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
								  <td class="tabla-alycar-texto" ><img src='../images/Logo Arcoiris.png'/></td>	
								  <td class="tabla-alycar-texto"  colspan="2">Matricula</td>	
								  <td class="tabla-alycar-texto" >Nro: <input type="text" name="nro_ficha" id="nro_ficha" /></td>	
								</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">I. DATOS ESTABLECIMIENTO</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">Nombre:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	ESCUELA DE LENGUAJE “ARCOÍRIS”.	
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	CONTACTO
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">RBD-DV:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	14802 -4
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<table>
								  		<tr>
								  			<td>
								  				Teléfonos
								  			</td>
								  			<td>
								  				032-<input type="text" name="fono_contacto" id="fono_contacto">
								  			</td>
								  		</tr>
								  	</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">DIRECCIÓN:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	Sargento Candelaria Pérez 290, Villa Yungay.
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<table>
								  		<tr>
								  			<td>
								  				
								  			</td>
								  			<td>
								  				09 - <input type="text" name="celular_contacto" id="celular_contacto">
								  			</td>
								  		</tr>
								  	</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">COMUNA:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	Villa Alemana.
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<table>
								  		<tr>
								  			<td>
								  				Direccion
								  			</td>
								  			<td>
								  				<input type="text" name="direccion_contacto" id="direccion_contacto">
								  			</td>
								  		</tr>
								  	</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">DEPROV:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	Valparaiso e Isla de Pascua
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Region
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	V
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 15%">FONO:</td>	
								  <td class="tabla-alycar-texto" style="width: 20%" colspan="2">
								  	032- 2731164 / 09- 57396239.
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">II. IDENTIFICACION ALUMNO</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Apellido Paterno
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="apellido_pat" id="apellido_pat">
                                  </td>
							  	  <td class="tabla-alycar-label" style="width: 20%">
								  	Apellido Materno
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="apellido_mat" id="apellido_mat">
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Nombres
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="nombres" id="nombres">
                                  </td>
                                  <td class="tabla-alycar-label" style="width: 20%">
									Fecha Nacimiento
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="fech_nac" id="fech_nac">
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									RUN
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="run" id="run">
                                  </td>
                                  <td colspan="2" class="tabla-alycar-texto" >
                                  	<table>
                                  		<tr>
                                  			<td>Asistió a jardin anteriormente</td>
                                  			<td>SI <input type="radio" name="asistio_jardin" id="asistio_jardin_si" value="1" /></td>
                                  			<td>NO <input type="radio" name="asistio_jardin" id="asistio_jardin_no" value="0" /></td>
                                  			<td>Niveles</td>
                                  		</tr>
                                  	</table>
                                  </td>
							  	</tr>
								
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Domicilio (Referencias)
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<textarea name="direccion" id="direccion" rows="5" cols="100"></textarea>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">III. ANTECEDENTES APODERADO</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Parentesco
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<input type="text" name="parentesco_apoderado" id="parentesco_apoderado">
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Apellido Paterno
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="apellido_pat_apoderado" id="apellido_pat_apoderado">
                                  </td>
							  	  <td class="tabla-alycar-label" style="width: 20%">
								  	Apellido Materno
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="apellido_mat_apoderado" id="apellido_mat_apoderado">
                                  </td>
							  	</tr>
								
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Nombres
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<input type="text" name="nombres_apoderado" id="nombres_apoderado">
                                  </td>
							  	  <
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Fecha Nacimiento
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="fecha_nac_apoderado" id="fecha_nac_apoderado">
                                  </td>
							  	  <td class="tabla-alycar-label" style="width: 20%" colspan="2">
								 		<table>
								 			<tr>
								 				<td>Edad</td>
								 				<td><input type="text" name="edad_apoderado" id="edad_apoderado"></td>
								 				<td>Rut</td>
								 				<td><input type="text" name="rut_apoderado" id="rut_apoderado" /></td>
								 			</tr>

								 		</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Domicilio (Referencias)
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<textarea name="direccion_apoderado" id="direccion_apoderado" rows="5" cols="100"></textarea>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Teléfonos de Contacto
                                  </td>
                                  <td class="tabla-alycar-label" style="width: 20%" colspan="3">
								 		<table>
								 			<tr>
								 				<td>Mamá</td>
								 				<td><input type="text" name="mama_telefono_apoderado" id="mama_telefono_apoderado"></td>
								 				<td>Papá</td>
								 				<td><input type="text" name="papa_telefono_apoderado" id="papa_telefono_apoderado" /></td>
								 				<td>Trabajo</td>
								 				<td><input type="text" name="trabajo_telefono_apoderado" id="trabajo_telefono_apoderado" /></td>
								 			</tr>
								 			<tr>
								 				<td>Abuelos</td>
								 				<td><input type="text" name="abuelo_telefono_apoderado" id="abuelo_telefono_apoderado"></td>
								 				<td>Hermanos</td>
								 				<td><input type="text" name="hermano_telefono_apoderado" id="hermano_telefono_apoderado" /></td>
								 				<td>Otros</td>
								 				<td><input type="text" name="otros_telefono_apoderado" id="otros_telefono_apoderado" /></td>
								 			</tr>
								 		</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Correo Electronico
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<input type="text" name="email_apoderado" id="email_apoderado" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Años Escolaridad
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="escolaridad_apoderado" id="escolaridad_apoderado" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Profesión
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="profesion_apoderado" id="profesion_apoderado" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Ocupación
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<input type="text" name="ocupacion_apoderado" id="ocupacion_apoderado" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Compromiso
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<ul>
								  		<li>Asistir a las reuniones que el colegio me cite</li>
								  		<li>Concurrir obligatoriamente al colegio por citacion de direccion</li>
								  		<li>Responsabilizarme directamente de los daños ocasionados por mi pupilo; aunque fueses involuntarios</li>
										<li>Conocer el proyecto educativo, reglamento interno del colegio y cumplirlo</li>
										<li>Asistir a los talleres dictados por el colegio en ayuda a mi pupilo</li>
										<li>Conocer el diagnostico de mi pupilo y sus respectivos avances</li>
										<li>Cumplir con la asistencia y puntualidad</li>
								  	</ul>
								  	<p>SI <input type="radio" name="asistio_jardin" id="asistio_jardin_si" value="1" /></p>
                                  	<p>NO <input type="radio" name="asistio_jardin" id="asistio_jardin_no" value="0" /></p>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">IV. ANTECEDENTES FAMILIARES</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Alumno vive con 
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	<input type="text" name="vive_con" id="vive_con" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Total Hermanos
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="total_hermanos" id="total_hermanos" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%" colspan="2">
									<table>
										<td>Edades</td>
										<td><input type="text" name="edades_hermanos" id="edades_hermanos"></td>
										<td>Lugar que ocupa</td>
										<td><input type="text" name="lugar_hermanos" id="lugar_hermanos"></td>
									</table>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Situacion conyugal de los padres
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	Casados <input type="radio" name="situacion_conyugal_padres" id="situacion_conyugal_padres_0" value="0" />
		                           	Separados <input type="radio" name="situacion_conyugal_padres" id="situacion_conyugal_padres_1" value="1" />
								  	Convivientes <input type="radio" name="situacion_conyugal_padres" id="situacion_conyugal_padres_2" value="2" />
                                  	Madre Soltera <input type="radio" name="situacion_conyugal_padres" id="situacion_conyugal_padres_3" value="3" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">V. ANTECEDENTES DE LA MADRE</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Apellido Paterno
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="apellido_pat_mama" id="apellido_pat_mama" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Apellido Materno
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="apellido_mat_mama" id="apellido_mat_mama" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Nombres
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="nombres_mama" id="nombres_mama" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Fecha Nacimiento
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="fech_nac_mama" id="fech_nac_mama" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Estado Civil
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="estado_civil_mama" id="estado_civil_mama">
                                  </td>
							  	  <td class="tabla-alycar-label" style="width: 20%" colspan="2">
								 		<table>
								 			<tr>
								 				<td>Edad</td>
								 				<td><input type="text" name="edad_mama" id="edad_mama"></td>
								 				<td>Rut</td>
								 				<td><input type="text" name="rut_mama" id="rut_mama" /></td>
								 			</tr>

								 		</table>
                                  </td>
							  	</tr>	
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Fonos
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="telefonos_mama" id="telefonos_mama" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Correo Electronico
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="email_mama" id="email_mama" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Ocupación
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="ocupacion_mama" id="ocupacion_mama" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Lugar de trabajo (Fono)
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="lugar_trabajo_mama" id="lugar_trabajo_mama" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Años Escolaridad
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="escolaridad_mama" id="escolaridad_mama" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Profesión
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="profesion_mama" id="profesion_mama" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">VI. ANTECEDENTES DE LA PADRE</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Apellido Paterno
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="apellido_pat_papa" id="apellido_pat_papa" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Apellido Materno
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="apellido_mat_papa" id="apellido_mat_papa" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Nombres
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="nombres_papa" id="nombres_papa" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Fecha Nacimiento
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="fech_nac_papa" id="fech_nac_papa" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
								  	Estado Civil
                                  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="estado_civil_papa" id="estado_civil_papa">
                                  </td>
							  	  <td class="tabla-alycar-label" style="width: 20%" colspan="2">
								 		<table>
								 			<tr>
								 				<td>Edad</td>
								 				<td><input type="text" name="edad_papa" id="edad_papa"></td>
								 				<td>Rut</td>
								 				<td><input type="text" name="rut_papa" id="rut_papa" /></td>
								 			</tr>

								 		</table>
                                  </td>
							  	</tr>	
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Fonos
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="telefonos_papa" id="telefonos_papa" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Correo Electronico
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="email_papa" id="email_papa" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Ocupación
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="ocupacion_papa" id="ocupacion_papa" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Lugar de trabajo (Fono)
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%">
								  	<input type="text" name="lugar_trabajo_papa" id="lugar_trabajo_papa" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Años Escolaridad
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="escolaridad_papa" id="escolaridad_papa" />
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									Profesión
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<input type="text" name="profesion_papa" id="profesion_papa" />
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" colspan="4">VI. ANTECEDENTES DE SALUD</td>	
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Alérgico
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	SI <input type="radio" name="alergico" id="alergico_0" value="0" />
		                           	NO <input type="radio" name="alergico" id="alergico_1" value="1" />
								  	
                                  </td>
								  <td class="tabla-alycar-label" style="width: 20%">
									A qué?
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" >
								  	<textarea name="alergias" id="alergias" cols="100" rows="5"></textarea>
                                  </td>
							  	</tr>
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Esta en tratamiento
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	Psicológico <input type="checkbox" name="trata_psico" id="trata_psico" />
		                           	Nutricionista <input type="checkbox" name="trata_nutri" id="trata_nutri" />
		                           	Neurológico <input type="checkbox" name="trata_neuro" id="trata_neuro" />
		                           	Otros <input type="text" name="trata_otros" id="trata_otros" />
                                  </td>
							  	</tr>
								
								<tr align="left">
								  <td class="tabla-alycar-label" style="width: 20%">
									Sistema Salud
								  </td>
                                  <td class="tabla-alycar-texto" style="width: 20%" colspan="3">
								  	Fonasa <input type="checkbox" name="fonasa" id="fonasa" />
		                           	Isapre <input type="checkbox" name="isapre" id="isapre" />
		                           	Dipreca <input type="checkbox" name="dipreca" id="dipreca" />
		                           	FFAA <input type="checkbox" name="ffaa" id="ffaa" />
                                  </td>
							  	</tr>
								

								<tr align="left">
									<td colspan="2" class="tabla-alycar-fila-botones">
										<a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
											<img src='../images/basicos/buscar.png' title='Buscar' width="32"/>
										</a></td>
								</tr>
							
							</table>
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
										<div id='divabonos'><div>
									</td>
								</TR>
								 <tr align="left">
									<td>
										  <a href="#" style="cursor: hand;"><img src="../images/gest_fin/respaldos.png" border=0 title="Generar PDF" onclick="xajax_GenerarPDF(xajax.getFormValues('Form1'));" width="32"></a>
										 <a href="#" style="cursor: hand;"><img src="../images/basicos/email2.png" border=0 title="Enviar Correo Apoderado" onclick="xajax_EnivarPDF(xajax.getFormValues('Form1'));" width="32"></a>
    
 									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML><?php }
}
