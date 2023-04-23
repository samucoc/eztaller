<?php 

ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sistema de Arriendo y Facturaci&oacute;n :: VigoMaq ::</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/interface.js"></script>

<!--[if lt IE 7]>
 <style type="text/css">
 .dock img { behavior: url(iepngfix.htc) }
 </style>
<![endif]-->

<link href="dock.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>
<!--bottom dock -->
<div class="dock" id="dock2">
  <div class="dock-container2">
  <a class="dock-item2" href="menu.php"><span>Inicio</span><img src="images/home.png" alt="Gestion" /></a> 
  <a class="dock-item2" href="arriendo_cliente.php"><span>Arriendo</span><img src="images/arriendo.png" alt="Inicio" /></a> 
  <a class="dock-item2" href="arriendo_devolver.php"><span>Devolucion</span><img src="images/devoluciones.png" alt="Archivos" /></a> 
  <a class="dock-item2" href="reclamo.php"><span>Reclamo/Cambio Equipo</span><img src="images/reclamo.png" alt="Servicios" /></a> 
  <a class="dock-item2" href="factura.php"><span>Ventas</span><img src="images/bag.png" alt="Facturacion" /></a> 
  <a class="dock-item2" href="arriendos_fact.php"><span>Equipos por Facturar</span><img src="images/buscadorFacturas.png" alt="Archivos" /></a>
  <a class="dock-item2" href="facturar.php"><span>Facturar</span><img src="images/facturar.png" alt="rss" /></a>  
  <a class="dock-item2" href="evaluacion.php"><span>Evaluacion Tecnica</span><img src="images/servicio.png" alt="Reportes" /></a> 
  <a class="dock-item2" href="reparar_equipo.php"><span>Reparacion Tecnica</span><img src="images/serv_tec.png" alt="Salir" /></a> 
     </div>
</div>

<div align="center">
  <!--dock menu JS options -->
  <script type="text/javascript">
	
	$(document).ready(
		function()
		{
			$('#dock2').Fisheye(
				{
					maxWidth: 120,
					items: 'a',
					itemsText: 'span',
					container: '.dock-container2',
					itemWidth: 80,
					proximity: 160,
					alignment : 'left',
					valign: 'bottom',
					halign : 'center'
				}
			)
		}
	);

</script>
</div>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><img src="images/logo.jpg" width="377" height="104" align="absmiddle" />
                    </p>
</div>
</body>
</html>
