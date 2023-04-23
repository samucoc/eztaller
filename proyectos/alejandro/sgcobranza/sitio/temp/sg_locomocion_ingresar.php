<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_locomocion_ingresar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$centro_costo 		= $data['OBLIcentro_costo'];
	$sector 		= $data['OBLItxtCodSector'];
	$fecha	 			= $data['OBLItxtFecha'];
	$monto_diario		= $data['OBLImonto_diario'];
	$cant_dias 			= $data['OBLIcant_dias'];
	$total	 			= $data['OBLItxtMontoIngresar'];
	$trabajador			= $data['OBLItxtRut'];
	$usuario			= $_SESSION['alycar_usuario'];
	$estado				= 'PAGADO';
	$fecha_digitacion 	= date("Y-m-d H:i:s");
	$tt				= $data['OBLItt'];

	list($anio3,$mes3,$dia3) = explode('-', date("Y-m-d"));
	list($dia2,$mes2,$anio2) = explode('/', $fecha);
	$grupo 				= 1;
			
	//if (($mes3 == $mes2)&&($anio3 == $anio2)&&($dia3 <= $dia2)) {
		if (($fecha!='')&&($monto_diario!='')&&($trabajador!='')){
			list($dia3,$mes3,$anio3) = explode('/', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;
			$fecha_ant = "";
			if (!isset($_SESSION['locomocion_grupo'])){
				$sql_grupo = "select (grupo + 1) as grupo, fecha
								from locomocion
								order by grupo desc
								limit 0,1";
				$res_grupo = mysql_query($sql_grupo,$conexion);
				if (mysql_num_rows($res_grupo)==0){
					$grupo=1;
					$fecha_ant = $fecha; //dia-mes-anio
					}
				else{
					$row_grupo = mysql_fetch_array($res_grupo);
					$grupo = $row_grupo['grupo'];
					
					$estado = $row_grupo['estado'];
					$fecha_ant = $row_grupo['fecha']; //anio-mes-dia
					}
				}
			else{
				$grupo 		= $_SESSION['locomocion_grupo'] ;
				$sql_grupo = "select grupo, fecha
								from locomocion
								where grupo = '".$_SESSION['locomocion_grupo']."'";
				$res_grupo = mysql_query($sql_grupo,$conexion);
				if (mysql_num_rows($res_grupo)==0){
					$grupo = $_SESSION['locomocion_grupo'];
					$fecha_ant = $fecha; 
					}
				else{
					$row_grupo = mysql_fetch_array($res_grupo);
					$grupo = $row_grupo['grupo'];
					$fecha_ant = $row_grupo['fecha']; //anio-mes-dia
					}
				}
			$_SESSION['locomocion_grupo'] = $grupo ;
			$objResponse->addAssign("grupo", "innerHTML",$grupo );
			$monto = str_replace(".", "", $monto);

			if ($fecha_ant==$fecha){
					$sql = "insert into locomocion ( `empresa`, `rut_trab`, `fecha`, `monto_dias`, `cantidad_dias`, `total`, `usuario`, `fecha_digitacion`, grupo,estado, tipo_trab) 
					values ('$centro_costo', '$trabajador','$fecha_ant','$monto_diario','$cant_dias','$total','$usuario','$fecha_digitacion','$grupo','$estado', '$tt')";
					$res = mysql_query($sql,$conexion) or die(mysql_error());
				}
			$sql_buscar = "select locomocion_ncorr, fecha, rut_trab, monto_dias, cantidad_dias, total
							from locomocion 
							where grupo = '".$_SESSION['locomocion_grupo']."'";
			$res_buscar = mysql_query($sql_buscar,$conexion);
			$arrRegistros = array();
			$total = 0;
			while ($row=mysql_fetch_array($res_buscar)){
				$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
							from sggeneral.trabajadores
							where rut = ".$row['rut_trab'];
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$row_1 = mysql_fetch_array($res_1);
				
				$nombre_trabajador = $row_1['nombres'];
				$cantidad = $row['monto_dias'];
				$cantidad_dias = $row['cantidad_dias'];
				$total_monto = $row['total'];
				array_push($arrRegistros, array(
								"trabajador"	=> $nombre_trabajador,
								"monto"			=> $cantidad,
								"dias"			=> $cantidad_dias,
								"total"			=> $total_monto,
								"fecha"			=> $row['fecha'],
								"codigo"		=> $row['locomocion_ncorr']
								));
				$total = $total + $total_monto;
				}
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('total', $total);
			$miSmarty->assign('grupo', $_SESSION['locomocion_grupo']);
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_locomocion_ingresar_list.tpl'));	
			$objResponse->addAssign("OBLItxtFecha", "value","");
			$objResponse->addAssign("OBLItxtMontoIngresar", "value","");
			$objResponse->addAssign("OBLImonto_diario", "value","");
			$objResponse->addAssign("OBLIcant_dias", "value","");
			$objResponse->addAssign("OBLItxtRut", "value","");
			$objResponse->addAssign("OBLItxtNombres", "value","");
			}
//		}
//		else{
//			$objResponse->addAlert("Fecha fuera del rango del mes");
//			}
//	if (($mes3 == $mes2)&&($anio3 == $anio2)&&($dia3 <= $dia2)) {
			$fecha = $anio2.'-'.$mes2.'-'.$dia2;
			
			$miSmarty->assign('arrRegistros', $arrRegistros);
			
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_locomocion_ingresar_list.tpl'));	
			$objResponse->addAssign("OBLItxtFecha", "value","");
			$objResponse->addAssign("OBLItxtMontoIngresar", "value","");
			$objResponse->addAssign("OBLImonto_diario", "value","");
			$objResponse->addAssign("OBLIcant_dias", "value","");
			$objResponse->addAssign("OBLItxtRut", "value","");
			$objResponse->addAssign("OBLItxtNombres", "value","");
//		}
//	else{
//		$objResponse->addAlert("Fecha fuera del rango del mes");
//		}
    return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	/*
	$sql_1 = "select monto_asig_locomocion
				from sggeneral.trabajadores_tiene_laboral
				where rut_trab = '".$campo1."'";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);

	$objResponse->addAssign("OBLImonto_diario", "value",$row_1['monto_asig_locomocion']);
	//$objResponse->addAssign("monto_diario", "innerHTML",$row_1['monto_asig_locomocion']);
	*/	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	unset($_SESSION['locomocion_grupo']);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcentro_costo','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLItt','tipos_trabajadores','','- - Seleccione - -','tt_ncorr','nombre', '')");
	return $objResponse->getXML();
	
}  

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data[$objeto1];
	$empresa = $data['OBLIcentro_costo'];
	$sql = "";
	if ($tabla == 'sggeneral.trabajadores'){
		$campo2 = "concat(nombres,' ',apellido_pat,' ',apellido_mat)";
		$sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '$rut' $c_and ";
		}
	else{
		$sql = "select $campo1 as rut, $campo2 as descripcion 
			from $tabla 
			where $campo1 = '$rut' $c_and 
				and empe_ncorr in (select empe_ncorr from sgyonley.empresas where empe_rut = '".$empresa."')";
		
		}
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	/*$sql_1 = "select monto_asig_locomocion
				from sggeneral.trabajadores_tiene_laboral
				where rut_trab = '".@mysql_result($res,0,"rut")."'";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$row_1 = mysql_fetch_array($res_1);

	$objResponse->addAssign("OBLImonto_diario", "value",$row_1['monto_asig_locomocion']);
	$objResponse->addAssign("monto_diario", "innerHTML",$row_1['monto_asig_locomocion']);
	*/	
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
    if ($tabla != 'personas'){
           $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
        } 
    else{
            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";
        }
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}
function CargaPopWin($data, $url){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$url = $url .'&empresa='.$data['OBLIcentro_costo'];
	$objResponse->addScript("showPopWin('".$url."', 'Busca Trabajador', 550, 350, null);");

	return $objResponse->getXML();
	
}
function Eliminar($data, $ncorr){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_4 = "select grupo from sgvales.locomocion where locomocion_ncorr = '".$ncorr."'";
	$res_4 = mysql_query($sql_4,$conexion) or die(mysql_error());
	$row_4 = mysql_fetch_array($res_4);
	$grupo = $row_4['grupo'];
	
	$sql_5 = "delete from sgvales.locomocion where locomocion_ncorr = '".$ncorr."'";
	$res_5 = mysql_query($sql_5,$conexion) or die(mysql_error());
	
	$sql_buscar = "select locomocion_ncorr, fecha, rut_trab, monto_dias, cantidad_dias, total
							from locomocion 
							where grupo = '".$grupo."'";
	$res_buscar = mysql_query($sql_buscar,$conexion);
	$arrRegistros = array();
	while ($row=mysql_fetch_array($res_buscar)){
		$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
					from sggeneral.trabajadores
					where rut = ".$row['rut_trab'];
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		$row_1 = mysql_fetch_array($res_1);
		
		$nombre_trabajador = $row_1['nombres'];
		$cantidad = $row['monto_dias'];
		$cantidad_dias = $row['cantidad_dias'];
		$total = $row['total'];
		array_push($arrRegistros, array(
						"trabajador"	=> $nombre_trabajador,
						"monto"			=> $cantidad,
						"dias"			=> $cantidad_dias,
						"total"			=> $total,
						"fecha"			=> $row['fecha'],
						"codigo"		=> $row['locomocion_ncorr']
						));
		$total = $total + $cantidad;
		}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('total', $total);

	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_locomocion_ingresar_list.tpl'));				
	
	return $objResponse->getXML();
	
}
function CalcularTotal($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$cant_dias 		= $data['OBLIcant_dias'];
	$monto_diario 	= $data['OBLImonto_diario'];
	
	$total = $cant_dias * $monto_diario;
	
	$objResponse->addAssign("OBLItxtMontoIngresar", "value", $total);
	
	return $objResponse->getXML();
	}
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CalcularTotal");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPopWin");
$xajax->registerFunction("Eliminar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_locomocion_ingresar.tpl');

?>

