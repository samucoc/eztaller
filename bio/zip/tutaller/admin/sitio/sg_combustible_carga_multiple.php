<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_combustible_carga_multiple.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function GrabarMultiple($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$arr_patente 	= $data['patente'];
	$arr_rut 		= $data['rut'];
	$arr_monto		= $data['monto'];
	$fecha 			= $data['fecha'];
	$carga			= $data['carga'];
	if ($fecha!=''){
		list($dia1,$mes1,$anio1) = explode('/', $fecha);	$fecha	= $anio1."-".$mes1."-".$dia1;
	// bloqueo los ingresos posteriores a la fecha de cierre.
	$sql_cierre			= 	"select cier_fecha as ultimocierre 
								from cierres
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 			= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
	$ingresa 	= 	"SI";
	if ($dias_dif < 0){
			$ingresa 	= 	"NO";
			$objResponse->addScript("alert('Fecha antes del cierre.')");
			unset($_SESSION["alycar_sgyonley_aumento"]);
			$objResponse->addScript("window.document.Form1.submit();");
		}
		
	if ($ingresa == 'SI'){
		for ($i=0; $i<count($arr_rut); $i++){
			//	inserto el registro
			
			$patente = $arr_patente[$i];
			$rut = $arr_rut[$i];
			$monto = $arr_monto[$i];
			$sql = "insert into cargas_vehiculos (carga_veh,carga_pers,carga_monto,carga_fecha,carga_tipo, carga_usuario)
					values ('".$patente."','".$rut."','".$monto."','".$fecha."','".$carga."','".$_SESSION["alycar_usuario"]."')";
			$res = mysql_query($sql,$conexion);
			}
			
		$objResponse->addScript("alert('Registros Grabados Correctamente.')");
		$objResponse->addScript("document.location.href='sg_combustible_carga_multiple.php';");	
		}
		}
	else{
		$objResponse->addScript("alert('Ingrese fecha.')");
		}
	return $objResponse->getXML();
	}
function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboEmpresa		= 	$data["cboEmpresa"];
	$cboTipo_Comb	= 	$data["cboTipo_Comb"];
	$cboDepto		= 	$data["cboDepto"];
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
        $and="";
		
     if (($cboTipo_Comb != '')&&($cboTipo_Comb != 'Todos')){   
		$and = " and tipo_combustible.tip_com_ncorr like '%".$cboTipo_Comb."%'" ;
	 }
	if (($cboEmpresa != '')&&($cboEmpresa != 'Todas')){   
		$and .= " and empresas.empe_rut like '%".$cboEmpresa."%'" ;
	 }
	if (($cboDepto != '')&&($cboDepto != 'Todos')){   
		$and .= " and vehiculos.veh_depto like '%".$cboDepto."%'" ;
	 }

	$sql_ab = "SELECT empresas.empe_desc, tipo_combustible.nombre, vehiculos.veh_patente, CONCAT( personas.pers_nombre,  ' ', 
					personas.pers_ape_pat ) AS nombre_persona, personas.pers_rut, departamentos.nombre
				FROM vehiculos
				RIGHT JOIN departamentos ON departamentos.departamento_ncorr = vehiculos.veh_depto
				LEFT JOIN empresas ON vehiculos.veh_emp = empresas.empe_rut
				LEFT JOIN tipo_combustible ON vehiculos.veh_tipo_comb = tipo_combustible.tip_com_ncorr
				LEFT JOIN personas_tienen_vehiculos ON vehiculos.veh_patente = personas_tienen_vehiculos.patente
				inner JOIN personas ON personas_tienen_vehiculos.rut = personas.pers_rut
					where 1 
					        ".$and."";
	//$objResponse->addAlert($sql_ab);
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 0;
		while ($line_ab_1 = mysql_fetch_row($res_ab)){
			array_push($arrRegistros, array("item"			=>	$i,
											"empresa"  		=> 	$line_ab_1[0],
											"tipo_comb"     => 	$line_ab_1[1],
											"patente"      	=> 	$line_ab_1[2],
											"trabajador"  	=> 	$line_ab_1[3],
											"rut_trabajador"=> 	$line_ab_1[4],
											"depto"			=> 	$line_ab_1[5]));
			$i++;
			
			} 
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_combustible_carga_multiple_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_combustible_carga_multiple_list.tpl'));
	
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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboPersona','personas','todos','Todos','pers_rut', 'pers_nombre', '')");
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("GrabarMultiple");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_combustible_carga_multiple.tpl');

?>

