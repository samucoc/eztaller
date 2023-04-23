<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_estado_individual.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador		= 	$data["OBLI-txtCodCobrador"];
	$nombre_trabajador	= 	$data["OBLIcboPersona"];
	$patente		= 	$data["cboPatente"];
	
	$miSmarty->assign('trabajador', $nombre_trabajador);
	$miSmarty->assign('patente', $patente);


	$mes_1			= 	$data["cboMes_1"];
	$anio_1			= 	$data["cboAnio_1"];
	$mes_2			= 	$data["cboMes_2"];
	$anio_2			= 	$data["cboAnio_2"];
	$arrRegistros_mes	= 	array();
	$arrRegistros_si	= 	array();
	$arrRegistros_asig	=	array();
	$arrRegistros_cn	=	array();
	$arrRegistros_cn_boleta = 	array();
	$arrRegistros_devo_carga=	array();
	$arrRegistros_devo_asig	=	array();
	$arrRegistros_rev_asig	=	array();
	$arrRegistros_disponible=	array();
	$arrRegistros_extra	=	array();
	$arrRegistros_extra_boleta = 	array();
	$arrRegistros_total_extra = 	array();
	$arrRegistros_anticipos = 	array();
	$arrRegistros_ctt = array();
	$arrRegistros_tct = array();

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	if ($trabajador!=''){
		$and = " carga_pers = '".$trabajador."' and ";
		}
	if ($patente!=''){
		$and .= " carga_veh = '".$patente."' and ";
		}
	

    if ($anio_2==$anio_1){
		if (($mes_1<$mes_2)||($mes_1==$mes_1)){
			$inicio_mes 		= mktime(0, 0, 0, $mes_1, 1,   $anio_1);
			$fin_mes 		= mktime(0, 0, 0, $mes_2, 1,   $anio_2);
			if ($mes_2==$mes_1){
				$fin_mes 	=  mktime(0, 0, 0,$mes_1, date("t",mktime(0, 0, 0, $mes_1, 1,   $anio_1)),   $anio_1);
				}
		$sql_meses = "SELECT TIMESTAMPDIFF(MONTH, '".date('Y-m-d',$inicio_mes )."', '".date('Y-m-d',$fin_mes )."') as meses";
		$res_meses = mysql_query($sql_meses,$conexion);
		$row_meses = mysql_fetch_array($res_meses);
		$dias_dif = $row_meses['meses']+1;
		$miSmarty->assign('total_meses',$dias_dif);
		for($i=0;$i<$dias_dif;$i++){
			$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
			$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
			array_push($arrRegistros_mes, array("mes"=>$mes_pos.' - '.$anio_pos));
			}

		$saldo_inicial = '0';
		
		array_push($arrRegistros_si, array(	"saldo_inicial"=>$saldo_inicial));

		if ($dias_dif>12){
			$objResponse->addAlert("Muchos periodos consultados.");
			}
		else{

			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = (int)date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_si = "SELECT coalesce(cupo,0) as cupo
						FROM `persona_tiene_cupos` 
						where 1 and rut_pers = '".$trabajador."'
						order by ptc_ncorr desc
				    ";
				$res_si = mysql_query($sql_si, $conexion) or die(mysql_error());
				$row_si = mysql_fetch_array($res_si);
				$asignacion_ant = $row_si['cupo'];
				
				
				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
	                    		from cargas_vehiculos 
	                    		 where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 						
	                    		 	and carga_tipo = '1'
						and carga_boleta = '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$carga_normal = $row_ab['monto'];

				array_push($arrRegistros_asig, array( "asignacion"=>$asignacion_ant));
				array_push($arrRegistros_cn, array(	"carga_normal"=>$carga_normal));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where carga_pers = '".$trabajador."'  and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 			
					     and carga_tipo = '1'
						and carga_boleta <> '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$cn_boleta = $row_ab['monto'];

				array_push($arrRegistros_cn_boleta, array(	"cn_boleta"=>$cn_boleta));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 	
					     and carga_tipo = '5' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$devo_carga = $row_ab['monto'];

				array_push($arrRegistros_devo_carga, array(	"devo_carga"=>$devo_carga));
				}	
				
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 		
					     and carga_tipo = '6' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$devo_asig  = $row_ab['monto'];

				array_push($arrRegistros_devo_asig, array(	"devo_asig"=>$devo_asig));
				
				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 		
					     and carga_tipo = '7' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$rev_asig  = $row_ab['monto'];

				array_push($arrRegistros_rev_asig, array(	"rev_asig"=>$rev_asig));
				}	
			
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and  carga_fecha <= '".$fecha_fin_ant."' 				
						and carga_tipo = '2'
						and carga_boleta = '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$extra = $row_ab['monto'];

				array_push($arrRegistros_extra, array(	"extra"=>$extra));
				}	
				
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 			
					     and carga_tipo = '2'
				and carga_boleta <> '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$extra_boleta  = $row_ab['monto'];

				array_push($arrRegistros_extra_boleta, array("extra_boleta"=>$extra_boleta));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$disponible = $arrRegistros_extra[$i]['extra']+$arrRegistros_extra_boleta[$i]['extra_boleta'];
				array_push($arrRegistros_total_extra, array("total_extra"=>$disponible));
				}
			for($i=0;$i<$dias_dif;$i++){
				
					//if ($arrRegistros_asig[$i]['asignacion']==$arrRegistros_cn[$i]['carga_normal']){
						//+B2+B3-B4-B6+B7-B8
						$disponible = $arrRegistros_asig[$i]['asignacion']+$arrRegistros_si[$i]['saldo_inicial']-$arrRegistros_cn[$i]['carga_normal']-$arrRegistros_cn_boleta[$i]["cn_boleta"]+$arrRegistros_devo_asig[$i]["devo_asig"]+$arrRegistros_rev_asig[$i]["rev_asig"];

						$tt =  $arrRegistros_asig[$i]['asignacion']  - $arrRegistros_devo_asig[$i]["devo_asig"];
						
						$cc =  $arrRegistros_asig[$i]['asignacion'] + $arrRegistros_devo_carga[$i]["rev_asig"] - $arrRegistros_devo_asig[$i]["devo_asig"]
							+ $arrRegistros_extra[$i]['extra']+$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	}
					// else {
						
					// 	$tt =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_cn_boleta[$i]["cn_boleta"]  - $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_rev_asig[$i]["rev_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	$cc =  $arrRegistros_cn[$i]['carga_normal'] - $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_rev_asig[$i]["rev_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					
					// 	$disponible = $arrRegistros_asig[$i]['asignacion'] - $tt;
					// 	}
					// // 	}
					// 	}
					// else{
					// 	$disponible = $arrRegistros_asig[$i]['asignacion'] + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"];
						
					// 	$tt =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_cn_boleta[$i]["cn_boleta"]  + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	$cc =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	}
					if ($i<$dias_dif-1){
						$arrRegistros_si[$i+1]['saldo_inicial'] = 0;
						}
					//$objResponse->addAlert($arrRegistros_asig[$i]['asignacion'].'+'.$arrRegistros_si[$i]['saldo_inicial'].'-'.$arrRegistros_cn[$i]['carga_normal'].'-'.$arrRegistros_cn_boleta[$i]["cn_boleta"].'+'.$arrRegistros_devo_carga[$i]["devo_carga"].'-'.$arrRegistros_devo_asig[$i]["devo_asig"]);
				array_push($arrRegistros_disponible, array(	"disponible"=>$disponible));
				array_push($arrRegistros_ctt, array(	"tt"=>$tt));
				array_push($arrRegistros_tct, array(	"cc"=>$cc));

				}	
			}
		}
	}
	elseif ($anio>$anio){
		$inicio_mes 		= mktime(0, 0, 0, $mes, 1,   $anio);
		$fin_mes 		= mktime(0, 0, 0, $mes, 1,   $anio);
		$sql_meses = "SELECT TIMESTAMPDIFF(MONTH, '".date('Y-m-d',$inicio_mes )."', '".date('Y-m-d',$fin_mes )."') as meses";
		$res_meses = mysql_query($sql_meses,$conexion);
		$row_meses = mysql_fetch_array($res_meses);
		$dias_dif = $row_meses['meses']+1;
		$miSmarty->assign('total_meses',$dias_dif);
		for($i=0;$i<$dias_dif;$i++){
			$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
			$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
			array_push($arrRegistros_mes, array("mes"=>$mes_pos.' - '.$anio_pos));
			}

		$saldo_inicial = '0';
		
		array_push($arrRegistros_si, array(	"saldo_inicial"=>$saldo_inicial));

		if ($dias_dif>12){
			$objResponse->addAlert("Muchos periodos consultados.");
			}
		else{
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = (int)date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_si = "SELECT coalesce(cupo,0) as cupo
						FROM `persona_tiene_cupos` 
						where 1 and rut_pers = '".$trabajador."'
						order by ptc_ncorr desc
				    ";
				$res_si = mysql_query($sql_si, $conexion) or die(mysql_error());
				$row_si = mysql_fetch_array($res_si);
				$asignacion_ant = $row_si['cupo'];
				
				$miSmarty->assign('asignacion_mensual', $asignacion_ant);
				array_push($arrRegistros_asig, array(	"asignacion"=>$asignacion_ant));

				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
	                    		from cargas_vehiculos 
	                    		 where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 						
	                    		 	and carga_tipo = '1'
						and carga_boleta = '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$carga_normal = $row_ab['monto'];

				array_push($arrRegistros_cn, array(	"carga_normal"=>$carga_normal));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where carga_pers = '".$trabajador."'  and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 			
					     and carga_tipo = '1'
						and carga_boleta <> '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$cn_boleta = $row_ab['monto'];

				array_push($arrRegistros_cn_boleta, array(	"cn_boleta"=>$cn_boleta));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 	
					     and carga_tipo = '5' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$devo_carga = $row_ab['monto'];

				array_push($arrRegistros_devo_carga, array(	"devo_carga"=>$devo_carga));
				}	
				
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);


				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 		
					     and carga_tipo = '6' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$devo_asig  = $row_ab['monto'];

				array_push($arrRegistros_devo_asig, array(	"devo_asig"=>$devo_asig));
				
				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 		
					     and carga_tipo = '7' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$rev_asig  = $row_ab['monto'];

				array_push($arrRegistros_rev_asig, array(	"rev_asig"=>$rev_asig));
				}	
					for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and  carga_fecha <= '".$fecha_fin_ant."' 				
						and carga_tipo = '2'
						and carga_boleta = '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$extra = $row_ab['monto'];

				array_push($arrRegistros_extra, array(	"extra"=>$extra));
				}	
				
			for($i=0;$i<$dias_dif;$i++){
				$anio_pos = date("Y",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$anio_1));
				
				$inicio_mes_ant		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes_pos, 1,   $anio_pos);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes_pos, $dia_mes_ant,   $anio_pos);
				$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);

				$sql_ab = "select coalesce(sum(carga_monto),0) as monto
					    from cargas_vehiculos 
					     where $and carga_fecha >=   '".$fecha_inicio_ant."' and carga_fecha <= '".$fecha_fin_ant."' 			
					     and carga_tipo = '2'
				and carga_boleta <> '0' ";
				$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
				$row_ab = mysql_fetch_array($res_ab);
				$extra_boleta  = $row_ab['monto'];

				array_push($arrRegistros_extra_boleta, array("extra_boleta"=>$extra_boleta));
				}	
			for($i=0;$i<$dias_dif;$i++){
				$disponible = $arrRegistros_extra[$i]['extra']+$arrRegistros_extra_boleta[$i]['extra_boleta'];
				array_push($arrRegistros_total_extra, array("total_extra"=>$disponible));
				}
			for($i=0;$i<$dias_dif;$i++){
				
					//if ($arrRegistros_asig[$i]['asignacion']==$arrRegistros_cn[$i]['carga_normal']){
						$disponible = $arrRegistros_asig[$i]['asignacion']+$arrRegistros_si[$i]['saldo_inicial']-$arrRegistros_cn[$i]['carga_normal']-$arrRegistros_cn_boleta[$i]["cn_boleta"]-$arrRegistros_devo_carga[$i]["devo_carga"]+$arrRegistros_devo_asig[$i]["devo_asig"];
						$tt =  $arrRegistros_asig[$i]['asignacion']  - $arrRegistros_devo_asig[$i]["devo_asig"];
						
						$cc =  $arrRegistros_asig[$i]['asignacion'] + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"]
							+ $arrRegistros_extra[$i]['extra']+$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	}
					// else {
						
					// 	$tt =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_cn_boleta[$i]["cn_boleta"]  - $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_rev_asig[$i]["rev_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	$cc =  $arrRegistros_cn[$i]['carga_normal'] - $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_rev_asig[$i]["rev_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					
					// 	$disponible = $arrRegistros_asig[$i]['asignacion'] - $tt;
					// 	}
					// // 	}
					// else{
					// 	$disponible = $arrRegistros_asig[$i]['asignacion'] + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"];
						
					// 	$tt =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_cn_boleta[$i]["cn_boleta"]  + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	$cc =  $arrRegistros_cn[$i]['carga_normal'] + $arrRegistros_devo_carga[$i]["devo_carga"] - $arrRegistros_devo_asig[$i]["devo_asig"] - $arrRegistros_extra[$i]['extra'] -$arrRegistros_extra_boleta[$i]['extra_boleta'];
					// 	}
					if ($i<$dias_dif-1){
						$arrRegistros_si[$i+1]['saldo_inicial'] = 0;
						}
					//$objResponse->addAlert($arrRegistros_asig[$i]['asignacion'].'+'.$arrRegistros_si[$i]['saldo_inicial'].'-'.$arrRegistros_cn[$i]['carga_normal'].'-'.$arrRegistros_cn_boleta[$i]["cn_boleta"].'+'.$arrRegistros_devo_carga[$i]["devo_carga"].'-'.$arrRegistros_devo_asig[$i]["devo_asig"]);
				array_push($arrRegistros_disponible, array(	"disponible"=>$disponible));
				array_push($arrRegistros_ctt, array(	"tt"=>$tt));
				array_push($arrRegistros_tct, array(	"cc"=>$cc));

				}	
			}
		}
	$miSmarty->assign('arrRegistros_mes',$arrRegistros_mes);
	$miSmarty->assign('arrRegistros_si',$arrRegistros_si);
	$miSmarty->assign('arrRegistros_asig',$arrRegistros_asig);
	$miSmarty->assign('arrRegistros_cn',$arrRegistros_cn);
	$miSmarty->assign('arrRegistros_cn_boleta',$arrRegistros_cn_boleta);
	$miSmarty->assign('arrRegistros_devo_asig',$arrRegistros_devo_asig);
	$miSmarty->assign('arrRegistros_rev_asig',$arrRegistros_rev_asig);
	$miSmarty->assign('arrRegistros_devo_carga',$arrRegistros_devo_carga);
	$miSmarty->assign('arrRegistros_disponible',$arrRegistros_disponible);
	$miSmarty->assign('arrRegistros_extra',$arrRegistros_extra);
	$miSmarty->assign('arrRegistros_extra_boleta',$arrRegistros_extra_boleta);
	$miSmarty->assign('arrRegistros_total_extra',$arrRegistros_total_extra);
	$miSmarty->assign('arrRegistros_anticipos',$arrRegistros_anticipos);
	$miSmarty->assign('arrRegistros_ctt',$arrRegistros_ctt);
	$miSmarty->assign('arrRegistros_tct',$arrRegistros_tct);
	
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_estado_individual_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	$ncorr 	= 	$data["$objeto2"];

        $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr."'  ";
	
        $res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {
                $objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	return $objResponse->getXML();
}  

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_estado_individual.tpl');

?>

