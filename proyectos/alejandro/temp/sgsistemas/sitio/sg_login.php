<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
unset($_SESSION['alycar_sistemas']);

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_login.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Acceso($data,$cadena){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divacceso", "innerHTML", $cadena);
	
	return $objResponse->getXML();
}          
function Historial($data){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');

  //  $objResponse->addScript("showPopWin('sg_foto_inicio.php', 'Inicio', 600, 400, null);");
	
    $sql_hito = "select * from historial_calendario order by hc_ncorr desc limit 0,5";
    $res_hito = mysql_query($sql_hito,$conexion) or die(mysql_error());
    
    $arrRegistros = array();
    
    while($row_hito = mysql_fetch_array($res_hito)){
    	array_push($arrRegistros, array("accion" => $row_hito['accion'], 
    									"descripcion"	=> 	$row_hito['descripcion'], 
    									"fecha"	=> 	$row_hito['fecha_dig'], 
    									"usuario"	=> 	$row_hito['usuario']));
    	}
    $miSmarty->assign('arrRegistros', $arrRegistros);
    $objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_login_list.tpl'));
     
    $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'area','area','','','color','nombre', '')");
	   
    return $objResponse->getXML();
    }

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    	global $conexion;
    	$objResponse = new xajaxResponse('ISO-8859-1');
    
    	$objResponse->addAssign("$select","innerHTML","");
    	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
    	$res = mysql_query($sql, $conexion);
    	if (mysql_num_rows($res) > 0) {
    		$j = 0;
    		while ($line = mysql_fetch_array($res)) {
    			$objResponse->addCreate("$select","option","");
    			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
    			$objResponse->addAssign("$select","options[".$j."].text", $line[1]);
    			$j++;
    		}
    	}
    	return $objResponse->getXML();
    }

function Ingresa($data,$opt){
    	global $conexion;
    	$objResponse = new xajaxResponse('ISO-8859-1');
    
	$_SESSION['alycar_sistemas']	= 	'SI';
	
	if ($opt == '1'){ // Sistema gestion yonley
		$objResponse->addScript("top.location.href='../../sgyonley/sitio/sg_index.php';");
	}
	if ($opt == '2'){ // Sistema fondos por rendir
		$objResponse->addScript("top.location.href='../../sgfondos/sitio/sg_index.php';");
	}
	if ($opt == '3'){ // Sistema banco
		//$objResponse->addScript("top.location.href='../../sgbanco/sitio/sg_index.php';");
		$objResponse->addScript("top.location.href='../../backup/sgtesoreria/sitio/sg_index.php';");
	}
	if ($opt == '4'){ // Sistema Cuentas Personales
		$objResponse->addScript("top.location.href='../../scyonley/sitio/sg_index.php';");
	}
	if ($opt == '5'){ // Sistema gestion yonley antiguo
		$objResponse->addScript("top.location.href='../../sgyonleyold/sitio/sg_index.php';");
	}
	/*
	if ($opt == '6'){ // Sistema Administraci�n Facturaci�n Electr�nica
		$objResponse->addScript("top.location.href='http://192.168.1.40/adminfact/sitio/sg_index.php';");
	}
	*/
	if ($opt == '6'){ // Sistema Gesti�n Documentos
		$objResponse->addScript("top.location.href='../../ingdoc/sitio/sg_index.php';");
	}
	if ($opt == '7'){ // Sistema Copec
		$objResponse->addScript("top.location.href='../../sgcopec/sitio/sg_index.php';");
	}
	if ($opt == '8'){ // Sistema Caja Chica
		$objResponse->addScript("top.location.href='../../sgcaja/sitio/sg_index.php';");
	}
	if ($opt == '9'){ // Sistema CompraVentas
		$objResponse->addScript("top.location.href='../../sglibros/sitio/sg_index.php';");
	}
	if ($opt == '10'){ // Sistema Gerencia
		$objResponse->addScript("top.location.href='../../sggerencia/sitio/sg_index.php';");
	}
	if ($opt == '11'){ // Sistema Vales
		$objResponse->addScript("top.location.href='../../sgvales/sitio/sg_index.php';");
	}
	if ($opt == '12'){ // Sistema Compras
		$objResponse->addScript("top.location.href='../../sgcompras/sitio/sg_index.php';");
	}
	if ($opt == '13'){ // Sistema Bodega
		$objResponse->addScript("top.location.href='../../backup/sgbodega/sitio/sg_index.php';");
	}
	if ($opt == '14'){ // Sistema Recursos Humanos
		$objResponse->addScript("top.location.href='../../backup/sgrrhh/sitio/sg_index.php';");
	}
	if ($opt == '15'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../sggestion_documental/sitio/sg_index.php';");
	}
	if ($opt == '16'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../sgcalendario/sitio/sg_index.php';");
	}
	if ($opt == '17'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../backup/sgyonley_boletas/sitio/sg_index.php';");
	}
	if ($opt == '18'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../backup/sgcuentascriticas/';");
	}
	if ($opt == '19'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../backup/sgdeptocompras/';");
	}
	if ($opt == '20'){ // Sistema Gestion Documental
		$objResponse->addScript("top.location.href='../../backup/sgeeff/';");
	}
		
	return $objResponse->getXML();
} 

$xajax->registerFunction("Acceso");
$xajax->registerFunction("Ingresa");
$xajax->registerFunction("Historial");

$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_login.tpl');

?>

