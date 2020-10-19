<?php
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_consultas_detalle_boletas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();


function CargaPagina($data){
    global $conexion;
    global $miSmarty;
    
    $objResponse = new xajaxResponse('ISO-8859-1');

	$fecha_inicio  	= $data['fecha_inicio'];
	$fecha_fin  	= $data['fecha_fin'];

	
	list($d,$m,$a)  = explode('/',$fecha_inicio);
	$fecha_inicio 			= $a.'-'.$m.'-'.$d;

	list($d,$m,$a)  = explode('/',$fecha_fin); 
	$fecha_fin 			= $a.'-'.$m.'-'.$d;

    $sql_boletas = "select DATE_FORMAT(FechaBoleta,'%d/%m/%Y') as FechaBoleta, `NumeroBoleta`, 
    				EstadoBoleta , Sum(ValorBoleta) as ValorPagado, NumeroRutAlumno, PeriodoMovimiento
					from gescolcl_test.Movimientos 
					where FechaBoleta between '".$fecha_inicio."' and '".$fecha_fin."' 
					group by FechaBoleta, NumeroBoleta, EstadoBoleta";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	
	$arrRegistros = array();
	$i=0;
	while($row_cuota = mysql_fetch_array($res_boletas)){
		$i++;
		if ($row_cuota['EstadoBoleta']=='1') $row_cuota['EstadoBoleta'] = 'Vigente';
		else {
			$row_cuota['EstadoBoleta'] = 'Nula';
			$row_cuota['ValorPagado'] = '0';
			}

		array_push($arrRegistros, array('ncorr'			=>	$i,
						'NumeroRutAlumno'	=> 	$row_cuota['NumeroRutAlumno'],
						'dv'				=> 	dv($row_cuota['NumeroRutAlumno']),
						'NumeroBoleta'		=>	$row_cuota['NumeroBoleta'],
						'FechaBoleta'		=> 	$row_cuota['FechaBoleta'],
						'ValorPagado'		=>	$row_cuota['ValorPagado'],
						'EstadoBoleta'		=>	$row_cuota['EstadoBoleta'],
						'Periodo'			=>	$row_cuota['PeriodoMovimiento']
						));
		}

	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_consultas_detalle_boletas_list.tpl'));
		
	return $objResponse->getXML();
	} 

$xajax->registerFunction("CargaPagina");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_consultas_detalle_boletas.tpl');

?>

