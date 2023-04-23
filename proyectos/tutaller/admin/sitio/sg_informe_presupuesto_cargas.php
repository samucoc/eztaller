<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_presupuesto_cargas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboEmpresa		= 	$data["cboEmpresa"];
	$cboTipo_Comb		= 	$data["cboTipo_Comb"];
	$fecha_inicio		= 	$data["OBLI-txtFecha1"];
	$fecha_fin		= 	$data["OBLI-txtFecha2"];
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha_inicio);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = explode('/', $fecha_fin);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_fin              = date("Y-m-d",$nro_mes_anterior);
        $and_1="";
		$and_2="";
		
     if (($cboTipo_Comb != '')&&($cboTipo_Comb != 'Todos')){   
		$and_1 = " and tip_com_ncorr like '%".$cboTipo_Comb."%'" ;
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
			array_push($arrRegistros, array("ncorr"         => 	$line_ab_1[0],
											"rut_empresa"  	=> 	$line_ab_1[1],
											"desc"    		=> 	$line_ab_1[2]));
			//asignaciones mensuales
				$arr_totales = array();
				$arr_totales[0] =0;
				$arr_totales[1]= 0;
				$arr_totales[2] =0;
				$arr_totales[3] =0;
				//armo lo cargado normalmente
				$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto) as monto, tipo_combustible.nombre
							from cargas_vehiculos
								inner join vehiculos
									on cargas_vehiculos.carga_veh = vehiculos.veh_patente
								inner join tipo_combustible
									on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
							where cargas_vehiculos.carga_tipo = 1
								and cargas_vehiculos.carga_fecha between '".$fecha_inicio."' and '".$fecha_fin."'
								and vehiculos.veh_emp = '".$line_ab_1[1]."'
							".$and_1."
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
					if ($row_1['nombre']=='DIESEL'){
						$arr_montos_cn[3] = $row_1['monto'];
						$arr_totales[3] = $arr_totales[3] - $row_1['monto'];
						}
					}
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
														"tipo_corto"    => 	"asignaciones",
														"tipo"         	=> 	"Asignaciones Mensuales" ,
														"primero"  		=> 	$arr_montos_cn[0],
														"segundo"  		=> 	$arr_montos_cn[1],
														"tercero"  		=> 	$arr_montos_cn[2],
														"cuarto"  		=> 	$arr_montos_cn[3],
														"inicio"		=>	$fecha_inicio,
														"fin"			=>  $fecha_fin));
			//extras promediados
				
				$mes_anterior = mktime(0, 0, 0, date("m")-3, date("d"),   date("Y"));
				$fecha_anterior = date("Y-m-d",$mes_anterior);
				//armo lo cargado extra
				$sql_ab_1 = "select sum(cargas_vehiculos.carga_monto)/3 as monto, tipo_combustible.nombre
							from cargas_vehiculos
								inner join vehiculos
									on cargas_vehiculos.carga_veh = vehiculos.veh_patente
								inner join tipo_combustible
									on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
							where cargas_vehiculos.carga_tipo = 2
								and cargas_vehiculos.carga_fecha between '".$fecha_anterior."' and '".$fecha_fin."'
								and vehiculos.veh_emp = '".$line_ab_1[1]."'
							".$and_1."
							GROUP BY tipo_combustible.nombre ";
				$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
				$arr_montos_cn = array();
				$arr_montos_cn[0] =0;
				$arr_montos_cn[1]= 0;
				$arr_montos_cn[2] =0;
				$arr_montos_cn[3] =0;
				while ($row_1 = mysql_fetch_array($res_ab_1)){
					if ($row_1['nombre']=='93'){
						$arr_montos_cn[0] = round($row_1['monto']);
						$arr_totales[0] = $arr_totales[0] - round($row_1['monto']);
						}
					if ($row_1['nombre']=='95'){
						$arr_montos_cn[1] = round($row_1['monto']);
						$arr_totales[1] = $arr_totales[1] - round($row_1['monto']);
						}
					if ($row_1['nombre']=='96'){
						$arr_montos_cn[2] = round($row_1['monto']);
						$arr_totales[2] = $arr_totales[2] - round($row_1['monto']);
						}
					if ($row_1['nombre']=='DIESEL'){
						$arr_montos_cn[3] = round($row_1['monto']);
						$arr_totales[3] = $arr_totales[3] - round($row_1['monto']);
						}
					}
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
														"tipo_corto"    => 	"extras",
														"tipo"         	=> 	"Extras Promedio 3 meses" ,
														"primero"  		=> 	$arr_montos_cn[0],
														"segundo"  		=> 	$arr_montos_cn[1],
														"tercero"  		=> 	$arr_montos_cn[2],
														"cuarto"  		=> 	$arr_montos_cn[3],
														"inicio"		=>	$fecha_inicio,
														"fin"			=>  $fecha_fin));
			//presupuestado
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
														"tipo_corto"    => 	"presupuesto",
														"tipo"         	=> 	"Presupuestado",
														"primero"  		=> 	$arr_totales[0]*(-1),
														"segundo"  		=> 	$arr_totales[1]*(-1),
														"tercero"  		=> 	$arr_totales[2]*(-1),
														"cuarto"  		=> 	$arr_totales[3]*(-1),
														"inicio"		=>	$fecha_inicio,
														"fin"			=>  $fecha_fin));
			//comprado
				//armo lo comprado
				$sql_ab_1 = "select sum(detalle_compra_combustible.monto) as monto , tipo_combustible.nombre
						from detalle_compra_combustible
							inner join tipo_combustible
									on tipo_combustible.tip_com_ncorr = detalle_compra_combustible.tipo_combustible
						where
							detalle_compra_combustible.fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
							and detalle_compra_combustible.empresa = '".$line_ab_1[1]."'
							".$and_1."
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
					if ($row_1['nombre']=='DIESEL'){
						$arr_montos_cn[3] = $row_1['monto'];
						$arr_totales[3] = $arr_totales[3] + $row_1['monto'];
						}
					}
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
														"tipo_corto"    => 	"comprado",
														"tipo"         	=> 	"Comprado" ,
														"primero"  		=> 	$arr_montos_cn[0],
														"segundo"  		=> 	$arr_montos_cn[1],
														"tercero"  		=> 	$arr_montos_cn[2],
														"cuarto"  		=> 	$arr_montos_cn[3],
														"inicio"		=>	$fecha_inicio,
														"fin"			=>  $fecha_fin));
			//direfencia
				//sumo y resto
				array_push($arrRegistros_detalle, array("empresa"       => 	$line_ab_1[1],
														"tipo_corto"    => 	"diferencia",
														"tipo"         	=> 	"Diferencia",
														"primero"  		=> 	$arr_totales[0],
														"segundo"  		=> 	$arr_totales[1],
														"tercero"  		=> 	$arr_totales[2],
														"cuarto"  		=> 	$arr_totales[3],
														"inicio"		=>	$fecha_inicio,
														"fin"			=>  $fecha_fin));
			
			} 
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistros_detalle', $arrRegistros_detalle);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_presupuesto_cargas_list.tpl'));
		
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


$miSmarty->display('sg_informe_presupuesto_cargas.tpl');

?>

