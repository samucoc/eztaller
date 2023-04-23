<?php 
include("../conex.php");
if (isset($_POST['SI'])){
	if ($_POST['SI']=='Registrar Evento'){
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
<link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox-1.3.4.css"/>
<link rel="stylesheet" type="text/css" href="../../css/smoothness/jquery-ui-1.8.16.custom.css"/>
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
	<script type="text/javascript" src="../../jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("../../jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="../../js/jquery-1.6.2.min.js"></script>
	<script src="../../js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="../../js/i18n/jquery.ui.datepicker-es.js"></script>
	<script src="../../js/fancybox/jquery.fancybox-1.3.4.js"></script>

    <script>
    	$(document).ready(function() {
		$( "#txt_desde,#txt_hasta,#txt_evento,#txt_compromiso" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			var txt_desde = $("#txt_desde").attr('value');
			var txt_hasta = $("#txt_hasta").attr('value');
			var estado = $("#comp_gest").attr('checked');
			$.ajax({
				url: 'classes/cobranza_gestion_cobranza/buscar_facturas.php?id_cliente='+id_cliente+'&txt_desde='+txt_desde+'&txt_hasta='+txt_hasta+'&estado='+estado,
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
				height: 600,
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
		$('.link_resumen').live('click', function() {
			var id = $(this).attr('id');
			showPopWin('classes/cobranza_gestion_cobranza/ver_logs.php?num_factura='+id, 'Historial Factura N° '+id, 1200, 600, null);
			});
		$('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
		
		});
	function seleccionar(factura){
		if (document.getElementById(factura).checked == true){
		    factura = document.getElementById(factura).value;
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
	<link rel="stylesheet" type="text/css" href="../../submodal/subModal.css" /> 
	<script type="text/javascript" src="../../submodal/common.js"></script>
	<script type="text/javascript" src="../../submodal/subModal.js"></script>

	<script type="text/javascript" src="../../script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</head>
<body>
<?php
if (isset($_POST['SI'])){
	if ($_POST['SI']=='Registrar Evento'){
		echo "<script>hidePopWin(false);</script>";
	}
}
?>
    <div id="warp">
	<div class="div-busqueda" style="background-color:#06327D;"> 	
		<form method="post" name="frmDatos" id="frmDatos">
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Facturas
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" id="facturas" name="facturas" readonly value="<?php echo $_GET['facturas']?>"/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha - Hora Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_evento" id="txt_evento" type="text" size="10" maxlength="10" /> 
			<input name="hora_evento" id="hora_evento" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_evento" id="tipo_evento">
				<?php 
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
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Detalle Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<textarea id="detalle_evento" name="detalle_evento" cols="75" rows="5"></textarea>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Diagnostico
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
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
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_compromiso" id="txt_compromiso" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
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
		<input class="imprimir" type="submit" value="Registrar Evento" id="SI" name="SI" />
	</form>
	</div>
    </div>
</body>
</html>
