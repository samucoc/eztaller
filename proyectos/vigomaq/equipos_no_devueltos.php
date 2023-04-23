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
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
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
#div-busqueda{
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
#div-busqueda a{
	padding:10px;
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
        <div id="div-busqueda">
            <div  class="floatLeft texto_fecha">
                Desde
            </div>
            <div class="floatLeft control_fecha">
                <input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="10" maxlength="10"/>
        </div>
            <div class="floatLeft texto_fecha">
                Hasta
            </div>
            <div class="floatLeft control_fecha">
                <input name="fecha_fin" type="text" id="fecha_fin" size="10" maxlength="10" />
        </div>
            <a href="#" class="buscar floatLeft"><img src="images/ver.png" title="Buscar"/></a>
            <br class="clearFloat"/>
        </div>
        <div id="div-resultado">
        
        </div>
    </div>
    <script src="js/jquery-1.6.2.min.js"></script>
    <script src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script>
    $(document).ready(function() {
		var dates = $( "#fecha_inicio, #fecha_fin" ).datepicker({
			firstDay: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fecha_inicio" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
		$( "#fecha_inicio, #fecha_fin" ).datepicker( "option",
				$.datepicker.regional[ "es" ] );
		$( "#fecha_inicio, #fecha_fin" ).datepicker( "setDate" , <?php echo date("m/d/Y");?> );
		$( "#fecha_inicio, #fecha_fin" ).datepicker( "option",
				"dateFormat" , "dd-mm-yy"  );
		$(".buscar").click(function(){
			var inicio = $("#fecha_inicio").attr('value');
			var fin = $("#fecha_fin").attr('value');
			$.ajax({
				url: 'classes/equipos_no_devueltos/buscar_equipos_fecha.php?inicio='+inicio+'&fin='+fin,
				success: function(data){
					$("#div-resultado").html(data);
					}
				});
			});
		});
    </script>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</body>
</html>