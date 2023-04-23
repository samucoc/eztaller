<?php
session_start();
require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("menu_lateral.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaInicial($data,$grupo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	if (!isset($grupo)){
		$objResponse->addScript("parent.frames['principal'].location='portada.php';");
		}
	return $objResponse->getXML();
} 

function Carga($data, $link){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("parent.frames['principal'].location='$link';");
	return $objResponse->getXML();
} 

//CARGA LOS MENUES
$arrRegistros = array();

//menues normales
$perfil = $_SESSION["alycar_perfil"];   	
if (isset($_GET['grupo'])){
	$sql = "select * 
                from menues_hijos 
                where (menu_ncorr = '".$_GET['id_menu']."' 
					and mhij_mostrar = 'NO' 
                    and mhij_ncorr in (select pagina
									   from bodega_tiene_paginas
									   	where bodega = '".$_SESSION['alycar_sgyonley_bodega']."'
												and usuario = '".$_SESSION["alycar_usuario"]."')
					and menu_sub = ".$_GET['grupo'].")
                order by mhij_orden";
	}

else{
	if (isset($_GET['id_menu']))
	$sql = "select * 
                from menues_hijos 
                where (menu_ncorr = '".$_GET['id_menu']."' 
					and mhij_mostrar = 'SI' 
                    and mhij_ncorr in (select pagina
									   from bodega_tiene_paginas
									   	where bodega = '".$_SESSION['alycar_sgyonley_bodega']."'
												and usuario = '".$_SESSION["alycar_usuario"]."')
					)
                order by mhij_orden";
	else
	$sql = "select * 
                from menues_hijos 
                where (mhij_mostrar = 'SI' 
						and mhij_ncorr in (select pagina
									   from bodega_tiene_paginas
									   	where bodega = '".$_SESSION['alycar_sgyonley_bodega']."'
												and usuario = '".$_SESSION["alycar_usuario"]."')
										)
                order by mhij_orden";
	}
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
			array_push($arrRegistros, array("descripcion" => $line['mhij_desc'], "link" => $line['mhij_link']));
	}

$miSmarty->assign('arrRegistros', $arrRegistros);
if (isset($_GET['titulo']))
	$miSmarty->assign('TITULO_MENU', $_GET['titulo']);
if (isset($_GET['grupo']))
	$miSmarty->assign('grupo', $_GET['grupo']);
	
//$xajax->registerFunction("Carga");
$xajax->registerFunction("Carga");
$xajax->registerFunction("CargaInicial");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('menu_lateral.tpl');

?>

