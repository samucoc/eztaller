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
if (isset($_POST['SI'])){
	if ($_POST['SI']=='Registrar Evento'){
		include("classes/conex.php");
		$link = Conectarse();

		$arr_factura = explode(',',$_POST['facturas']);
		for ($i=0; $i<count($arr_factura);$i++){
			$num_factura = $arr_factura[$i];
			
			if(isset($_POST['txt_evento']))$fecha_evento	= $_POST['txt_evento'];
			list($dia1,$mes1,$anio1) = explode('-', $fecha_evento);
			$fecha_evento 	= $anio1.'-'.$mes1.'-'.$dia1;
			if(isset($_POST['hora_evento']))$hora_evento	= $_POST['hora_evento'];
			$fecha_evento = $fecha_evento.' '.$hora_evento;
			if(isset($_POST['tipo_evento']))$tipo_evento		= $_POST['tipo_evento'];
			if(isset($_POST['detalle_evento']))$detalle_evento	= $_POST['detalle_evento'];
			if(isset($_POST['tipo_diagnostico']))$tipo_diagnostico	= $_POST['tipo_diagnostico'];
			if(isset($_POST['txt_compromiso']))$fecha_compromiso	= $_POST['txt_compromiso'];
			list($dia1,$mes1,$anio1) = explode('-', $fecha_compromiso);
			$fecha_compromiso 	= $anio1.'-'.$mes1.'-'.$dia1;
			if(isset($_POST['tipo_compromiso']))$tipo_compromiso	= $_POST['tipo_compromiso'];

			$sql = "INSERT INTO `factura_eventos` (num_factura, `fecha_evento`, `tipo_evento`, `detalle`, `tipo_diagnostico`, `fecha_diag`, `tipo_compromiso`) VALUES ('".$num_factura."','".$fecha_evento."','".$tipo_evento."','".$detalle_evento."','".$tipo_diagnostico."','".$fecha_compromiso ."','".$tipo_compromiso."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			$id = mysql_insert_id();
			$obs = "Accion : Evento || Nro. : ".$id." || Fecha : ".$fecha_evento;
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','PROCESO_PAGO','".$_SESSION['usuario']."')";
			$res=mysql_query($sql,$link) or die(mysql_error());

			}
		header("Location:cobranza_gestion_cobranza.php");
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
	padding:10px;
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
    	<H4>Gestión de Cobranza</H4>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:10px;">
                Compromisos sin Gestion
            </div>
            <div class="floatLeft" style="width:50%;padding:10px;">
		<input type="checkbox" name="comp_gest" id="comp_gest"/>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
            	Fecha Vencimiento
            </div>
            <div class="floatLeft" style="width:50%;padding:10px;">
		<input name="txt_desde" id="txt_desde" type="text" class="floatLeft" style="width:100px;"/> 
	        <button type="submit" id="cal-button-1"  class="floatLeft" >...</button>
		<div class="floatLeft texto_fecha">al</div>
		<input name="txt_hasta" id="txt_hasta" type="text" class="floatLeft" style="width:100px;"/> 
	        <button type="submit" id="cal-button-2"  class="floatLeft">...</button>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
                Cliente
            </div>
            <div class="floatLeft" style="width:50%;padding:10px;">
                <input name="cliente" type="text" id="cliente" value="" size="50" class="floatLeft" />
                <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10"/>
            	<a href="#" class="floatLeft buscar"><img src="images/ver.png" title="Buscar"/></a>
            </div>
            <br class="clearFloat"/>
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
        <div id="div-resultado">
        
        </div>
	<hr />
	<form method="post" name="frmDatos" id="frmDatos">
	<div class="div-busqueda"> 
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Facturas
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<input type="type" id="facturas" name="facturas" readonly/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Fecha - Hora Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<input name="txt_evento" id="txt_evento" type="text" size="10" maxlength="10" /> 
		        <button type="submit" id="cal-button-3">...</button>
			<input name="hora_evento" id="hora_evento" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Tipo Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<select name="tipo_evento" id="tipo_evento">
				<?php 
				include("classes/conex.php");
				$link=Conectarse();
				$sql_familias="select *
						from tipo_eventos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['te_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Detalle Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<textarea id="detalle_evento" name="detalle_evento" cols="75" rows="5"></textarea>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Tipo Diagnostico
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<select name="tipo_diagnostico" id="tipo_diagnostico">
				<?php 
				$sql_familias="select *
						from tipo_diagnosticos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['td_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Fecha Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<input name="txt_compromiso" id="txt_compromiso" type="text" size="10" maxlength="10" /> 
		        <button type="submit" id="cal-button-4">...</button>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:10px;">
			Tipo Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<select name="tipo_compromiso" id="tipo_compromiso">
				<?php 
				$sql_familias="select *
						from tipo_compromisos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['tc_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<input class="imprimir" type="submit" value="Registrar Evento" id="SI" name="SI"/>
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
	<script type="text/javascript">
		Calendar.setup({
			inputField    : "txt_desde",
			button        : "cal-button-1",
			align         : "Tr"
		});
	</script>
	<script type="text/javascript">
		Calendar.setup({
			inputField    : "txt_hasta",
			button        : "cal-button-2",
			align         : "Tr"
		});
	</script>
	<script type="text/javascript">
		Calendar.setup({
			inputField    : "txt_evento",
			button        : "cal-button-3",
			align         : "Tr"
		});
	</script>
	<script type="text/javascript">
		Calendar.setup({
			inputField    : "txt_compromiso",
			button        : "cal-button-4",
			align         : "Tr"
		});
	</script>

    <script>
    	$(document).ready(function() {
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			$.ajax({
				url: 'classes/cobranza_gestion_cobranza/buscar_facturas.php?id_cliente='+id_cliente,
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
