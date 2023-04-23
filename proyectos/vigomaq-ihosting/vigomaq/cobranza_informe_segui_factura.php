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
	if ($_POST['SI']=='Registrar Pago'){
		include("classes/conex.php");
		$link = Conectarse();

		if(isset($_POST['fecha']))$fecha	= $_POST['fecha'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha);
		$fecha 	= $anio1.'-'.$mes1.'-'.$dia1;
		if(isset($_POST['tipo_pago']))$tipo_pago		= $_POST['tipo_pago'];
		if(isset($_POST['monto']))$monto	= $_POST['monto'];

		$arr_factura = explode(',',$_POST['facturas']);
		for ($i=0; $i<count($arr_factura);$i++){
			$num_factura = $arr_factura[$i];
			
			$sql_0 = "SELECT sum(tot_arriendo) as total ,sum(total_rep) as total_1
				FROM factura
					inner join det_factura
						on factura.num_factura = det_factura.num_factura
				where factura.num_factura = '".$num_factura."'
				group by factura.num_factura";			
			$res_0 = mysql_query($sql_0,$link) or die(mysql_error());
			$row_0 = mysql_fetch_array($res_0);
			
			$total = $row_0['total'];
			if ($total==0){
				$total = $row_0['total_1'];
				}
			if ($monto>0){
				$sql = "update factura
					set 	estado = 'ABONANDO'
					where num_factura = '".$num_factura."'";
				$res=mysql_query($sql,$link) or die(mysql_error());
				$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
				$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','ABONANDO','".$_SESSION['usuario']."')";
				$res=mysql_query($sql,$link) or die(mysql_error());

				$sql = "INSERT INTO `factura_pagos`( `tipo_pago`, `monto`, `fecha`, `num_factura`, `usuario`, `fecha_dig`) VALUES ('".$tipo_pago."','".$monto."','".$fecha."','".$num_factura."','".$_SESSION['usuario']."','".date("Y-m-d H:i:s")."')";
				$res=mysql_query($sql,$link) or die(mysql_error());

				$sql3="SELECT sum(monto) as monto
				from factura_pagos
				where num_factura = '".$num_factura."'";
				$res3 = mysql_query($sql3,$link) or die(mysql_error());
				$registro3 = mysql_fetch_array($res3);
				$abono = $registro3['monto'];

				if (!($total-$abono>0)){
					$sql = "update factura
						set 	estado = 'PAGADO'
						where num_factura = '".$num_factura."'";
					$res=mysql_query($sql,$link) or die(mysql_error());
					$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
					$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','ABONANDO','PAGADO','".$_SESSION['usuario']."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					}

				$id = mysql_insert_id();
				$obs = "Accion : PAGO || Nro. : ".$id." || Fecha : ".$fecha;
				$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','PROCESO_PAGO','".$_SESSION['usuario']."')";
				$res=mysql_query($sql,$link) or die(mysql_error());

				$monto = $monto-$total;
				}
			}
		header("Location:cobranza_cuentas_corrientes.php");
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
	background-color:#06327D !important;
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
    	<H4>Consultas Seguimiento Facturas</H4>
        <div class="div-busqueda" style="padding:5px">
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Mes inicio
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		Mes:
		<SELECT id="cboMes_1" name="cboMes_1" onKeyPress="return Tabula(this, event, 0)">
			<option value=''>- - Seleccione - -</option>
			<option value='1'>Enero</option>
			<option value='2'>Febrero</option>
			<option value='3'>Marzo</option>
			<option value='4'>Abril</option>
			<option value='5'>Mayo</option>
			<option value='6'>Junio</option>
			<option value='7'>Julio</option>
			<option value='8'>Agosto</option>
			<option value='9'>Septiembre</option>
			<option value='10'>Octubre</option>
			<option value='11'>Noviembre</option>
			<option value='12'>Diciembre</option>
		</SELECT>
		&nbsp;&nbsp;
		Año:
		<SELECT id="cboAnio_1" name="cboAnio_1" onKeyPress="return Tabula(this, event, 0)">
			<option value=''>- - Seleccione - -</option>
			<option value='2010'>2010</option>
			<option value='2011'>2011</option>
			<option value='2012'>2012</option>
			<option value='2013'>2013</option>
			<option value='2014'>2014</option>
			<option value='2015'>2015</option>
		</SELECT>
            </div>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Mes Termino
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">

		Mes:
		<SELECT id="cboMes_2" name="cboMes_2" onKeyPress="return Tabula(this, event, 0)">
			<option value=''>- - Seleccione - -</option>
			<option value='1'>Enero</option>
			<option value='2'>Febrero</option>
			<option value='3'>Marzo</option>
			<option value='4'>Abril</option>
			<option value='5'>Mayo</option>
			<option value='6'>Junio</option>
			<option value='7'>Julio</option>
			<option value='8'>Agosto</option>
			<option value='9'>Septiembre</option>
			<option value='10'>Octubre</option>
			<option value='11'>Noviembre</option>
			<option value='12'>Diciembre</option>
		</SELECT>
		&nbsp;&nbsp;
		Año:
		<SELECT id="cboAnio_2" name="cboAnio_2" onKeyPress="return Tabula(this, event, 0)">
			<option value=''>- - Seleccione - -</option>
			<option value='2010'>2010</option>
			<option value='2011'>2011</option>
			<option value='2012'>2012</option>
			<option value='2013'>2013</option>
			<option value='2014'>2014</option>
			<option value='2015'>2015</option>
		</SELECT>
	  </div>
	  <a href="#" class="floatLeft buscar"><img src="images/ver.png" title="Buscar"/></a>
	    <br class="clearFloat"/>
        </div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">N° Factura</div>
    	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">Valor Factura</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">CERRADA</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">DISTRIBUCION</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">RECIBIDA</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">EN PAGO</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">ABONADA</div>
	<div  class="floatLeft " style="padding: 5px;width: 8%; color: #000000 !important;">PAGADA</div>
  	<br class="clearFloat"/>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
  <div id="div-resultado" style="overflow:auto; width: 100%; height: 300px">
                
        </div>
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
			$(".buscar").click(function(){
				var mes_1 = $("#cboMes_1  option:selected").attr('value');
				var anio_1 = $("#cboAnio_1 option:selected").attr('value');
				var mes_2 = $("#cboMes_2  option:selected").attr('value');
				var anio_2 = $("#cboAnio_2  option:selected").attr('value');
				$.ajax({
					url: 'classes/cobranza_informe_segui_factura/ver_facturas.php?mes_1='+mes_1+'&anio_1='+anio_1+'&mes_2='+mes_2+'&anio_2='+anio_2,
					success: function(data){
						$("#div-resultado").html(data);
						}
					});
				});
			$('.link_resumen').live('click', function() {
				var id = $(this).attr('id');
				showPopWin('ver_factura.php?num_factura='+id, 'Historial Factura N° '+id, 1200, 600, null);
				});
		$('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
			});
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
