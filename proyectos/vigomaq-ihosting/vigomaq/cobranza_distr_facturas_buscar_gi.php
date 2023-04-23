<?php 
ob_start(); 
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
<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
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
    	<H4>Consulta Guias Internas - Distribucion de Facturas</H4>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
		    Nro Guia
            </div>
            <div  class="floatLeft" style="width:80%;padding:5px;">
		<input name="nro_guia"  class="floatLeft" type="text" id="nro_guia" />
	    	<a href="#" class="buscar floatLeft"><img src="images/ver.png" title="Buscar"/></a>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:5px;">
		    Rango de Fechas
            </div>
            <div class="floatLeft" style="width:50%;padding:5px;">
		<input name="txt_desde" id="txt_desde" type="text" class="floatLeft" style="width:100px;"/> 
		<div class="floatLeft texto_fecha">al</div>
		<input name="txt_hasta" id="txt_hasta" type="text" class="floatLeft" style="width:100px;"/> 
            </div>
            <br class="clearFloat"/>

        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
	<div id="div-resultado" style="overflow:auto; width: 100%; height: 300px">
        
        </div>
	
   </div>
	<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="js/i18n/jquery.ui.datepicker-es.js"></script>

    <script>
    	$(document).ready(function() {
		$( "#txt_desde,#txt_hasta" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#nro_guia").attr('value');
			var txt_desde = $("#txt_desde").attr('value');
			var txt_hasta = $("#txt_hasta").attr('value');
			$.ajax({
				url: 'classes/cobranza_distr_facturas_buscar_gi/buscar_facturas.php?id='+id_cliente+'&txt_desde='+txt_desde+'&txt_hasta='+txt_hasta,
				success: function(data){
					$("#div-resultado").html(data);
					}
				});
			});
		$('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
		});
	function seleccionar(factura){
		if (document.getElementById(factura).checked == true){
		    if (document.getElementById("facturas").value!='') 
			document.getElementById("facturas").value = document.getElementById("facturas").value +','+factura;
		    else
			document.getElementById("facturas").value = factura;
		}
		else{
			var arr  = document.getElementById("facturas").value.split(",");
			var posBorrar = 0;
			for (var i = 0; i<arr.length; i++){
				if (arr[i]==factura){
					posBorrar  = i;
					i = arr.length;
					}
				}			
			arr.splice(posBorrar, 1);
			document.getElementById("facturas").value = arr.join(",");
		}
	}

    </script>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">

        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</body>
</html>
