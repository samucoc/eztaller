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
	if ($_POST['SI']=='Registrar Proceso'){
		include("classes/conex.php");
		$link = Conectarse();

		if(isset($_POST['id_cliente']))$id_cliente			= $_POST['id_cliente'];
		if(isset($_POST['facturas']))$facturas			= $_POST['facturas'];
		if(isset($_POST['comentario']))$comentario_proceso_pago = $_POST['comentario'];
		if(isset($_POST['txt_hasta']))$fecha_proceso_pago	= $_POST['txt_hasta'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha_proceso_pago);
		$fecha_proceso_pago 	= $anio1.'-'.$mes1.'-'.$dia1;
		
		$arr_facturas = explode(',',$facturas);
		for ($i=0;$i<count($arr_facturas);$i++){
			echo $sql = "update factura
				set 	comentario_proceso_pago	= '".$comentario_proceso_pago."',
					fecha_proceso_pago	= '".$fecha_proceso_pago."',
					estado			= 'PROCESO_PAGO'
			where num_factura in ('".$arr_facturas[$i]."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
		

			$obs = "Accion : PROCESO_PAGO || Nro. : ".$arr_facturas[$i]." || Fecha : ".$fecha_proceso_pago;
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$arr_facturas[$i]."','".date("Y-m-d H:i:s")."','".$obs."','RECIBIDA','PROCESO_PAGO','".$_SESSION['usuario']."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			}
		header("Location:cobranza_facturas_proceso_pago.php?id_cliente=".$id_cliente);
		}
	}
if (isset($_POST['NO'])){
	if ($_POST['NO']=='Registrar Rechazo'){
		include("classes/conex.php");
		$link = Conectarse();
	
		if(isset($_POST['id_cliente']))$id_cliente			= $_POST['id_cliente'];
		if(isset($_POST['facturas']))$facturas			= $_POST['facturas'];
		if(isset($_POST['comentario']))$comentario_proceso_pago = $_POST['comentario'];
		if(isset($_POST['txt_hasta']))$fecha_proceso_pago	= $_POST['txt_hasta'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha_proceso_pago);
		$fecha_proceso_pago 	= $anio1.'-'.$mes1.'-'.$dia1;
		
		$arr_facturas = explode(',',$facturas);
		for ($i=0;$i<count($arr_facturas);$i++){
			$sql = "update factura
				set 	comentario_proceso_pago	= '".$comentario_proceso_pago."',
					fecha_proceso_pago	= '".$fecha_proceso_pago."',
					estado			= 'RECHAZADA_CLIENTE'
				where num_factura in ('".$arr_facturas[$i]."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			$obs = "Accion : PROCESO_DISTRIBUCION || Nro. : ".$arr_facturas[$i]." || Fecha : ".$fecha_proceso_pago;
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$arr_facturas[$i]."','".date("Y-m-d H:i:s")."','".$obs."','RECIBIDA','RECHAZADA_CLIENTE','".$_SESSION['usuario']."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			}
		header("Location:cobranza_facturas_proceso_pago.php?id_cliente=".$id_cliente);
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
    	<H4>Gestión de Facturas en Proceso de Pago</H4>
        <div class="div-busqueda">
            <div  class="floatLeft texto_fecha">
                Cliente
            </div>
            <div class="floatLeft" style="width:50%;padding:10px;">
                <input name="cliente" type="text" id="cliente" value="" size="50"/>
				<input type="button" name="ver_ficha" id="ver_ficha" onclick="ver_ficha()" value="Ver Ficha"/>
        
            </div>
	    <div class="floatLeft control_fecha">	
		<a href="#" class="buscar floatLeft"><img src="images/ver.png" title="Buscar"/></a>
            </div>

            <br class="clearFloat"/>
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
	<div id="div-resultado" style="overflow:auto; width: 100%; height: 300px">
        
        
        </div>
	<hr />
	<div class="div-busqueda" id="div-dialog" style="background-color:#06327D;"> 	
		<form method="post" name="frmDatos" id="frmDatos">
		<div style="float:left; width:15%">
			Fecha Entrega
            <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10" />
		</div>       
		<div style="float:left; width:55%">
			<input name="txt_hasta" id="txt_hasta" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div style="float:left; width:15%">
			Comentario
		</div>       
		<div style="float:left; width:55%">
			<textarea name="comentario" id="comentario" rows="5" cols="75"></textarea>
		</div>       
		<br style="clear:both"/>	
		<input class="imprimir" type="submit" value="Registrar Rechazo" id="NO" name="NO"/>
		<input class="imprimir" type="submit" value="Registrar Proceso" id="SI" name="SI"/>
		<input type="hidden" id="facturas" name="facturas"/>
		</form>
	</div>
	<a href="#" id="asignar-vendedor" name="asignar-vendedor">Ingresar Proceso</a>
	<a href="#" id="exportar-excel" >Exportar Excel</a>
   </div>
	<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="js/i18n/jquery.ui.datepicker-es.js"></script>
    <script>
		$(window).load(function(){
			var id_cliente = "<?php echo $_GET['id_cliente']?>";
			if (id_cliente != ''){
				$.ajax({
					url: 'classes/cobranza_facturas_proceso_pago/buscar_facturas.php?id_cliente='+id_cliente,
					success: function(data){
						$("#div-resultado").html(data);
						}
					});
				}
			});
    	$(document).ready(function() {
		$( "#txt_hasta" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			$.ajax({
				url: 'classes/cobranza_facturas_proceso_pago/buscar_facturas.php?id_cliente='+id_cliente,
				success: function(data){
					$("#div-resultado").html(data);
					}
				});
			});
		
		$("#cliente").autocomplete({
			source: "classes/cobranza_cuentas_corrientes/buscar_cliente.php",
			select: function(event, ui){
				var rut = ui.item.id;
				document.getElementById('id_cliente').value = rut;
				}
			});
		$( "#div-dialog" ).dialog({
				autoOpen: false,
				height: 320,
				width: 800,
				modal: true
			});
		$( "#asignar-vendedor" ).button().click(function() {
				$( "#div-dialog" ).dialog( "open" );
				
			});
		$( "#exportar-excel" ).button().click(function() {
			var test = $('#div-resultado');
			window.open('data:application/vnd.ms-excel,' + 
				    encodeURIComponent(test[0].outerHTML));
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
	function ver_ficha(){
		var id = document.getElementById('id_cliente').value;
		showPopWin('cliente.php?txt_rut='+id, 'Cliente N° '+id, 1200, 600, null);
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
