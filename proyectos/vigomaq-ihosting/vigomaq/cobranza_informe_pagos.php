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
    	<H4>Informe de Pagos</H4>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Cliente
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
                <input name="cliente" type="text" id="cliente" value="" size="50" class="floatLeft" />
                <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10"/>
            </div>
            <div class="floatLeft" style="width:10%;padding:5px;">
                Tipo CLiente
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="tipo_cliente" id="tipo_cliente" />
		<input type="button" name="ver_ficha" id="ver_ficha" onclick="ver_ficha()" value="Ver Ficha"/>
            </div>
	    <br class="clearFloat"/>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Rango Fechas
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
                <input name="fecha_inicio" type="text" id="fecha_inicio" value="" class="floatLeft" />
            </div>
            <div class="floatLeft" style="width:5%;padding:5px;">
                al
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
                <input name="fecha_fin" type="text" id="fecha_fin" value="" class="floatLeft" />
            </div>
		</div>
	    <br class="clearFloat"/>
	    <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
				<input type="button" name="buscar" id="buscar" value="Buscar"/>
            </div>
		</div>
	    <br class="clearFloat"/>
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
	<div id="div-resultado" style="overflow:auto; width: 100%; height: 400px">
                
    </div>
	<hr />
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
			$( "#fecha, #fecha_inicio, #fecha_fin" ).datepicker({
				dateFormat : "dd-mm-yy"
				});
			$("#buscar").click(function(){
				var id_cliente = $("#id_cliente").attr('value');
				var fecha_inicio = $("#fecha_inicio").attr('value');
				var fecha_fin= $("#fecha_fin").attr('value');
				$.ajax({
					url: 'classes/cobranza_informe_pagos/buscar_pagos.php?id_cliente='+id_cliente+'&fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin,
					success: function(data){
						$("#div-resultado").html(data);
						}
					});
				});
			$("#cliente").autocomplete({
				source: "classes/cobranza_cuentas_corrientes/buscar_cliente.php",
				select: function(event, ui){
					var id_cliente = ui.item.id;
					var fecha_inicio = $("#fecha_inicio").attr('value');
					var fecha_fin= $("#fecha_fin").attr('value');
					$.ajax({
						url: 'classes/cobranza_informe_pagos/buscar_pagos.php?id_cliente='+id_cliente+'&fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin,
						success: function(data){
							$("#div-resultado").html(data);
							}
						});
					}
				});
			$('#spinner').bind("ajaxSend", function() {
						$(this).show();
					}).bind("ajaxComplete", function() {
						$(this).hide();
					});
			});
	function ver_ficha(){
		var id = document.getElementById('id_cliente').value;
		showPopWin('cliente.php?txt_rut='+id, 'Cliente N° '+id, 1200, 600, null);
		}

	function seleccionar(factura){
		if (document.getElementById(factura).checked == true){
		    factura = document.getElementById(factura).value;
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
	<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
	<script type="text/javascript" src="submodal/common.js"></script>
	<script type="text/javascript" src="submodal/subModal.js"></script>

	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</body>
</html>
