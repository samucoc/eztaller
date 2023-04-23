<?php session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}
require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();
$xajax->setRequestURI("sg_consultas_cumple_pagos.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('UTF8');
    $anio = $_SESSION["sige_anio_escolar_vigente"];
    $sql_cuota = "select Sum(ValorPactado) as ValorPactado, sum(ValorPagado) as ValorPagado, FechaVencimiento
				  from gescolcl_arcoiris_administracion.CuentaCorriente".$anio."
				  	inner join gescolcl_arcoiris_administracion.Matriculas
				  		on gescolcl_arcoiris_administracion.Matriculas.NumeroRutAlumno = gescolcl_arcoiris_administracion.CuentaCorriente".$anio.".NumeroRutAlumno
				  			and gescolcl_arcoiris_administracion.Matriculas.Anio = ".$anio."
				  			and gescolcl_arcoiris_administracion.Matriculas.FechaRetiro = '0000-00-00'
				  			
				  	where FechaVencimiento between '".$anio."-01-01' and '".$anio."-12-31' 
				  	group by FechaVencimiento asc";
	$res_cuota = mysql_query($sql_cuota,$conexion) ;
	$arrRegistros = array();
	$i=0;
	while($row_cuota = mysql_fetch_array($res_cuota)){
		$i++;
		$porcentaje = 100 - (($row_cuota['ValorPagado']*100)/$row_cuota['ValorPactado']);
		list($anio_ele,$mes_ele,$dia_ele) = explode('-',$row_cuota['FechaVencimiento']);
		array_push($arrRegistros, array('ncorr'			=>	$i,
						'mes'			=> 	$mes_ele.'-'.$anio_ele,
						'proyectado'	=>	number_format($row_cuota['ValorPactado'],0,'.',','),
						'real'			=>	number_format($row_cuota['ValorPagado'],0,'.',','),
						'porcentaje'	=>	round($porcentaje,2)
						));
		}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_consultas_cumple_pagos_list.tpl'));
	return $objResponse->getXML();
	} 
$xajax->registerFunction("CargaPagina");
$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->display('sg_consultas_cumple_pagos.tpl');
?>