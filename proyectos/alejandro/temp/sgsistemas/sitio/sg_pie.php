<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

//date_default_timezone_set("America/Santiago");
//setlocale(LC_TIME, 'spanish');

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_pie.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
    //global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	//echo strftime("%A %d de %B del %Y");
	//$objResponse->addAssign("divfecha", "innerHTML", strftime("Hoy es %A %d de %B del %Y")." ".date(" H:i:s",time()));
	//$objResponse->addAssign("divfecha", "innerHTML", date ( "j del n de Y" ));
	//$objResponse->addAssign("divfecha", "innerHTML", 'hola');
	
	//$objResponse->addAssign("divfecha", "innerHTML", strftime("%A %d de %B del %Y"));
	$dia	=	strtoupper(strftime("%A"));
	$mes	=	strtoupper(strftime("%B"));
	
	if ($dia == 'MONDAY')	{$dia	=	'Lunes';}
	if ($dia == 'TUESDAY')	{$dia	=	'Martes';}
	if ($dia == 'WEDNESDAY'){$dia	=	'Miercoles';}
	if ($dia == 'THURSDAY')	{$dia	=	'Jueves';}
	if ($dia == 'FRIDAY')	{$dia	=	'Viernes';}
	if ($dia == 'SATURDAY')	{$dia	=	'Sábado';}
	if ($dia == 'SUNDAY')	{$dia	=	'Domingo';}
	
	if ($mes == 'JANUARY')	{$mes	=	'Enero';}
	if ($mes == 'FEBRUARY')	{$mes	=	'Febrero';}
	if ($mes == 'MARCH')	{$mes	=	'Marzo';}
	if ($mes == 'APRIL')	{$mes	=	'Abril';}
	if ($mes == 'MAY')		{$mes	=	'Mayo';}
	if ($mes == 'JUNE')		{$mes	=	'Junio';}
	if ($mes == 'JULY')		{$mes	=	'Julio';}
	if ($mes == 'AUGUST')	{$mes	=	'Agosto';}
	if ($mes == 'SEPTEMBER'){$mes	=	'Septiembre';}
	if ($mes == 'OCTOBER')	{$mes	=	'Octubre';}
	if ($mes == 'NOVEMBER')	{$mes	=	'Noviembre';}
	if ($mes == 'DECEMBER')	{$mes	=	'Diciembre';}
	

	$objResponse->addAssign("divfecha", "innerHTML", "Hoy es ".$dia." ".strftime("%d")." de ".$mes." ".strftime("del %Y"));
	
	
	return $objResponse->getXML();
}          

$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_pie.tpl');

?>

