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
	if ($_POST['SI']=='Ingresar Garantia'){
		include("classes/conex.php");
		$link = Conectarse();

		if(isset($_POST['id2_cliente']))$rut_cliente	= $_POST['id2_cliente'];
		if(isset($_POST['tipo_documento']))$tipo_documento	= $_POST['tipo_documento'];
		if(isset($_POST['rut_girador']))$rut_girador	= $_POST['rut_girador'];
		if(isset($_POST['nombre_girador']))$nombre_girador	= $_POST['nombre_girador'];
		if(isset($_POST['banco_emisor']))$banco_emisor	= $_POST['banco_emisor'];
		if(isset($_POST['banco_emisor']))$nro_documento	= $_POST['nro_documento'];
		if(isset($_POST['txt_emision']))$fecha_emision	= $_POST['txt_emision'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha_emision);
		$fecha_emision 	= $anio1.'-'.$mes1.'-'.$dia1;
		if(isset($_POST['txt_vencimiento']))$fecha_venc	= $_POST['txt_vencimiento'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha_venc);
		$fecha_venc 	= $anio1.'-'.$mes1.'-'.$dia1;
		if(isset($_POST['valor']))$valor	= $_POST['valor'];
		if(isset($_POST['direccion_img']))$direccion_img	= $_POST['direccion_img'];
		$estado	= 'INGRESADO';
	
		echo $sql = "INSERT INTO `factura_garantias`(`rut_cliente`, `tipo_documento`, `rut_girador`, `nombre_girador`, `banco_emisor`, `nro_documento`, `fecha_emision`, `fecha_venc`, `valor`, `direccion_img`, `estado`) VALUES ('".$rut_cliente."','".$tipo_documento."','".$rut_girador."','".$nombre_girador."','".$banco_emisor."','".$nro_documento."','".$fecha_emision."','".$fecha_venc."','".$valor."','".$direccion_img."','".$estado."')";
		$res=mysql_query($sql,$link) or die(mysql_error());
			
		header("Location:cobranza_documentos_garantia.php");
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
    	<H4>Gestión de Documentos en Garantia</H4>
        <div class="div-busqueda">
           <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Cliente
            </div>
            <div class="floatLeft" style="width:50%;padding:5px;">
                <input name="cliente" type="text" id="cliente" value="" size="50" class="floatLeft" />
                <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10"/>
            	<a href="#" class="floatLeft buscar"><img src="images/ver.png" title="Buscar"/></a>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:5px;">
            	Fecha Vencimiento
            </div>
            <div class="floatLeft" style="width:50%;padding:5px;">
		<input name="txt_desde" id="txt_desde" type="text" class="floatLeft" style="width:100px;"/> 
		<div class="floatLeft texto_fecha">al</div>
		<input name="txt_hasta" id="txt_hasta" type="text" class="floatLeft" style="width:100px;"/> 
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
		<input type="hidden" id="facturas" name="facturas" readonly/>
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Razon Social
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" name="raz_soc" id="raz_soc" size='50'/>	
		        <input name="id2_cliente" type="hidden" id="id2_cliente" value="" size="10" maxlength="10"/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Documento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_documento" id="tipo_documento">
				<?php 
				include("classes/conex.php");
				$link=Conectarse();
				$sql_familias="select *
						from tipo_documentos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['td_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Bancos
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="banco_emisor" id="banco_emisor">
				<?php 
				//include("classes/conex.php");
				//$link=Conectarse();
				$sql_familias="select *
						from bancos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['banco_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Rut Girador - Nombre Girador
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" name="rut_girador" id="rut_girador"/>
			-
			<input type="text" name="nombre_girador" id="nombre_girador"/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			N° Documento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" name="nro_documento" id="nro_documento"/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha Emision
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_emision" id="txt_emision" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha Vencimiento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_vencimiento" id="txt_vencimiento" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Valor
		</div>       
		<div  class="floatLeft" style="width:50%;padding:10px;">
			<input type="text" id="valor" name="valor"/>
		</div>       
		<br style="clear:both"/>	
		<br style="clear:both"/>	
		<input class="imprimir" type="submit" value="Ingresar Garantia" id="SI" name="SI"/>
		<input class="imprimir" type="button" value="Imprimir Comprobante Ingreso"/>
		<input class="imprimir" type="button" value="Imprimir Comprobante Egreso"/>
	</form>
	</div>
	<a href="#" id="asignar-vendedor" name="asignar-vendedor">Ingresar Garantia</a>
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
		$( "#txt_desde,#txt_hasta,#txt_emision,#txt_vencimiento" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			var txt_desde = $("#txt_desde").attr('value');
			var txt_hasta = $("#txt_hasta").attr('value');
			$.ajax({
				url: 'classes/cobranza_documentos_garantia/buscar_facturas.php?id_cliente='+id_cliente+'&txt_desde='+txt_desde+'&txt_hasta='+txt_hasta,
				success: function(data){
					$("#div-resultado").html(data);
					}
				});
			});
		$("#cliente, #raz_soc").autocomplete({
			source: "classes/cobranza_documentos_garantia/buscar_cliente.php",
			select: function(event, ui){
				var rut = ui.item.id;
				document.getElementById('id_cliente').value = rut;
				document.getElementById('id2_cliente').value = rut;
				}
			});
		$( "#div-dialog" ).dialog({
				autoOpen: false,
				height: 600,
				width: 800,
				modal: true
			});
		$( "#asignar-vendedor" ).button().click(function() {
				$( "#div-dialog" ).dialog( "open" );
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
