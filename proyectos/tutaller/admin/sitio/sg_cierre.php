<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones
$xajax = new xajax();

$xajax->setRequestURI("sg_cierre.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$cier_fecha			=	$data["OBLItxtFecha"];
	$cier_usuario		=	$_SESSION["alycar_usuario"];
	$cier_fechadig		=	date("Y-m-d H:i:s");
	$cier_mes			=	$data["cboMes"];
	$cier_anio			=	$data["cboAnio"];
	$ult_cierre			=	$data["txtUltimoCierre"];
	$ingresa			=	'SI';
	
	list($dia2,$mes2,$anio2) = explode('/', $cier_fecha);$cier_fecha = $anio2."-".$mes2."-".$dia2;
	
	if ($ult_cierre != ''){
		list($dia3,$mes3,$anio3) = explode('/', $ult_cierre);$ult_cierre = $anio3."-".$mes3."-".$dia3;
		
		// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
		$sql_dif =	"SELECT DATEDIFF('".$cier_fecha."','".$ult_cierre."') as dias_dif";
		$res_dif = mysql_query($sql_dif,$conexion);
		$dias_dif = @mysql_result($res_dif,0,"dias_dif");
		if ($dias_dif <= 0){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Fecha de Cierre Incorrecta. Debe ser mayor a la fecha del último cierre.')");
		}	
	}
	if ($ingresa == 'SI'){
		if ($cier_mes == '' OR $cier_mes == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Mes incorrecto.')");
		}
	}
	if ($ingresa == 'SI'){
		if ($cier_anio == '' OR $cier_anio == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Año incorrecto.')");
		}
	}
	
	if ($ingresa == 'SI'){
		$sql = "insert into cierres
				(empe_rut,cier_fecha,cier_usuario,cier_fechadig, cier_mes, cier_anio)
				
				values 
				('".$empe_rut."','".$cier_fecha."','".$cier_usuario."','".$cier_fechadig."','".$cier_mes."','".$cier_anio."')";
		
		$res = mysql_query($sql, $conexion);
		
			$arr_totales  = array();
			$arr_totales[0] =0;
			$arr_totales[1]= 0;
			$arr_totales[2] =0;
			$arr_totales[3] =0;
				
				$inicio_mes_ant		= mktime(0, 0, 0, $cier_mes, 1,   $cier_anio);
				$fecha_inicio       = date("Y-m-d",$inicio_mes_ant);

				$medio_mes_ant 		= mktime(0, 0, 0, $cier_mes, 1,   $cier_anio);
				$dia_mes_ant	        = date("t",$medio_mes_ant);
				
				$fin_mes_ant 		= mktime(0, 0, 0, $cier_mes, $dia_mes_ant,   $cier_anio);
				$fecha_fin	        = date("Y-m-d",$fin_mes_ant);


			$sql_ab_1 = "select sum(saldo_inicial.saldo_inicial) as monto , octanaje as nombre, empresa
                    from saldo_inicial
                    where
                        empresa = '".$empe_rut."' and mes = '".$cier_mes."' and anio = '".$cier_anio."'
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
			
			$sql_ab_1 = "select sum(detalle_compra_combustible.monto) as monto , tipo_combustible.nombre
                    from detalle_compra_combustible
						inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = detalle_compra_combustible.tipo_combustible
                    where
                        detalle_compra_combustible.fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
						and detalle_compra_combustible.empresa = '".$empe_rut."'
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
			
			//armo lo cargado normalmente
			$sql_ab_1 = "select distinct cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre, carga_veh, carga_fecha
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 1
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$empe_rut."'							
							and cargas_vehiculos.veh_empe = '".$empe_rut."'
							";
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
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 2
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$empe_rut."'
							and cargas_vehiculos.veh_empe = '".$empe_rut."'
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
			
			
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 5
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$empe_rut."'
							and cargas_vehiculos.veh_empe = '".$empe_rut."'
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
	
			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 6
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$empe_rut."'
							and cargas_vehiculos.veh_empe = '".$empe_rut."'
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

			
			//armo lo cargada como extra
			$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 7
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
							and vehiculos.veh_emp = '".$empe_rut."'
							and cargas_vehiculos.veh_empe = '".$empe_rut."'
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

		$anio_pos = date("Y",mktime(0,0,0,$cier_mes+1,1,$cier_anio));
		$mes_pos = date("m",mktime(0,0,0,$cier_mes+1,1,$cier_anio));
		$fecha_pos = date("Y-m-d",mktime(0,0,0,$cier_mes+1,1,$cier_anio));
			

		$sql_001 = "select * persona_tiene_cupos where mes = '".$cier_mes."' and anio = '".$cier_anio."'"
		$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
		while($row_001 = mysql_fetch_array($res_001)){

			$sql_insert = "INSERT INTO `persona_tiene_cupos`(`rut_pers`, `cupo`, `fecha`, `usuario`, `mes`, `anio`) 
												VALUES ('".$row_001['rut_pers']."','".$row_001['cupo']."','".$fecha_pos."','".$_SESSION["alycar_usuario"]."',
														'".$anio_pos."','".$mes_pos."')"
			$res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
			}

		//sumo y resto
		$sql_insert = "INSERT INTO `saldo_inicial`(`mes`, `anio`, `empresa`, `octanaje`, `saldo_inicial`) 
						VALUES ('".$mes_pos."','".$anio_pos."','".$empe_rut."','93','".$arr_totales[0]."')";
		$res_insert = mysql_query($sql_insert,$conexion);
		$sql_insert = "INSERT INTO `saldo_inicial`(`mes`, `anio`, `empresa`, `octanaje`, `saldo_inicial`) 
						VALUES ('".$mes_pos."','".$anio_pos."','".$empe_rut."','95','".$arr_totales[1]."')";
		$res_insert = mysql_query($sql_insert,$conexion);
		$sql_insert = "INSERT INTO `saldo_inicial`(`mes`, `anio`, `empresa`, `octanaje`, `saldo_inicial`) 
						VALUES ('".$mes_pos."','".$anio_pos."','".$empe_rut."','97','".$arr_totales[2]."')";
		$res_insert = mysql_query($sql_insert,$conexion);
		$sql_insert = "INSERT INTO `saldo_inicial`(`mes`, `anio`, `empresa`, `octanaje`, `saldo_inicial`) 
						VALUES ('".$mes_pos."','".$anio_pos."','".$empe_rut."','99','".$arr_totales[3]."')";
		$res_insert = mysql_query($sql_insert,$conexion);

		// if ($ult_cierre != ''){
			
		// 	// graba el ncorr del cierre para diferenciar los movimientos en la tabla movim (cier_ncorr)
		// 	$cier_ncorr = @mysql_insert_id();
			
		// 	// sumo 1 dia a la fecha del ultimo cierre
		// 	$sql_fecha1 = 	"SELECT DATE_FORMAT(DATE_ADD('".$ult_cierre."', INTERVAL 1 DAY),'%d/%m/%Y') as fecha1";
		// 	$res_fecha1 = 	mysql_query($sql_fecha1,$conexion);
		// 	$fecha1		=	@mysql_result($res_fecha1,0,"fecha1");
		// 	$fecha2		=	$cier_fecha;
			
		// 	$sql_upd = "update cierres set cier_ncorr = '".$cier_ncorr."' where movim_fecha >= '".$fecha1."' and movim_fecha <= '".$fecha2."'";
		// 	$res_upd = mysql_query($sql_upd,$conexion);
		// }
		
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			
		$objResponse->addScript("document.Form1.submit();");
	}
	
	return $objResponse->getXML();
}
function MuestraUltCierre($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//$empe_rut		=	$data["OBLIcboEmpresa"];
	$OBLIcboEmpresa		=	$data["OBLIcboEmpresa"];
	
	$sql = "select DATE_FORMAT(cier_fecha,'%d/%m/%Y') as ultimocierre from cierres where empe_rut = '".$OBLIcboEmpresa."' order by cier_fecha desc limit 1";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("txtUltimoCierre", "value", @mysql_result($res,0,"ultimocierre"));
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	
	//$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");
	$objResponse->addScript("document.getElementById('OBLItxtCodTrabajador').focus();");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	if (mysql_num_rows($res) > 0) {
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
	
	$ncorr_trab		= 	$data["OBLItxtCodTrabajador"];
	$ncorr 			= 	$data["$objeto1"];
	$empe_rut		=	$data["OBLIcboEmpresa"];
	$tgas_ncorr 	= 	$data["OBLItxtCodGasto"];
	
	if ($tabla == 'trabajadores'){
		$sql = "select concat(trab_nombres,' ',trab_apellidos) as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	}else{
	
		if ($tabla == 'sgyonley.sectores'){
			$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".$empe_rut."'"; $res_eco = mysql_query($sql_eco,$conexion);
			$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
			
			$sql = "select sect_desc as descripcion from $tabla where sect_cod = '".$ncorr."' and empe_ncorr = '".$empe_ncorr."'";
		
		}else{
		
			if ($tabla == 'tipos_subgastos'){
				$sql = "select tsga_desc as descripcion from tipos_subgastos where tsga_ncorr = '".$ncorr."' and tgas_ncorr = '".$tgas_ncorr."'";
			}else{	
				if ($tabla == 'tipos_gastos'){
					$objResponse->addAssign("OBLItxtCodSubGasto", "value", "");
					$objResponse->addAssign("OBLItxtDescSubGasto", "value", "");
				}
				$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
			}
		}
	}
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("MuestraUltCierre");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_cierre.tpl');

?>

