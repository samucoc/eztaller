<?php ob_start(); 
session_start(); 
include("classes/conex.php");
$link = Conectarse();
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
	
		if(isset($_POST['txt_hasta']))$fecha_recepcion 	= $_POST['txt_hasta'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha_recepcion);
		$fecha_recepcion 	= $anio1.'-'.$mes1.'-'.$dia1;
		if(isset($_POST['recibido_por']))$recibido_por 	= $_POST['recibido_por'];
		if(isset($_POST['rut_receptor']))$rut_receptor 	= $_POST['rut_receptor'];
		$rut_receptor = str_replace('.','',$rut_receptor);
		if(isset($_POST['lugar_entrega']))$lugar_entrega= $_POST['lugar_entrega'];
		if(isset($_POST['nro_factura']))$facturas	= $_POST['nro_factura'];
		$sql = "update factura
				set recibido_por	= '".$recibido_por."',
				    fecha_recepcion	= '".$fecha_recepcion."',
				    rut_receptor	= '".$rut_receptor."',
				    estado		= 'RECIBIDA',
				    lugar_recepcion	= '".$lugar_entrega."'
			where num_factura = ".$facturas."";
		$res=mysql_query($sql,$link) or die(mysql_error());

		$id = mysql_insert_id();
		
		$arr_facturas = explode(',',$facturas);
		for ($i=0;$i<count($arr_facturas);$i++){
			$obs = "Accion : COPIA_FACTURA || Nro. : ".$arr_facturas[$i]." || Fecha : ".$fecha_recepcion;
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$arr_facturas[$i]."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_DISTRIBUCION','RECIBIDA','".$_SESSION['usuario']."')";
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
	<H4>Entrega 4° Copia Factura</H4>
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
		Razon Social
            </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input name="raz_soc" type="text" id="raz_soc" size="75" readonly/>
	    </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Fecha Recepcion
	    </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input name="txt_hasta" id="txt_hasta" type="text" size="10" maxlength="10" value="<?php if(isset($_POST['txt_hasta'])) echo $_POST['txt_hasta']?>"/> 
	    </div>       
	    <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Recibido por
            </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input name="recibido_por" type="text" id="recibido_por" value="<?php if(isset($_POST['recibido_por'])) echo $_POST['recibido_por'] ?>"/>
	    </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Rut Receptor
            </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input name="rut_receptor" type="text" id="rut_receptor" value="<?php if(isset($_POST['rut_receptor'])) echo $_POST['rut_receptor']?>" onblur="checkRutGenerico(this, true)"/>
	    </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		Lugar Entrega
            </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<select id="lugar_entrega" name="lugar_entrega">
		<?php 
		$sql = "select * from lugar_entrega";
		$res = mysql_query($sql,$link) or die(mysql_error());
		while ($row=mysql_fetch_array($res)){
		?>
			<option  value="<?php echo $row['le_ncorr']?>">
			<?php echo $row['nombre']?>
			</option>
		<?php 
			}
		?>
		</select>	
	    </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:10px;">
		<input class="imprimir" type="submit" value="Guardar" id="OK" name="OK"/>
	    </div>
            <div  class="floatLeft" style="width:50%;padding:10px;">
		<input class="imprimir" type="button" value="Limpiar" id="RESET" name="RESET" onclick="vaciar_campos()"/>
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
		$( "#txt_hasta" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$("#cliente").autocomplete({
			source: "classes/cobranza_cuentas_corrientes/buscar_cliente.php",
			select: function(event, ui){
				var rut = ui.item.id;
				document.getElementById('id_cliente').value = rut;
				}
			});
		$("#btn_nroFatura").click(function(){
			var nro_factura = $("#nro_factura").attr('value');
			$.ajax({
				url: 'classes/cobranza_copia_facturas/buscar_raz_social.php?nro_fact='+nro_factura,
				success: function(data){
					if (data!='Factura no Existe'){
						document.getElementById('raz_soc').value=data;
						}
					else{
						alert(data);
						}
					}
				});
			});
		});
	function vaciar_campos(){
		document.getElementById('txt_hasta').value = "";
		document.getElementById('recibido_por').value = "";
		document.getElementById('rut_receptor').value = "";
		}
    </script>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</body>
</html>
