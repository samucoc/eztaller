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
<title>Menu Principal</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
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
.div-resumen{
	width: 100%;
	max-height:450px;
	overflow: auto;
	}
A:link { color:#000;text-decoration:none; }
A:visited { color:#000;text-decoration:none; }
A:hover { color:#000;text-decoration:none; }
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
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
	<div class="div-resumen-encabezado">
    	<?php 
			include('classes/resumen/resumen_encabezado.php');
		?>
    </div>
    <br class="clearFloat"/>
    <div class="div-resumen">
		<?php 
			include('classes/resumen/resumen.php');		
		?>    
    </div>
<script type="text/javascript">
	var menu=new menu.dd("menu");
	menu.init("menu","menuhover");
</script>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script>
	$(document).ready(function(){
		$(".link_resumen").fancybox({
			'width'    		: '100%',
			'height'   		: '100%',
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'    		: 'iframe',
			'title'			: this.title
			});
	});
</script>
</body>
</html>