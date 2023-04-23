<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Sistema de Arriendo y Facturación - Vigomaq</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>

<body>
	<div id="warp">
    	<div class="floatLeft">
        	<img src="images/logo.jpg" width="377" height="104" />
        </div>
        <div class="Estilo2 Estilo25 floatRight">
        	<br />
	       	<br />
    	   	<br />
       		<span class="Estilo23">
            	Sistema de Arriendo y Facturaci&oacute;n - Vigomaq
            </span>
        </div>
        <br class="clearFloat"/>
        <div id="div-menu">
        	<?php 
				include("classes/menu.php");
			?>
		</div>	
        <br class="clearFloat"/>
        <div id="paso-1">
        	<?php 
				include("classes/asignar_arriendo/paso_1.php");
			?>
        </div>
        <br class="clearFloat"/>
        <div id="paso-2">
        	<?php 
				include("classes/asignar_arriendo/paso_2.php");
			?>
        </div>
        <br class="clearFloat"/>
        <div id="paso-3">
        	<?php 
				include("classes/asignar_arriendo/paso_3.php");
			?>
        </div>
        <br class="clearFloat"/>
    </div>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
		var menu=new menu.dd("menu");
		menu.init("menu","menuhover");
	</script>
	
</body>
</html>