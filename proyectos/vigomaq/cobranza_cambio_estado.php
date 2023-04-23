<?php ob_start(); 
session_start(); 
//conectamos a la base de datos 
//mysql_connect("localhost","root","sebterROOT9384"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
//mysql_select_db("vigomaq"); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
if (isset($_POST['OK'])){
	if ($_POST['OK']=='Guardar'){
		include("classes/conex.php");
		$link = Conectarse();
	
		if(isset($_POST['estado_actual']))$estado_actual	= $_POST['estado_actual'];
		if(isset($_POST['estado_modificar']))$estado_modificar	= $_POST['estado_modificar'];
		if(isset($_POST['nro_factura']))$facturas	= $_POST['nro_factura'];
		$sql = "update factura
				set estado		= '".$estado_modificar."'
			where num_factura = ".$facturas."";
		$res=mysql_query($sql,$link) or die(mysql_error());

		$id = mysql_insert_id();
		
		$arr_facturas = explode(',',$facturas);
		for ($i=0;$i<count($arr_facturas);$i++){
			$obs = "Accion : Cambio Estado || Nro. : ".$arr_facturas[$i]." || Fecha : ".date("Y-m-d");
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$arr_facturas[$i]."','".date("Y-m-d H:i:s")."','".$obs."','".$estado_actual."','".$estado_modificar."','".$_SESSION['usuario']."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			}

		//header("Location:cobranza_copia_factura.php");
		}
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
    	<form method="post" name="frmDatos" id="frmDatos">
	<H4>Cambio Estado Factura</H4>
        <div class="div-busqueda">
	    <div  class="floatLeft" style="width:10%;padding:10px;">
		Nro Factura
            </div>
            <div  class="floatLeft" style="width:13%;padding:10px;">
		<input class="floatLeft" name="nro_factura" type="text" id="nro_factura" value="" size="10"/>
            </div>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		<input class="floatLeft" type="button" id="btn_nroFatura" name="btn_nroFactura" value="" style="background: url('images/ver.png'); width:16px; height:16px; border: none;"/>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Estado Actual
            </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input name="estado_actual" type="text" id="estado_actual" size="30" readonly/>
	    </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Estado a Modificar
	    </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<select id="estado_modificar" name="estado_modificar">
			<option value="CERRADA">CERRADA</option>
			<option value="PROCESO_DISTRIBUCION">PROCESO_DISTRIBUCION</option>
			<option value="RECIBIDA">RECIBIDA</option>
			<option value="PROCESO_PAGO">PROCESO_PAGO</option>
			<option value="ABONANDO">ABONANDO</option>
			<option value="PAGADO">PAGADO</option>
		</select>
	    </div>       
	    <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		<input class="imprimir" type="submit" value="Guardar" id="OK" name="OK"/>
	    </div>
            <br class="clearFloat"/>
        </div>
	</form>
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
		$("#btn_nroFatura").click(function(){
			var nro_factura = $("#nro_factura").attr('value');
			$.ajax({
				url: 'classes/cobranza_cambio_estado/buscar_raz_social.php?nro_fact='+nro_factura,
				success: function(data){
					if (data!='Factura no Existe'){
						document.getElementById('estado_actual').value=data;
						}
					else{
						alert(data);
						}
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
