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
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
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
.ui-datepicker-trigger{
	width:32px;
	height:32px;
	}
.ui-datepicker-trigger img{
	float:left;
	}
#warp{
	padding-left:10%;
	width:80%;
	}
.div-busqueda{
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
.div-busqueda a{
	padding:5px;
	}	
#spinner{
	display:none;
	top:50%;
	padding-top:10%;
	left:50%;
	padding-left:45%;
	}
-->
</style>
</head>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
    <br />
    <br />
    <br />
    <br />
    <div id="warp">
    	<H4>Libro Compras - Ventas</H4>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Fecha Inicio
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
                <input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="50" class="floatLeft" />
            </div>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Fecha Fin
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
				<input type="text" name="fecha_fin" id="fecha_fin" />
		    </div>
	    <br class="clearFloat"/>
        </div>
	<hr />
	<a href="#" id="exportar-excel" >Generar XML</a>
	<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="js/i18n/jquery.ui.datepicker-es.js"></script>
    <script>
    	$(document).ready(function() {
			$( "#fecha_inicio, #fecha_fin" ).datepicker({
				dateFormat : "dd-mm-yy"
				});
			$('#exportar-excel').live('click', function() {
				var fecha_inicio = $('#fecha_inicio').val();
				var fecha_fin = $('#fecha_fin').val();
				showPopWin('classes/cobranza_libro_compras/ver_xml.php?fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin, 'XML', 1200, 600, null);
				});
			});
    </script>
	<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
	<script type="text/javascript" src="submodal/common.js"></script>
	<script type="text/javascript" src="submodal/subModal.js"></script>

	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
	<script type="text/javascript">
        function sumar(){
			subtotales=document.getElementsByClassName('sumar_facturas');
			var sumatoria= 0;
			for (var i = 0; i < subtotales.length; i++) {
				sumatoria += parseInt(subtotales[i].value);
				}
			document.getElementById('total_pago').value = sumatoria;
			var monto = document.getElementById('monto').value;
			var saldo = monto - sumatoria;
			document.getElementById('saldo_pago').value = saldo;
			}
    </script>
</body>
</html>
