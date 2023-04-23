<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_seguros_ingresar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboPatente		= 	$data["cboPatente"];
	
	$and="";
		
    if ($cboPatente != ''){   
		$and = " where veh_patente like '%".$cboPatente."%'" ;
		}
		    
	$sql_ab = "select veh_patente, veh_nro_poliza, tipo_vehiculo.nombre,
					 	veh_anio, concat(veh_marca,' ',veh_modelo) as modelo
               	from vehiculos
               		inner join tipo_vehiculo
               			on tipo_vehiculo.tipo_veh_ncorr	= vehiculos.veh_tipo_veh
                	".$and."
				order by veh_patente";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 1;
			$monto_enero = $monto_feb=$monto_mar=$monto_abr=$monto_may=$monto_jun=	$monto_jul=$monto_ago=$monto_sep=$monto_oct=$monto_nov=$monto_dic=0;
			while ($line_ab_1 = mysql_fetch_row($res_ab)){
				
				$sql_enero = "select *
								from veh_tiene_cuotas
								where mes = 1
									and patente = '".$line_ab_1[0]."'";
				$res_enero = mysql_query($sql_enero,$conexion);
				if (mysql_num_rows($res_enero)>0){
					$row_enero = mysql_fetch_array($res_enero);
					$monto_pagado_ene = $row_enero['monto_pagado'];
					$factura_ene = $row_enero['factura'];
					$monto_enero = $monto_enero+ $monto_pagado_ene;
					}
				else{
					$monto_pagar_ene = 0;
					$monto_pagado_ene = 0;
					}
                $sql_febrero = "select *
								from veh_tiene_cuotas
								where mes = 2
									and patente = '".$line_ab_1[0]."'";
				$res_febrero = mysql_query($sql_febrero,$conexion);
				if (mysql_num_rows($res_febrero)>0){
					$row_febrero = mysql_fetch_array($res_febrero);
					$monto_pagado_feb = $row_febrero['monto_pagado'];
					$factura_feb = $row_febrero['factura'];
					$monto_feb = $monto_feb+ $monto_pagado_feb;
					}
				else{
					$monto_pagar_feb = 0;
					$monto_pagado_feb = 0;
					}
                $sql_marzo = "select *
								from veh_tiene_cuotas
								where mes = 3
									and patente = '".$line_ab_1[0]."'";
				$res_marzo = mysql_query($sql_marzo,$conexion);
				if (mysql_num_rows($res_marzo)>0){
					$row_marzo = mysql_fetch_array($res_marzo);
					$monto_pagado_mar = $row_marzo['monto_pagado'];
					$factura_mar = $row_marzo['factura'];
					$monto_mar = $monto_mar+ $monto_pagado_mar;
					}
				else{
					$monto_pagar_mar = 0;
					$monto_pagado_mar = 0;
					}
                $sql_abril = "select *
								from veh_tiene_cuotas
								where mes = 4
									and patente = '".$line_ab_1[0]."'";
				$res_abril = mysql_query($sql_abril,$conexion);
				if (mysql_num_rows($res_abril)>0){
					$row_abril = mysql_fetch_array($res_abril);
					$monto_pagado_abr = $row_abril['monto_pagado'];
					$factura_abr = $row_abril['factura'];
					$monto_abr = $monto_abr+ $monto_pagado_abr;
					}
				else{
					$monto_pagar_abr = 0;
					$monto_pagado_abr = 0;
					}
                $sql_mayo = "select *
								from veh_tiene_cuotas
								where mes = 5
									and patente = '".$line_ab_1[0]."'";
				$res_mayo = mysql_query($sql_mayo,$conexion);
				if (mysql_num_rows($res_mayo)>0){
					$row_mayo = mysql_fetch_array($res_mayo);
					$monto_pagado_may = $row_mayo['monto_pagado'];
					$factura_may = $row_mayo['factura'];
					$monto_may = $monto_may+ $monto_pagado_may;
					}
				else{
					$monto_pagar_may = 0;
					$monto_pagado_may = 0;
					}
                $sql_junio = "select *
								from veh_tiene_cuotas
								where mes = 6
									and patente = '".$line_ab_1[0]."'";
				$res_junio = mysql_query($sql_junio,$conexion);
				if (mysql_num_rows($res_junio)>0){
					$row_junio = mysql_fetch_array($res_junio);
					$monto_pagado_jun = $row_junio['monto_pagado'];
					$factura_jun = $row_junio['factura'];
					$monto_jun = $monto_jun+ $monto_pagado_jun;
					}
				else{
					$monto_pagar_jun = 0;
					$monto_pagado_jun = 0;
					}
                $sql_julio = "select *
								from veh_tiene_cuotas
								where mes = 7
									and patente = '".$line_ab_1[0]."'";
				$res_julio = mysql_query($sql_julio,$conexion);
				if (mysql_num_rows($res_julio)>0){
					$row_julio = mysql_fetch_array($res_julio);
					$monto_pagado_jul = $row_julio['monto_pagado'];
					$factura_jul = $row_julio['factura'];
					$monto_jul = $monto_jul+ $monto_pagado_jul;
					}
				else{
					$monto_pagar_jul = 0;
					$monto_pagado_jul = 0;
					}
                $sql_agosto = "select *
								from veh_tiene_cuotas
								where mes = 8
									and patente = '".$line_ab_1[0]."'";
				$res_agosto = mysql_query($sql_agosto,$conexion);
				if (mysql_num_rows($res_agosto)>0){
					$row_agosto = mysql_fetch_array($res_agosto);
					$monto_pagado_ago = $row_agosto['monto_pagado'];
					$factura_ago = $row_agosto['factura'];
					$monto_ago = $monto_ago+ $monto_pagado_ago;
					}
				else{
					$monto_pagar_ago = 0;
					$monto_pagado_ago = 0;
					}
                $sql_septiembre = "select *
								from veh_tiene_cuotas
								where mes = 9
									and patente = '".$line_ab_1[0]."'";
				$res_septiembre = mysql_query($sql_septiembre,$conexion);
				if (mysql_num_rows($res_septiembre)>0){
					$row_septiembre = mysql_fetch_array($res_septiembre);
					$monto_pagado_sep = $row_septiembre['monto_pagado'];
					$factura_sep = $row_septiembre['factura'];
					$monto_sep = $monto_sep+ $monto_pagado_sep;
					}
				else{
					$monto_pagar_sep = 0;
					$monto_pagado_sep = 0;
					}
                $sql_octubre = "select *
								from veh_tiene_cuotas
								where mes = 10
									and patente = '".$line_ab_1[0]."'";
				$res_octubre = mysql_query($sql_octubre,$conexion);
				if (mysql_num_rows($res_octubre)>0){
					$row_octubre = mysql_fetch_array($res_octubre);
					$monto_pagado_oct = $row_octubre['monto_pagado'];
					$factura_oct = $row_octubre['factura'];
					$monto_oct = $monto_oct+ $monto_pagado_oct;
					}
				else{
					$monto_pagar_oct = 0;
					$monto_pagado_oct = 0;
					}
                $sql_noviembre = "select *
								from veh_tiene_cuotas
								where mes = 11
									and patente = '".$line_ab_1[0]."'";
				$res_noviembre = mysql_query($sql_noviembre,$conexion);
				if (mysql_num_rows($res_noviembre)>0){
					$row_noviembre = mysql_fetch_array($res_noviembre);
					$monto_pagado_nov = $row_noviembre['monto_pagado'];
					$factura_nov = $row_noviembre['factura'];
					$monto_nov = $monto_nov+ $monto_pagado_nov;
					}
				else{
					$monto_pagar_nov = 0;
					$monto_pagado_nov = 0;
					}
                $sql_diciembre = "select *
								from veh_tiene_cuotas
								where mes = 12
									and patente = '".$line_ab_1[0]."'";
				$res_diciembre = mysql_query($sql_diciembre,$conexion);
				if (mysql_num_rows($res_diciembre)>0){
					$row_diciembre = mysql_fetch_array($res_diciembre);
					$monto_pagar_dic = $row_diciembre['monto_pagar'];
					$monto_pagado_dic = $row_diciembre['monto_pagado'];
					$factura_dic = $row_diciembre['factura'];
					$monto_dic = $monto_dic+ $monto_pagado_dic;
					}
				else{
					$monto_pagar_dic = 0;
					$monto_pagado_dic = 0;
					}
				$total = $monto_pagado_ene + $monto_pagado_feb + $monto_pagado_mar + $monto_pagado_abr + $monto_pagado_may +  	$monto_pagado_jun + $monto_pagado_jul + $monto_pagado_ago + $monto_pagado_sep + $monto_pagado_oct + $monto_pagado_nov + 	$monto_pagado_dic;
                array_push($arrRegistros, array("item"				=>	$i,
												"patente"         	=> 	$line_ab_1[0],
												"poliza"         	=> 	$line_ab_1[1],
												"monto_pagado_ene"  => 	$monto_pagado_ene,
												"monto_pagado_feb"  => 	$monto_pagado_feb,
												"monto_pagado_mar"  => 	$monto_pagado_mar,
												"monto_pagado_abr"  => 	$monto_pagado_abr,
												"monto_pagado_may"  => 	$monto_pagado_may,
												"monto_pagado_jun"  => 	$monto_pagado_jun,
												"monto_pagado_jul"  => 	$monto_pagado_jul,
												"monto_pagado_ago"  => 	$monto_pagado_ago,
												"monto_pagado_sep"  => 	$monto_pagado_sep,
												"monto_pagado_oct"  => 	$monto_pagado_oct,
												"monto_pagado_nov"  => 	$monto_pagado_nov,
												"monto_pagado_dic"  => 	$monto_pagado_dic,
												"factura_ene"  => 	$factura_ene,
												"factura_feb"  => 	$factura_feb,
												"factura_mar"  => 	$factura_mar,
												"factura_abr"  => 	$factura_abr,
												"factura_may"  => 	$factura_may,
												"factura_jun"  => 	$factura_jun,
												"factura_jul"  => 	$factura_jul,
												"factura_ago"  => 	$factura_ago,
												"factura_sep"  => 	$factura_sep,
												"factura_oct"  => 	$factura_oct,
												"factura_nov"  => 	$factura_nov,
												"factura_dic"  => 	$factura_dic,
												"total"		      	=> 	$total,
												"vehiculo"		   	=> 	$line_ab_1[2],
												"anio"		      	=>  $line_ab_1[3],
												"modelo"		   	=> 	$line_ab_1[4]));	
                $i++;
            	} 
				$total_1 = $monto_enero+$monto_feb+$monto_mar+$monto_abr+$monto_may+$monto_jun+	$monto_jul+$monto_ago+$monto_sep+$monto_oct+$monto_nov+$monto_dic;
				
				array_push($arrRegistros, array("item"				=>	$i,
								"patente"         	=> 	"Totales",
								"monto_pagado_ene"  => 	$monto_enero,
								"monto_pagado_feb"  => 	$monto_feb,
								"monto_pagado_mar"  => 	$monto_mar,
								"monto_pagado_abr"  => 	$monto_abr,
								"monto_pagado_may"  => 	$monto_may,
								"monto_pagado_jun"  => 	$monto_jun,
								"monto_pagado_jul"  => 	$monto_jul,
								"monto_pagado_ago"  => 	$monto_ago,
								"monto_pagado_sep"  => 	$monto_sep,
								"monto_pagado_oct"  => 	$monto_oct,
								"monto_pagado_nov"  => 	$monto_nov,
								"monto_pagado_dic"  => 	$monto_dic,
								"total"		      	=> 	$total_1));	
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_seguros_ingresar_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
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


function Actualizar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$mes = $data['rdMes_oculto'];
	$patente = $data['cboPatente'];
	
	$sql = "select *
					from veh_tiene_cuotas
					where mes = ".$mes."
					and patente = '".$patente."'";
	$res = mysql_query($sql,$conexion);
	if (mysql_num_rows($res)>0){
		$sql = "update veh_tiene_cuotas
						set monto_pagar = '".$data['rdmonto_pagar']."' , 
							monto_pagado = '".$data['rdmonto_pagado']."'
						where mes = ".$mes."
						and patente = '".$patente."'";
		$res = mysql_query($sql,$conexion);
	}else{
		$sql = "insert into veh_tiene_cuotas(monto_pagado,monto_pagar,mes,factura,patente)
					values('".$data['rdmonto_pagado']."','".$data['rdmonto_pagar']."',".$mes.",
							".$data['rdfactura'].",'".$patente."')";
		$res = mysql_query($sql,$conexion);
		}
	$objResponse->addAlert("Elemento guardado");
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
}  

function Traevalor($data,$mes,$patente){
    global $conexion;
    global $miSmarty;
	
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("cboPatente", "value", $patente);
	$sql_2 = "select nombre	
				from meses 
				where mes_ncorr = '".$mes."'";
	$res_2 = mysql_query($sql_2, $conexion) or die(mysql_error());
	$mes_1 = @mysql_result($res_2,0,"nombre");
	$objResponse->addAssign("rdMes", "value", $mes_1);
	$objResponse->addAssign("rdMes_oculto", "value", $mes);
				
	$sql = "select *
					from veh_tiene_cuotas
					where mes = '".$mes."'
					and patente = '".$patente."'";
	$res = mysql_query($sql,$conexion);
	if (mysql_num_rows($res)>0){
		$row = mysql_fetch_array($res);
		$monto_pagar = $row['monto_pagar'];
		$monto_pagado = $row['monto_pagado'];
	}else{
		$monto_pagar = 0;
		}
	$objResponse->addAssign("rdmonto_pagar", "value", $monto_pagar);
	$objResponse->addAssign("rdmonto_pagado", "value", $monto_pagado);
	
	
	return $objResponse->getXML();
}  

$xajax->registerFunction("Traevalor");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Actualizar");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_seguros_ingresar.tpl');

?>

