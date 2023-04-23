<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_estado_cuenta_detalle.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$data["empresa"];
	$tipo	= 	$data["tipo"];
	$octanaje	= 	$data["octanaje"];
	$inicio	= 	$data["inicio"];
	$fin		= 	$data["fin"];
	$cboDepto		= 	$data["depto"];
	
	if (($cboDepto != '')&&($cboDepto != 'Todos')){   
		$and_3 = " and departamento like '%".$cboDepto."%'" ;
	 }
	 if (($cboDepto != '')&&($cboDepto != 'Todos')){ 
	 	if ($cboDepto == '1') $and_4 = ' and cargas_vehiculos.veh_depto = "0" ';
		else $and_4 = ' and cargas_vehiculos.veh_depto = "2" ';
		
		 }
	 

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	$arrRegistros = array();
	
	/*list($dia1,$mes1,$anio1) = explode('-', $inicio);
	$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
	$inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = explode('-', $fin);
	$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
	$fin              = date("Y-m-d",$nro_mes_anterior);
	*/
	//armo lo comprado
	if ($tipo == 'Comprado'){
		$sql_ab_1 = "select detalle_compra_combustible.monto, tipo_combustible.nombre, 
							detalle_compra_combustible.fecha,detalle_compra_combustible.empresa,compra_combustible.usuario
				from detalle_compra_combustible
					inner join tipo_combustible
							on tipo_combustible.tip_com_ncorr = detalle_compra_combustible.tipo_combustible
					inner join compra_combustible
							on compra_combustible.cc_ncorr = detalle_compra_combustible.cc_ncorr
				where
					detalle_compra_combustible.fecha between '".$inicio."' and '".$fin."' 
					and detalle_compra_combustible.empresa = '".$empresa."'
					and tipo_combustible.nombre like '%".$octanaje."%' $and_3
					";
		$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
		$total= 0;
		while ($row_1 = mysql_fetch_array($res_ab_1)){
			$total = $total + $row_1['monto'];
			array_push($arrRegistros, array("concepto"      => 	"Combustible Comprado. Tipo: ".$row_1['nombre']." Empresa: ".$row_1['empresa'],
											"fecha"         => 	$row_1['fecha'] ,
											"monto"  		=> 	$row_1['monto'],
											"usuario"  		=> 	$row_1['usuario']));
			}
		array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
		}
		
		if ($tipo=='Cargas Normales'){
			//armo lo cargado normalmente
			$sql_ab_1 = "select distinct cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente and vehiculos.veh_emp = cargas_vehiculos.veh_empe
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 1
							and cargas_vehiculos.carga_fecha between '".$inicio."' and '".$fin."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%' $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Carga Normal. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}
		if ($tipo=='Cargas Extras'){
			//armo lo cargada como extra
			$sql_ab_1 = "select cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 2
							and cargas_vehiculos.carga_fecha between '".$inicio."' and '".$fin."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%' $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Carga Extra. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}
		
		if ($tipo=='Anticipos'){
			//armo lo cargada como extra
			//
			//		
			list($anio_1,$mes_1,$dia_1) = explode('-',$inicio);
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1-1, 16,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, 15,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
			

			$sql_ab_1 = "select cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 4
							and cargas_vehiculos.carga_fecha between '".$fecha_inicio_ant."' and '".$fecha_fin_ant."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%'  $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Anticipo. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}

	if ($tipo=='Reversa de Consumo'){
			//armo lo cargada como extra
			//
			//		
			list($anio_1,$mes_1,$dia_1) = explode('-',$inicio);
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1-1, 16,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, 15,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
			

			$sql_ab_1 = "select cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 5
							and cargas_vehiculos.carga_fecha between '".$inicio."' and '".$fin."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%'  $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Anticipo. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}

	if ($tipo=='Devoluciones de Asignacion'){
			//armo lo cargada como extra
			//
			//		
			list($anio_1,$mes_1,$dia_1) = explode('-',$inicio);
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1-1, 16,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, 15,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
			

			$sql_ab_1 = "select cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 6
							and cargas_vehiculos.carga_fecha between '".$inicio."' and '".$fin."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%'  $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Anticipo. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}

	if ($tipo=='Reversas de Asignacion'){
			//armo lo cargada como extra
			//
			//		
			list($anio_1,$mes_1,$dia_1) = explode('-',$inicio);
			$inicio_mes_ant		= mktime(0, 0, 0, $mes_1-1, 16,   $anio_1);
			$fecha_inicio_ant       = date("Y-m-d",$inicio_mes_ant);
			$fin_mes_ant 		= mktime(0, 0, 0, $mes_1, 15,   $anio_1);
			$fecha_fin_ant	        = date("Y-m-d",$fin_mes_ant);
			

			$sql_ab_1 = "select cargas_vehiculos.carga_monto as monto, tipo_combustible.nombre,
								cargas_vehiculos.carga_fecha as fecha, cargas_vehiculos.carga_usuario as usuario, 
								cargas_vehiculos.carga_veh as patente
						from cargas_vehiculos
							inner join vehiculos
								on cargas_vehiculos.carga_veh = vehiculos.veh_patente
							inner join tipo_combustible
								on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
						where cargas_vehiculos.carga_tipo = 7
							and cargas_vehiculos.carga_fecha between '".$inicio."' and '".$fin."' 
							and cargas_vehiculos.veh_empe = '".$empresa."'
							and vehiculos.veh_emp = '".$empresa."'
							and tipo_combustible.nombre like '%".$octanaje."%'  $and_4";
			$res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());	
			$total= 0;
			while ($row_1 = mysql_fetch_array($res_ab_1)){
				$total = $total + $row_1['monto'];
					array_push($arrRegistros, array("concepto"      => 	"Anticipo. Tipo: ".$row_1['nombre']." - Patente : ".$row_1['patente'],
													"fecha"         => 	$row_1['fecha'] ,
													"monto"  		=> 	$row_1['monto'],
													"usuario"  		=> 	$row_1['usuario']));			
				}
			array_push($arrRegistros, array("concepto"      => 	"Total",
								"fecha"         => 	"xxxx",
								"monto"  		=> 	$total,
								"usuario"  		=> 	"----"));
			}

	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_estado_cuenta_detalle_list.tpl'));
		
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

$miSmarty->assign('empresa', $_GET["empresa"]);
$miSmarty->assign('tipo', $_GET["tipo"]);
$miSmarty->assign('octanaje', $_GET["octanaje"]);
$miSmarty->assign('inicio', $_GET["inicio"]);
$miSmarty->assign('fin', $_GET["fin"]);
$miSmarty->assign('depto', $_GET["depto"]);

$miSmarty->display('sg_estado_cuenta_detalle.tpl');

?>

