<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_estado_cuenta.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboEmpresa		= 	$data["cboEmpresa"];
	$cboTipo_Comb	= 	$data["cboTipo_Comb"];
	$cboDepto		= 	$data["cboDepto"];
	$mes			= 	$data["cboMes"];
	$anio			= 	$data["cboAnio"];
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	

        $and_1="";
		$and_2="";
		$and_3="";
		$and_4="";
		
     if (($cboTipo_Comb != '')&&($cboTipo_Comb != 'Todos')){   
		$and_1 = " and tip_com_ncorr like '%".$cboTipo_Comb."%'" ;
	 }
     if (($cboDepto != '')&&($cboDepto != 'Todos')){   
		$and_3 = " and departamento like '%".$cboDepto."%'" ;
	 }
	 if (($cboDepto != '')&&($cboDepto != 'Todos')){ 
	 	if ($cboDepto == '1') $and_4 = ' and cargas_vehiculos.veh_depto = "0" ';
		else $and_4 = ' and cargas_vehiculos.veh_depto = "2" ';
		}

	 if (($cboEmpresa != '')&&($cboEmpresa != 'Todas')){   
		$and_2= " where empe_rut like '%".$cboEmpresa."%'" ;
	 }
	 
	$sql_ab = "select *
				from empresas
					".$and_2;
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$arrRegistros_detalle	= 	array();
		while ($line_ab_1 = mysql_fetch_row($res_ab)){
			//seteo la empresa
			$boleta = 'Todos';
			if ($cboDepto=='2'){
				$boleta = 'Boleta';
				}
			elseif ($cboDepto=='1'){
				$boleta = 'Casa Matriz';
				}
			array_push($arrRegistros, array("ncorr"         => 	$line_ab_1[0],
											"rut_empresa"  	=> 	$line_ab_1[1],
											"desc"    		=> 	$line_ab_1[2],
											"boleta"    	=> 	$boleta,
											"mes"    		=> 	$mes,
											"anio"    		=> 	$anio));
			//armo lo comprado
			$arr_totales  = array();
			$arr_totales[0] =0;
			$arr_totales[1]= 0;
			$arr_totales[2] =0;
			$arr_totales[3] =0;

				$inicio_mes_ant		= mktime(0, 0, 0, $mes, 1,   $anio);
				$fecha_inicio       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $mes, 1,   $anio);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $mes, $dia_mes_ant,   $anio);
				$fecha_fin	        = date("Y-m-d",$fin_mes_ant);


			$sql_ab_1 = "select sum(saldo_inicial.saldo_inicial) as monto , octanaje as nombre, empresa
                    from saldo_inicial
                    where
                        empresa = '".$line_ab_1[1]."' and mes = '".$mes."' and anio = '".$anio."'
						GROUP BY octanaje, empresa
						";
        	$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
			$arr_montos_si = array();
			$arr_montos_si[0] =0;
			$arr_montos_si[1]= 0;
			$arr_montos_si[2] =0;
			$arr_montos_si[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
					if ($row_1['nombre']=='93'){
						$arr_montos_si[0] = $row_1['monto'];
						$arr_totales[0] = $arr_totales[0] + $row_1['monto'];
						}
					if ($row_1['nombre']=='95'){
						$arr_montos_si[1] = $row_1['monto'];
						$arr_totales[1] = $arr_totales[1] + $row_1['monto'];
						}
					if ($row_1['nombre']=='96'){
						$arr_montos_si[2] = $row_1['monto'];
						$arr_totales[2] = $arr_totales[2] + $row_1['monto'];
						}
					if ($row_1['nombre']=='99'){
						$arr_montos_si[3] = $row_1['monto'];
						$arr_totales[3] = $arr_totales[3] + $row_1['monto'];
						}
					}
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
									"tipo"         	=> 	"Saldo Inicial" ,
									"primero"  		=> 	$arr_montos_si[0],
									"segundo"  		=> 	$arr_montos_si[1],
									"tercero"  		=> 	$arr_montos_si[2],
									"cuarto"  		=> 	$arr_montos_si[3],
									"inicio"		=>	$fecha_inicio,
									"fin"			=>  $fecha_fin,
									"depto"			=>  $cboDepto));

			$sql_ab_1 = "select sum(detalle_compra_combustible.monto) as monto , tipo_combustible.nombre
                    from detalle_compra_combustible
						inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = detalle_compra_combustible.tipo_combustible
                    where
                        detalle_compra_combustible.fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
						and detalle_compra_combustible.empresa = '".$line_ab_1[1]."'
						".$and_1." ".$and_3." 
						GROUP BY tipo_combustible.nombre
						";
        	$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] = $row_1['monto'];
					$arr_totales[0] = $arr_totales[0] + $row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] = $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] + $row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] = $row_1['monto'];
					$arr_totales[2] = $arr_totales[2] + $row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] = $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] + $row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Comprado" ,
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			//armo lo cargado normalmente
			$sql_ab_1 = "select distinct cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre, carga_veh, carga_fecha
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 1
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$line_ab_1[1]."'							
							and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
						".$and_1." ".$and_4." ";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] += $row_1['monto'];
					$arr_totales[0] = $arr_totales[0] - $row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] += $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] - $row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] += $row_1['monto'];
					$arr_totales[2] = $arr_totales[2] - $row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] += $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] - $row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Cargas Normales",
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 2
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$line_ab_1[1]."'
							and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
						".$and_1." ".$and_4." 
						GROUP BY tipo_combustible.nombre ";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] = $row_1['monto'];
					$arr_totales[0] = $arr_totales[0] - $row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] = $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] - $row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] = $row_1['monto'];
					$arr_totales[2] = $arr_totales[2] - $row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] = $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] - $row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Cargas Extras",
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			
			list($anio_1,$mes_1,$dia_1) = explode('-',$fecha_inicio);
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1-1, 16,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, 15,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
			

			// //armo lo cargada como extra
			// $sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
			// 			from cargas_vehiculos
			// 				inner join vehiculos
			// 					on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
			// 				inner join tipo_combustible
			// 					on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
			// 			where cargas_vehiculos.carga_tipo = 4
			// 				and cargas_vehiculos.carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."'
			// 				and vehiculos.veh_emp = '".$line_ab_1[1]."'
			// 				and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
			// 			".$and_1." ".$and_4." 
			// 			GROUP BY tipo_combustible.nombre ";
			// $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			// $arr_montos_cn = array();
			// $arr_montos_cn[0] =0;
			// $arr_montos_cn[1]= 0;
			// $arr_montos_cn[2] =0;
			// $arr_montos_cn[3] =0;
			// while ($row_1 = mysql_fetch_array($res_ab_1)){
			// 	if ($row_1['nombre']=='93'){
			// 		$arr_montos_cn[0] = $row_1['monto'];
			// 		$arr_totales[0] = $arr_totales[0] - $row_1['monto'];
			// 		}
			// 	if ($row_1['nombre']=='95'){
			// 		$arr_montos_cn[1] = $row_1['monto'];
			// 		$arr_totales[1] = $arr_totales[1] - $row_1['monto'];
			// 		}
			// 	if ($row_1['nombre']=='96'){
			// 		$arr_montos_cn[2] = $row_1['monto'];
			// 		$arr_totales[2] = $arr_totales[2] - $row_1['monto'];
			// 		}
			// 	if ($row_1['nombre']=='PD'){
			// 		$arr_montos_cn[3] = $row_1['monto'];
			// 		$arr_totales[3] = $arr_totales[3] - $row_1['monto'];
			// 		}
			// 	}
			// array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
			// 										"tipo"         	=> 	"Anticipos",
			// 										"primero"  		=> 	$arr_montos_cn[0],
			// 										"segundo"  		=> 	$arr_montos_cn[1],
			// 										"tercero"  		=> 	$arr_montos_cn[2],
			// 										"cuarto"  		=> 	$arr_montos_cn[3],
			// 										"inicio"		=>	$fecha_inicio,
			// 										"fin"			=>  $fecha_fin));
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 5
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$line_ab_1[1]."'
							and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
						".$and_1." ".$and_4." 
						GROUP BY tipo_combustible.nombre ";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] = $row_1['monto'];
					$arr_totales[0] = $arr_totales[0] +$row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] = $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] +$row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] = $row_1['monto'];
					$arr_totales[2] = $arr_totales[2] +$row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] = $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] +$row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Reversa de Consumo",
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 6
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$line_ab_1[1]."'
							and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
						".$and_1." ".$and_4." 
						GROUP BY tipo_combustible.nombre ";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] = $row_1['monto'];
					$arr_totales[0] = $arr_totales[0]+ $row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] = $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] +$row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] = $row_1['monto'];
					$arr_totales[2] = $arr_totales[2]+ $row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] = $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] +$row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Devoluciones de Asignacion",
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 7
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$line_ab_1[1]."'
							and cargas_vehiculos.veh_empe = '".$line_ab_1[1]."'
						".$and_1." ".$and_4." 
						GROUP BY tipo_combustible.nombre ";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$arr_montos_cn = array();
			$arr_montos_cn[0] =0;
			$arr_montos_cn[1]= 0;
			$arr_montos_cn[2] =0;
			$arr_montos_cn[3] =0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				if ($row_1['nombre']=='93'){
					$arr_montos_cn[0] = $row_1['monto'];
					$arr_totales[0] = $arr_totales[0]+ $row_1['monto'];
					}
				if ($row_1['nombre']=='95'){
					$arr_montos_cn[1] = $row_1['monto'];
					$arr_totales[1] = $arr_totales[1] +$row_1['monto'];
					}
				if ($row_1['nombre']=='96'){
					$arr_montos_cn[2] = $row_1['monto'];
					$arr_totales[2] = $arr_totales[2]+ $row_1['monto'];
					}
				if ($row_1['nombre']=='PD'){
					$arr_montos_cn[3] = $row_1['monto'];
					$arr_totales[3] = $arr_totales[3] +$row_1['monto'];
					}
				}
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Reversas de Asignacion",
													"primero"  		=> 	$arr_montos_cn[0],
													"segundo"  		=> 	$arr_montos_cn[1],
													"tercero"  		=> 	$arr_montos_cn[2],
													"cuarto"  		=> 	$arr_montos_cn[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin,
													"depto"			=>  $cboDepto));
			
			//sumo y resto
			array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
													"tipo"         	=> 	"Totales",
													"primero"  		=> 	$arr_totales[0],
													"segundo"  		=> 	$arr_totales[1],
													"tercero"  		=> 	$arr_totales[2],
													"cuarto"  		=> 	$arr_totales[3],
													"inicio"		=>	$fecha_inicio,
													"fin"			=>  $fecha_fin));
			} 
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistros_detalle', $arrRegistros_detalle);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_estado_cuenta_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
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
	$ncorr_1 	= 	$data["$objeto2"];

        $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
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


$miSmarty->display('sg_informe_estado_cuenta.tpl');

?>

