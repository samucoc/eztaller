<?php ob_start(); 
session_start(); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sistema de Arriendo y Facturaci&oacute;n - Vigomaq</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
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
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.23.custom.css"/>
</head>
<body>
<script>
self.moveTo(0,0);
self.resizeTo(screen.availWidth, screen.availHeight);
</script>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php');
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php');
		?>
	</div>
    <br />
    <br />
    <br />
    <br />
    <h2 align="right">
    	Consulta evaluación técnica
    </h2>
    <div align="left" class="control_gd" style="background-color:#06327D !important">
        <span class="Estilo7" >Seleccionar Equipo</span>
        <input name="equipo-control"  id="equipo-control" style="border:#FF0 1px solid" size="100"/>
	</div>
    <div id="resultado"> 
    </div>
<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script> 
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
	$(document).ready(function(){
		$( "#equipo-control" ).autocomplete({
			source: "classes/consulta_eva_tec/buscar_eva_tec.php",
			minLength: 1,
			focus: function(event,ui){
				var value =  ui.item.id;
				$.ajax({
					url: 'classes/consulta_eva_tec/buscar_equipos_et.php?nombre_equipo='+value,
					type : 'POST',
					success: function(data){
						$("#resultado").html(data);
						}
					});
				},
			select: function( event, ui ) {
				var value =  ui.item.id;
				$.ajax({
					url: 'classes/consulta_eva_tec/buscar_equipos_et.php?nombre_equipo='+value,
					type : 'POST',
					success: function(data){
						$("#resultado").html(data);
						}
					});
				}
			});
		});
	</script>
</body>
</html>