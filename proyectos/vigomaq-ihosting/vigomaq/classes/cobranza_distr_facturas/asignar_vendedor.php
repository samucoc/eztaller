<?php
session_start(); 
include("../conex.php");
		$link=Conectarse();
		if (($_GET['quien_entrega']!='')&&($_GET['vendedor']!='')&&($_GET['txt_hasta']!='')&&($_GET['hora_entrega']!='')&&($_GET['facturas']!='')){
			if(isset($_GET['quien_entrega'])) $quien_entrega 	= $_GET['quien_entrega'];
			if(isset($_GET['vendedor']))$vendedor 	= $_GET['vendedor'];
			if(isset($_GET['txt_hasta']))$fecha_entrega 	= $_GET['txt_hasta'];
			list($dia1,$mes1,$anio1) = explode('-', $fecha_entrega);
			$fecha_entrega 	= $anio1.'-'.$mes1.'-'.$dia1;
			if(isset($_GET['hora_entrega']))$hora_entrega 	= $_GET['hora_entrega'];
			if(isset($_GET['facturas'])) $facturas	= $_GET['facturas'];
			$sql = "update factura
				set cod_vendedor_entrega	= '".$vendedor."',
					fecha_entrega		= '".$fecha_entrega."',
					hora_entrega		= '".$hora_entrega."',
					quien_entrega		= '".$quien_entrega."',
					estado			= 'PROCESO_DISTRIBUCION'
				where num_factura in (".$facturas.")";
			$res=mysql_query($sql,$link) or die(mysql_error());
	
			$id = mysql_insert_id();
			$arr_facturas = explode(',',$facturas);
			for ($i=0;$i<count($arr_facturas);$i++){
				$obs = "Accion : PROCESO_DISTRIBUCION || Nro. : ".$arr_facturas[$i]." || Fecha : ".$fecha_entrega;
				$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$arr_facturas[$i]."','".date("Y-m-d H:i:s")."','".$obs."','CERRADA','PROCESO_DISTRIBUCION','".$_SESSION['usuario']."')";
				$res=mysql_query($sql,$link) or die(mysql_error());
				}
			$sql_0 = "INSERT INTO `factura_entregas`( `cod_vendedor_entrega`, `fecha_entrega`, `hora_entrega`, `quien_entrega`, `facturas`) VALUES ('".$vendedor."','".$fecha_entrega."','".$hora_entrega."','".$quien_entrega."','".$facturas."')";
			$res_0 = mysql_query($sql_0,$link) or die(mysql_error());
			echo mysql_insert_id();
			}
?>





