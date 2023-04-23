	<?php ob_start(); 
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
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-weight: bold}
.Estilo22 {font-weight: bold}
.Estilo24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
-->
#div-busca-gd{
	padding-left:2%;
	width:95%;
	}
#div-gd{
	padding:10px;
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
#div-exporta{
	width:100%;
	}
#resultado-encabezado-1,#resultado-facturacion{
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 20px;
	width:100%;
	}
#resultado-encabezado-2, #resultado-cambio{
	width:50%;
	}
</style>

</head>
<body>
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
    <div align="center" class="Estilo6">
	  <div align="right" class="Estilo20"><strong><font>HOJA DE ARRIENDO</font></strong></div>
	</div>
	<div id="div-busca-gd">
        <div id="div-gd">
            <div class="floatLeft texto">
            	Guia de Despacho :
            </div>
            <div class="floatLeft control">	
                <input id="gd" />
                <a href="#" id="generar-excel" style="padding-left:20px">
            		<img src="images/page_excel.png" width="16" height="16" title="Generar Excel" />
           		</a>
            </div>
            <div class="floatLeft control">
           	
           </div>
            <br class="clearFloat"/>
      </div>
        <br class="clearFloat"/>
        <div id="div-exporta" class="floatLeft">
            <div id="resultado-encabezado-1" class="floatLeft">
                            
            </div>
            <br class="clearFloat"/>
            <div id="resultado-encabezado-2" class="floatLeft">
                            
            </div>
            <div id="resultado-cambio" class="floatLeft">
            
            </div>
            <br class="clearFloat"/>
            <div id="resultado-facturacion">
            
            </div>
        </div>
        <br class="clearFloat"/>
        <br class="clearFloat"/>
</div>

<script type="text/javascript" src="script.js"></script>
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script>
$(document).ready(function() {
	function log( message ) {
		$( "<div/>" ).text( message ).prependTo( "#resultado" );
		$( "#resultado" ).scrollTop( 0 );
		}
	$( "#gd" ).autocomplete({
		source: "classes/hoja_arriendo/buscar_guia_despacho.php",
		minLength: 1,
		focus: function(event,ui){
				
			},
		select: function( event, ui ) {
			var value =  ui.item.value;
			$.ajax({
				url: 'classes/hoja_arriendo/buscar_equipos_arrendados.php?parte=1&num_gd='+value,
				type : 'POST',
				success: function(data){
					$("#resultado-encabezado-1").html(data);
					}
				});
			$.ajax({
				url: 'classes/hoja_arriendo/buscar_equipos_arrendados.php?parte=2&num_gd='+value,
				type : 'POST',
				success: function(data){
					$("#resultado-encabezado-2").html(data);
					}
				});
		}
	});
	$("#equipo").live('change',function(){
		$("#resultado-cambio").html("");
		$("#resultado-facturacion").html("");
		var id = $(this).val();
		var num_gd = $("#gd").attr('value');
		<?php if (!empty($_GET['num_gd'])){?>
		if (!(num_gd)){
			num_gd = <?php echo $_GET['num_gd']?>;
			}
		<?php 	} ?>
		$.ajax({
			url:'classes/hoja_arriendo/mostrar_historial_equipo_arrendado.php?cod_equipo='+id+'&num_gd='+num_gd,
			success : function(data){
				$("#resultado-facturacion").html(data);
				}
			});
		$.ajax({
			url:'classes/hoja_arriendo/mostrar_historial_equipo_arrendado_cambios.php?cod_equipo='+id+'&num_gd='+num_gd,
			success : function(data){
				$("#resultado-cambio").html(data);
				}
			});
		$("#generar-excel").attr('href','classes/hoja_arriendo/imprimir_hoja_arriendo.php?cod_equipo='+id+'&num_gd='+num_gd);
	});
		$("#generar-excel").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe'
			});
	});
$(window).load(function(){
	<?php if (!empty($_GET['num_gd'])){?>
	var value =  <?php echo $_GET['num_gd']?>;
	<?php }?>
	$.ajax({
		url: 'classes/hoja_arriendo/buscar_equipos_arrendados.php?parte=1&num_gd='+value,
		type : 'POST',
		success: function(data){
			$("#resultado-encabezado-1").html(data);
			}
		});
	$.ajax({
		url: 'classes/hoja_arriendo/buscar_equipos_arrendados.php?parte=2&num_gd='+value,
		type : 'POST',
		success: function(data){
			$("#resultado-encabezado-2").html(data);
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