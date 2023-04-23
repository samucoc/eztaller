<?php ob_start(); 
session_start(); 


if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />

<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
var anteriorFilaSeleccionada = null;
function selecciona(fila){
    var celdasEnFila = fila.getElementsByTagName("TD");
	alert(celdasEnFila);
}
</script> 
<script type="text/javascript">
function asignar_valor(celda) {
  cod = celda.getElementsByTagName('td')[0].innerHTML;
  com = celda.getElementsByTagName('td')[1].innerHTML;
  cot = celda.getElementsByTagName('td')[2].innerHTML;
  
  document.forms[0]['txt_cod'].value = cod;
  document.forms[0]['txt_obra'].value = com;
  document.forms[0]['txt_equipo'].value = cot;
}
</script>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo19 {	color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
</style> 
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
</head>
<body>
<table width="85%" border="0">
   <tr>
     <td width="52%"><img src="images/logo.jpg" width="377" height="104" /></td>
     <td valign="middle"><div align="right" class="Estilo2"><br />
       <br />
       <span class="Estilo21"><br />
       Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</span></div></td>
   </tr>
</table>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
<p>&nbsp;</p>
</div>
<br class="clearFloat"/>
<div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12" style="padding:10px;">
  <div align="right" class="Estilo19">
    <div align="right" class="Estilo20">Ventas por Cliente</div>
  </div>
</div>
<div align="left" class="control_gd" style="background-color:#06327D !important">
	<span class="Estilo7" >SELECCIONAR Rut Cliente </span>
      	<input  id="rut-control" name="rut-control" style="padding:5px; border:#FF0 1px solid"/>
</div>
<div id="resultado"> 
</div>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
	$(document).ready(function() {
		$( "#rut-control" ).autocomplete({
			source: "classes/listado_vtas/buscar_rut.php",
			minLength: 1,
			focus: function(event,ui){
				var value =  ui.item.value;
				$.ajax({
					url: 'classes/listado_vtas/mostrar_resultado.php?rut_cliente='+value,
					type : 'POST',
					success: function(data){
						$("#resultado").html(data);
						}
					});
				},
			select: function( event, ui ) {
				var value =  ui.item.value;
				$.ajax({
					url: 'classes/listado_vtas/mostrar_resultado.php?rut_cliente='+value,
					type : 'POST',
					success: function(data){
						$("#resultado").html(data);
						}
					});
			}
		});
	});
</script>

<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
</body>

</html>	