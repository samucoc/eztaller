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
<link rel="stylesheet" href="style.css" type="text/css" />
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

#warp{
	padding-left:5%;
	width:90%;
	}
#div-busqueda{
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
#div-busqueda a{
	padding:10px;
	}	
.diez_2{
	width:12%;
	text-align:center;
	padding:10px;
	}
</style>
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
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
    <form action="classes/exportar_reportes/generar-excel/generador.php" method="post" >
    <div id="warp">
    	<H4>LISTADO DE EQUIPOS CLIENTES / OBRAS</H4>
        <div id="div-busqueda">
            <div  class="floatLeft texto_fecha">
                    Rut cliente
            </div>
          	<div class="floatLeft control_fecha">
            	<input name="rut" type="text" id="rut" value="" onblur="if (this.value != '') checkRutGenerico(this, true);" />
            </div>
      		<a href="#" class="floatLeft texto_fecha buscar" style="margin-left:50px">
            	<img src="images/ver.png" title="Buscar"/>
            </a>
            <input type="submit" id="generar-excel" name="generar-excel" title="Generar Excel" style="background-image: url('images/page_excel.png'); width:16px; height:16px; padding-top:5px; margin-top:10px;" />
            <br class="clearFloat"/>
	    </div>
        <div id="cargador">
        
        </div>
        <div id="div-resultado">
        
        </div>
    </div>
    <input type="hidden" name="resultado" id="resultado"/>
    </form>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script>
    $(document).ready(function() {
		$(".buscar").click(function(){
			var inicio = $("#rut").attr('value');
			$.ajax({
				url: 'classes/consulta_cli_ob_eq/buscar_equipos_rut.php?rut='+rut,
				beforeSend: function() {
				//	$("#cargador").show();
				  },
				success: function(data){
				//	$("#cargador").hide();
					$("#div-resultado").html(data);
					}
				});
			});
			 $('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
			$("#generar-excel").click(function(){
				$("#resultado").val( $("<div>").append( $("#div-resultado").eq(0).clone() ).html() );
			});
		});
	$(window).load(function(){
		$.ajax({
			url: 'classes/consulta_cli_ob_eq/buscar_equipos.php',
			beforeSend: function() {
			//	$("#cargador").show();
			  },
			success: function(data){
			//	$("#cargador").hide();
				$("#div-resultado").html(data);
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