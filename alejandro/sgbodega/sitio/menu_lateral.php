<?php
session_start();
require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("menu_lateral.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function CargaInicial($data,$grupo){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	if (!isset($grupo)){
		$objResponse->addScript("parent.frames['principal'].location='portada.php';");
		}
	return $objResponse->getXML();
} 

function Carga($data, $link){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
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
                    and mhij_perfil < ".$perfil."
					and menu_sub = ".$_GET['grupo'].")
                    OR
                    (menu_ncorr = '".$_GET['id_menu']."' 
                    and mhij_mostrar = 'NO'
                    and mhij_perfil = ".$perfil."
					and menu_sub = ".$_GET['grupo'].")
                order by mhij_orden";
	}
else{
	$sql = "select * 
                from menues_hijos 
                where (menu_ncorr = '".$_GET['id_menu']."' 
					and mhij_mostrar = 'SI' 
                    and mhij_perfil < ".$perfil."
					)
                    OR
                    (menu_ncorr = '".$_GET['id_menu']."' 
                    and mhij_mostrar = 'SI'
                    and mhij_perfil = ".$perfil."
					)
                order by mhij_orden";
	}
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
			array_push($arrRegistros, array("descripcion" => $line['mhij_desc'], "link" => $line['mhij_link']));
	}
/*if ($perfil=='99'){
		$sql = "select * 
	                from menues_hijos 
	                	inner join usuarios_perfiles_menu
	                		on usuarios_perfiles_menu.mhij_ncorr = menues_hijos.mhij_ncorr
	                where (menues_hijos.menu_ncorr = '".$_GET['id_menu']."' 
						and menu_sub = ".$_GET['grupo'].")
	                order by mhij_orden";
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
		array_push($arrRegistros, array("descripcion" => $line['mhij_desc'], "link" => $line['mhij_link']));
		}

	}
else{
	if (isset($_GET['grupo'])){
		$sql = "select * 
	                from menues_hijos 
	                	inner join usuarios_perfiles_menu
	                		on usuarios_perfiles_menu.mhij_ncorr = menues_hijos.mhij_ncorr
	                where (menues_hijos.menu_ncorr = '".$_GET['id_menu']."' 
						and mhij_mostrar = 'NO' 
	                   	and menu_sub = ".$_GET['grupo'].")
	                    OR
	                    (menu_ncorr = '".$_GET['id_menu']."' 
	                    and mhij_mostrar = 'NO'
	                    and menu_sub = ".$_GET['grupo'].")
	                order by mhij_orden";
		}
	else{
		$sql = "select * 
	                from menues_hijos 
	                	inner join usuarios_perfiles_menu
	                		on usuarios_perfiles_menu.mhij_ncorr = menues_hijos.mhij_ncorr
	                where (menues_hijos.menu_ncorr = '".$_GET['id_menu']."' 
						and mhij_mostrar = 'SI' )
	                    OR
	                    (menu_ncorr = '".$_GET['id_menu']."' 
	                    and mhij_mostrar = 'SI')
	                order by mhij_orden";
		}
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
		array_push($arrRegistros, array("descripcion" => $line['mhij_desc'], "link" => $line['mhij_link']));
		}

	}
*/
$miSmarty->assign('arrRegistros', $arrRegistros);
$miSmarty->assign('TITULO_MENU', $_GET['titulo']);
$miSmarty->assign('grupo', $_GET['grupo']);
	
//$xajax->registerFunction("Carga");
$xajax->registerFunction("Carga");
$xajax->registerFunction("CargaInicial");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('menu_lateral.tpl');

?>

